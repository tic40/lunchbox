<?php

namespace App\Services;

use \App\Entity\Employee;
use \App\Infrastructure\EmployeeRepository;

class GenerateGroup
{
    private $groupsCount;

    public function execute(int $groupNumber): array
    {
        $employeeEntities = EmployeeRepository::getEmployees();
        $groupList = [];
        for($i = 0; $i < $groupNumber; $i++) {
            $groupList[$i] = [];
        }

        shuffle($employeeEntities);
        $i = 0;
        foreach($employeeEntities as $employee) {
            if ($groupNumber <= $i) { $i = 0; }
            array_push($groupList[$i], $employee);
            $i++;
        }

        $returnList = [];
        foreach($groupList as $groupListKey => $group) {
            foreach($group as $groupKey => $member) {
                $returnList[$groupListKey]['name'] = $groupListKey+1;
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
