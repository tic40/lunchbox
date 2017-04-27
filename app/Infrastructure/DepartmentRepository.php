<?php
namespace App\Infrastructure;

class DepartmentRepository
{
    public static function getDepartments()
    {
        $departments = \App\departments::all();
        $departmentEntities = [];
        foreach ($departments as $department) {
            $departmentEntities[] = static::setDepartmentEntity($department);
        }
        return $departmentEntities;
    }

    public static function getDepartment(int $id) {
        $department = \App\departments::find($id);
        return static::setDepartmentEntity($department);
    }

    public static function storeDepartment($request) {
        $department = new \App\departments;
        $department->name = $request['name'];
        return $department->save();
    }

    public static function updateDepartment($request, int $id) {
        $department = \App\departments::find($id);
        $department->name = $request['name'];
        return $department->save();
    }

    public static function deleteDepartment(int $id) {
        $department = \App\departments::find($id);
        return $department->delete();
    }

    private static function setDepartmentEntity(\App\departments $department)
    {
        $departmentEntity = new \App\Entity\Department();
        $departmentEntity->id = $department->id;
        $departmentEntity->name = $department->name;
        return $departmentEntity;
    }
}
