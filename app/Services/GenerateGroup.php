<?php

namespace App\Services;

use \App\Entity\Employee;
use \App\Infrastructure\EmployeeRepository;
use \App\Infrastructure\GroupRepository;

class GenerateGroup
{
    // matching score weight
    const SCORES = [
        'samePosition' => 1,
        'sameDepartment' => 2,
        'alreadyMatched' => 3,
    ];
    const REFERENCE_MONTH_RANGE = 12;

    // employee entities
    protected $employees;
    protected $groupNumber;

    public function __construct(array $employees)
    {
        $ary = [];
        foreach ($employees as $employee) {
            $ary[$employee->id] = $employee;
        }
        $this->employees = $ary;
    }

    public function execute(int $groupNumber, int $year, int $month)
    {
        $this->setGroupNumber($groupNumber);
        $this->setTargetDate($year, $month);
        $groupList = $this->createGroupList();

        foreach ($groupList as $key => $group) {
            $groupList[$key] = ['groupMembers' => $group];
            $groupList[$key]['name'] = $this->generateGroupName($key);
        }

        arsort($groupList);
        $sorted = [];
        foreach ($groupList as $group) {
            $sorted[] = $group;
        }
        return $sorted;
    }

    public function generateGroupName(int $num)
    {
        // alphabet: ex: A, B, C...Z, AA, AB..
        return (0 < intval($num/26))
            ? chr(65 + intval($num / 26)) . chr(65 + ($num % 26))
            : chr(65 + ($num % 26));
    }

    public function isSameDepartment(Employee $emp1, Employee $emp2)
    {
        return $emp1->departmentId === $emp2->departmentId;
    }

    public function isSamePosition(Employee $emp1, Employee $emp2)
    {
        return $emp1->positionId === $emp2->positionId;
    }

    public function setGroupNumber(int $groupNumber)
    {
        $this->groupNumber = (count($this->employees) < $groupNumber)
            ? count($this->employees)
            : $groupNumber;
    }

    public function setTargetDate(int $year, int $month)
    {
        $this->targetDate = \Carbon\Carbon::create($year, $month, 1);
    }

    public function calcMatchingScore()
    {
        foreach ($this->employees as $key => $employee) {
            $scores = [];
            foreach ($this->employees as $target) {
                $score = 0;
                if ($this->isSamePosition($employee, $target)) {
                    $score += self::SCORES['samePosition'];
                }
                if ($this->isSameDepartment($employee, $target)) {
                    $score += self::SCORES['sameDepartment'];
                }
                $scores[$target->id] = $score;
            }
            $this->employees[$key]->matchingScore = $scores;
        }
        $matchingData = GroupRepository::getMatchingDataByMonthRange($this->targetDate, self::REFERENCE_MONTH_RANGE);
        foreach ($matchingData as $v) {
            $this->employees[$v->id]->matchingScore[$v->pair_id] += self::SCORES['alreadyMatched'];
        }
    }

    public function calcNumberOfLeader()
    {
        foreach ($this->employees as $v) {
            $v->numberOfLeader = 0;
        }
        $numberOfLeader = groupRepository::getNumberOfLeaderByMonthRange($this->targetDate, self::REFERENCE_MONTH_RANGE);
        foreach ($numberOfLeader as $v) {
            $this->employees[$v->id]->numberOfLeader = $v->total;
        }
    }

    public function createGroupList()
    {
        $this->calcMatchingScore();
        $this->calcNumberOfLeader();
        shuffle($this->employees);

        $groupList = [];
        $i = 0;
        $num = 1;
        foreach ($this->employees as $employee) {
            if ($this->groupNumber <= $i) {
                $i = 0;
                $num++;
            }

            if ($num === 1) {
                $groupList[$i] = [];
                $listKey = $i;
            } else {
                $min = null;
                foreach ($groupList as $k1 => $group) {
                    if ($num <= count($group)) {
                        continue;
                    }
                    $totalScore = 0;
                    foreach ($group as $k2 => $member) {
                        $totalScore += $member->matchingScore[$employee->id];
                    }
                    if ($min === null || $totalScore < $min) {
                        $listKey = $k1;
                        $min = $totalScore;
                        if ($min === 0) { break; }
                    }
                }
            }
            $groupList[$listKey][] = $employee;
            $i++;
        }

        $groupList = $this->decideGroupLeader($groupList);
        return $groupList;
    }

    public function decideGroupLeader(array $groupList)
    {
        foreach ($groupList as $groupListKey => $group) {
            $min = null;
            $leaderKey = 0;
            $members = [];
            foreach ($group as $groupKey => $member) {
                $member->isLeader = 0;
                if ($min === null || $member->numberOfLeader < $min) {
                    $min = $member->numberOfLeader;
                    $leaderKey = $groupKey;
                    if ($min === 0) {
                        break;
                    }
                }
            }
            $groupList[$groupListKey][$leaderKey]->isLeader = 1;
            if ($leaderKey !== 0) {
                list ($groupList[$groupListKey][0], $groupList[$groupListKey][$leaderKey]) = [ $groupList[$groupListKey][$leaderKey], $groupList[$groupListKey][0] ];
            }
        }
        return $groupList;
    }
}
