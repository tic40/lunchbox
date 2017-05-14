<?php

namespace App\Services;

use \App\Entity\Employee;
use \App\Infrastructure\EmployeeRepository;
use \App\Infrastructure\GroupRepository;

class GenerateGroup
{
    // matching score weight
    //  - samePosition < sameDepartment < alreadyMatched
    //  - samePosition + sameDepartment < alreadyMatched
    const SCORES = [
        'samePosition' => 1,
        'sameDepartment' => 2,
        'alreadyMatched' => 4,
    ];
    const REFERENCE_MONTH_RANGE = 12;

    // @var array of \App\Entity\Employee
    protected $employees;
    // @var int
    protected $groupNumber;
    // @var array matching score for each member
    protected $matchingScores;
    // @var array how many time each employee become coordinator.
    protected $numberOfCoordinator;

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

        asort($groupList);
        $sortedGroupList = [];
        foreach ($groupList as $group) {
            $sortedGroupList[] = $group;
        }

        foreach ($sortedGroupList as $key => $group) {
            $sortedGroupList[$key] = [
                'groupMembers' => $group,
                'name' => $this->generateGroupName($key),
            ];
        }
        return $sortedGroupList;
    }

    public function calcMatchingScore()
    {
        $this->matchingScores = [];
        foreach ($this->employees as $key => $employee) {
            $scores = [];
            foreach ($this->employees as $target) {
                $score = 0;
                // same position
                if ($this->isSamePosition($employee, $target)) {
                    $score += self::SCORES['samePosition'];
                }
                // same department
                if ($this->isSameDepartment($employee, $target)) {
                    $score += self::SCORES['sameDepartment'];
                }
                $scores[$target->id] = $score;
            }
            $this->matchingScores[$employee->id] = $scores;
        }
        $matchingData = GroupRepository::getMatchingDataByMonthRange($this->targetDate, self::REFERENCE_MONTH_RANGE);
        foreach ($matchingData as $v) {
            // already matched within REFERENCE_MONTH_RANGE
            $this->matchingScores[$v->id][$v->pair_id] += self::SCORES['alreadyMatched'];
        }
    }

    public function createGroupList()
    {
        $this->calcMatchingScore();
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
                        $totalScore += $this->matchingScores[$member->id][$employee->id];
                    }
                    if ($min === null || $totalScore < $min) {
                        $listKey = $k1;
                        $min = $totalScore;
                        if ($totalScore === 0) {
                            break;
                        }
                    }
                }
            }
            $groupList[$listKey][] = $employee;
            $i++;
        }

        $groupList = $this->decideGroupCoordinator($groupList);
        return $groupList;
    }

    public function decideGroupCoordinator(array $groupList)
    {
        $this->calcNumberOfCoordinator();
        foreach ($groupList as $groupListKey => $group) {
            $min = null;
            $CoordinatorKey = 0;
            $members = [];
            foreach ($group as $groupKey => $member) {
                $groupList[$groupListKey][$groupKey]->isCoordinator = 0;
                if ($min === null || $this->numberOfCoordinator[$member->id] < $min) {
                    $min = $this->numberOfCoordinator[$member->id];
                    $CoordinatorKey = $groupKey;
                }
            }
            $groupList[$groupListKey][$CoordinatorKey]->isCoordinator = 1;
            if ($CoordinatorKey !== 0) {
                list ($groupList[$groupListKey][0], $groupList[$groupListKey][$CoordinatorKey]) = [ $groupList[$groupListKey][$CoordinatorKey], $groupList[$groupListKey][0] ];
            }
        }
        return $groupList;
    }

    public function calcNumberOfCoordinator()
    {
        $this->numberOfCoordinator = [];
        foreach ($this->employees as $v) {
            $this->numberOfCoordinator[$v->id] = 0;
        }

        $dataNumberOfCoordinator = groupRepository::getNumberOfCoordinatorByMonthRange($this->targetDate, self::REFERENCE_MONTH_RANGE);
        foreach ($dataNumberOfCoordinator as $v) {
            $this->numberOfCoordinator[$v->id] = intval($v->total);
        }
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
        $this->targetDate = \Carbon\Carbon::create($year, $month)->firstOfMonth();
    }
}
