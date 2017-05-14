<?php

namespace App\Services;

use App\Entity\Employee;
use App\Infrastructure\GroupRepository;
use App\Infrastructure\GroupMemberRepository;

class Group
{
    public static function storeGroups(array $groupList, int $year, int $month)
    {
        \DB::beginTransaction();
        try {
            if (count(GroupRepository::getGroupsByTargetDate($year, $month)) > 0) {
                throw new \Exception('Groups of this month already exists.');
            }
            $resultGroups = GroupRepository::storeGroups($year, $month, $groupList);
            $insertedGroups = GroupRepository::getGroupsByTargetDate($year, $month);
            $resultGroupMembers = GroupMemberRepository::storeGroupMembers($groupList, $insertedGroups);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(
                $e->getMessage()
            );
        }
        return true;
    }

    public static function destroyGroups(int $year, int $month)
    {
        \DB::beginTransaction();
        try {
            $resultGroupMember = GroupMemberRepository::deleteGroupMembersByTargetDate($year, $month);
            $resultGroup = GroupRepository::deleteGroupsByTargetDate($year, $month);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(
                $e->getMessage()
            );
        }
        return true;
    }
}
