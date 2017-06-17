<?php
namespace App\Infrastructure;

class EmployeeRepository
{
    public static function getEmployees(bool $onlyActive = false)
    {
        $employees = $onlyActive === false
            ? $employees = \App\employees::all()
            : $employees = \App\employees::where('is_temporary_absence', 0)->get();
        $employeeEntities = [];
        foreach ($employees as $employee) {
            $employeeEntities[] = static::setEmployeeEntity($employee);
        }
        return $employeeEntities;
    }

    public static function getEmployee(int $id)
    {
        $employee = \App\employees::find($id);
        return static::setEmployeeEntity($employee);
    }

    public static function storeEmployee($request)
    {
        $employee = new \App\employees;
        $employee->name = $request['name'];
        $employee->department_id = $request['department_id'];
        $employee->position_id = $request['position_id'];
        return $employee->save();
    }

    public static function updateEmployee($request, int $id)
    {
        $employee = \App\employees::find($id);
        $employee->name = $request['name'];
        $employee->department_id = $request['department_id'];
        $employee->position_id = $request['position_id'];
        $employee->is_temporary_absence = $request['is_temporary_absence'];
        return $employee->save();
    }

    public static function deleteEmployee(int $id)
    {
        $employee = \App\employees::find($id);
        return $employee->delete();
    }

    private static function setEmployeeEntity(\App\employees $employee)
    {
        $employeeEntity = new \App\Entity\Employee();
        $employeeEntity->id = $employee->id;
        $employeeEntity->name = $employee->name;
        $employeeEntity->departmentId = $employee->department_id;
        $employeeEntity->departmentName = $employee->departments->name;
        $employeeEntity->positionId = $employee->position_id;
        $employeeEntity->positionName = $employee->positions->name;
        $employeeEntity->isTemporaryAbsence = $employee->is_temporary_absence;
        $employeeEntity->deletedAt = $employee->deleted_at;
        $employeeEntity->createdAt = $employee->created_at;
        $employeeEntity->updatedAt = $employee->updated_at;

        return $employeeEntity;
    }
}
