<?php
namespace App\Infrastructure;

class GroupMemberRepository
{
    public static function getGroupMembers()
    {
        $group_members = \App\group_members::all();
        $groupMemberEntities = [];
        foreach ($group_members as $groupMember) {
            $groupMemberEntities[] = static::setGroupMemberEntity($groupMember);
        }
        return $groupMemberEntities;
    }

    public static function getGroupMember(int $id)
    {
        $groupMember = \App\group_members::find($id);
        return static::setGroupMemberEntity($groupMember);
    }

    public static function storeGroupMembers(array $groupList, array $insertedGroups)
    {
        $insertion = [];
        foreach ($groupList as $groupListKey => $group) {
            foreach ($group['groupMembers'] as $member) {
                $insertion[] = [
                    'group_id' => $insertedGroups[$groupListKey]->id,
                    'employee_id' => $member['id'],
                    'is_coordinator' => $member['isCoordinator'],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ];
            }
        }
        return \App\group_members::insert($insertion);
    }

    public static function updateGroupMember($request, int $id)
    {
        $groupMember = \App\group_members::find($id);
        $groupMember->name = $request['name'];
        return $groupMember->save();
    }

    public static function deleteGroupMembersByTargetDate(int $year, int $month)
    {
        $targetDate = \Carbon\Carbon::create($year, $month)->firstOfMonth();
        return \App\group_members::join('groups', 'group_members.group_id', '=', 'groups.id')
            ->where('groups.target_date', $targetDate->format('Y-m-d'))
            ->delete();
    }

    private static function setGroupMemberEntity(\App\group_members $groupMember)
    {
        $groupMemberEntity = new \App\Entity\GroupMember();
        $groupMemberEntity->id = $groupMember->id;
        $groupMemberEntity->name = $groupMember->name;
        return $groupMemberEntity;
    }
}
