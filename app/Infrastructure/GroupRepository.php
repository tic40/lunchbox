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
        $groupEntities = [];
        foreach ($groups as $group) {
            $groupEntities[] = static::setGroupEntity($group);
        }
        return $groupEntities;
    }

    public static function getGroupsByTargetDateRange()
    {
    }

    public static function getGroup(int $id)
    {
        $group = \App\groups::find($id);
        return static::setGroupEntity($group);
    }

    public static function storeGroups(int $year, int $month, array $groupList)
    {
        $targetDate = \Carbon\Carbon::create($year, $month, 1);
        $insertion = [];
        foreach ($groupList as $v) {
            $insertion[] = [
                'name' => $v['name'],
                'target_date' => $targetDate->format('Y-m-d'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        return \App\groups::insert($insertion);
    }

    public static function deleteGroupsByTargetDate(int $year, int $month)
    {
        $targetDate = \Carbon\Carbon::create($year, $month, 1);
        return \App\groups::where('target_date', $targetDate->format('Y-m-d'))
            ->delete();
    }

    private static function setGroupEntity(\App\groups $group)
    {
        $groupEntity = new \App\Entity\Group();
        $groupEntity->id = $group->id;
        $groupEntity->name = $group->name;
        $groupEntity->targetDate = $group->target_date;
        $groupEntity->groupMembers = [];
        foreach ($group->employees as $key => $employee) {
            $member = [];
            $member['name'] = $employee['name'];
            $member['departmentName'] = $employee->departments['name'];
            $member['positionName'] = $employee->positions['name'];
            $member['isLeader'] = $employee->group_members['is_leader'];
            $groupEntity->groupMembers[] = $member;
        }
        return $groupEntity;
    }
}
