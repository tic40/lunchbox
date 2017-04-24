<?php

namespace App\Services;

use \App\Entity\Employee;
use \App\Infrastructure\EmployeeRepository;

class GenerateGroup
{
    private $groupsCount;

    public function execute()
    {
        $employeeEntities = EmployeeRepository::getEmployees();

        $groupList = [];
        $group = [];
        $i = 0;
        foreach($employeeEntities as $employee) {
            if (4 <= count($group)) {
                array_push($groupList, $group);
                $group = [];
            }
            array_push($group, $employee);
        }

        return $groupList;
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
