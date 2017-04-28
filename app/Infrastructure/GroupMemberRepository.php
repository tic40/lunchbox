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

    public static function getGroupMember(int $id) {
        $groupMember = \App\group_members::find($id);
        return static::setGroupMemberEntity($groupMember);
    }

    public static function storeGroupMember($request) {
        $groupMember = new \App\group_members;
        $groupMember->name = $request['name'];
        return $groupMember->save();
    }

    public static function updateGroupMember($request, int $id) {
        $groupMember = \App\group_members::find($id);
        $groupMember->name = $request['name'];
        return $groupMember->save();
    }

    public static function deleteGroupMember(int $id) {
        $groupMember = \App\group_members::find($id);
        return $groupMember->delete();
    }

    private static function setGroupMemberEntity(\App\group_members $groupMember)
    {
        $groupMemberEntity = new \App\Entity\GroupMember();
        $groupMemberEntity->id = $groupMember->id;
        $groupMemberEntity->name = $groupMember->name;
        return $groupMemberEntity;
    }
}
