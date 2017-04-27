<?php
namespace App\Infrastructure;

class GroupRepository
{
    public static function getGroups()
    {
        $groups = \App\groups::all();
        $groupEntities = [];
        foreach ($groups as $group) {
            $groupEntities[] = static::setGroupEntity($group);
        }
        return $groupEntities;
    }

    public static function getGroupsByTargetDate(int $year, int $month)
    {
        $targetDate = \Carbon\Carbon::create($year, $month, 1);
        $groups = \App\groups::where('target_date', $targetDate->format('Y-m-d'))
            ->get();


/*
        $groups = \App\groups::join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->join('employees', 'group_members.employee_id', '=', 'employees.id')
            ->where('groups.target_date', $targetDate->format('Y-m-d'))
            ->get();
        return $groups;
*/

        $groupEntities = [];
        foreach ($groups as $group) {
            $groupEntities[] = static::setGroupEntity($group);
        }
        return $groupEntities;
    }

    public static function getGroup(int $id) {
        $group = \App\groups::find($id);
        return static::setGroupEntity($group);
    }

    public static function storeGroup($request) {
        $group = new \App\groups;
        $group->name = $request['name'];
        $group->targetDate = $request['target_date'];
        return $group->save();
    }

/*
    public static function updateGroup($request, int $id) {
        $group = \App\groups::find($id);
        $group->name = $request['name'];
        return $group->save();
    }
*/

    public static function deleteGroup(int $id) {
        $group = \App\groups::find($id);
        return $group->delete();
    }

    private static function setGroupEntity(\App\groups $group)
    {
        $groupEntity = new \App\Entity\Group();
        $groupEntity->id = $group->id;
        $groupEntity->name = $group->name;
        $groupEntity->targetDate = $group->target_date;
        $groupEntity->groupMembers = [];
        foreach($group->group_members as $member) {
            $groupEntity->groupMembers[] = $member;
        }
        return $groupEntity;
    }
}
