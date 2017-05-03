<?php

namespace App\Services;

use \App\Entity\Employee;
use \App\Infrastructure\EmployeeRepository;
use \App\Infrastructure\GroupRepository;

class GenerateGroup
{
    public function execute(int $groupNumber)
    {
        $employeeEntities = EmployeeRepository::getEmployees();
        if (count($employeeEntities) < $groupNumber) {
            $groupNumber = count($employeeEntities);
        }
        $ary = [];
        foreach ($employeeEntities as $employee) {
            $ary[$employee->id] = $employee;
        }
        $employeeEntities = $ary;

        foreach ($employeeEntities as $key => $employee) {
            $matchingScore = [];
            foreach ($employeeEntities as $target) {
                $weight = 0;
                // same position
                if ($target->positionId == $employee->positionId) {
                    $weight += 1;
                }
                // same department
                if ($target->departmentId == $employee->departmentId) {
                    $weight += 2;
                }
                $matching[$target->id] = $weight;
            }
            $employeeEntities[$key]->matching = $matching;
        }

        $matching = GroupRepository::getGroupsMatchingByTargetDateRange(6);
        foreach ($matching as $pair) {
            // already matched within 6 month
            $employeeEntities[$pair->id]->matching[$pair->pair_id] += 2;
        }

        shuffle($employeeEntities);
        $i = 0;
        $groupList = [];
        $employees = $employeeEntities;
/*
        while ($i < count($employees)) {
            if ($groupNumber <= $i) {
                $i = 0;
            }
            if (isset($groupList[$i]) === false) {
                $groupList[$i] = [];
            }

            if (count($groupList[$i]) > 0) {
                foreach($employees as $candidate) {
                    $totalWeight = 0;
                    foreach ($groupList[$i] as $groupMember) {
                        $totalWeight += $groupMember->matching[$candidate->id];
                    }
                }
                $member = $candidate;
            } else { $member = reset($employees); }
            array_push($groupList[$i], $member);

            unset($employees[$member->id]);
            $i++;
        }
*/

        foreach ($employeeEntities as $employee) {
            if ($groupNumber <= $i) {
                $i = 0;
            }
            if (isset($groupList[$i]) === false) {
                $groupList[$i] = [];
            }
            if (count($groupList[$i]) > 0) {

            }

            array_push($groupList[$i], $employee);
            $i++;
        }

        $returnList = [];
        foreach ($groupList as $groupListKey => $group) {
            foreach ($group as $groupKey => $member) {
                // create group name by alphabet pattern
                $groupName = (0 < intval($groupListKey/26))
                    ? chr(65+intval($groupListKey/26)) . chr(65+($groupListKey%26))
                    : chr(65+($groupListKey%26));

                $returnList[$groupListKey]['name'] = $groupName;
                $member->isLeader = ($groupKey == 0) ? 1 : 0;
                $returnList[$groupListKey]['groupMembers'][] = $member;
            }
        }
        return $returnList;
    }

    public function isSameDepartment(Employee $emp1, Employee $emp2)
    {
        return $emp1->getDepartmentId() === $emp2->getDepartmentId();
    }

    public function isSameTeam(Employee $emp1, Employee $emp2)
    {
        return $emp1->getTeamId() === $emp2->getTeamId();
    }

    public function isSamePosition(Employee $emp1, Employee $emp2)
    {
        return $emp1->getTeamId() === $emp2->getTeamId();
    }
}
