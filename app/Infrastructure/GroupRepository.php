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
        $targetDate = (\Carbon\Carbon::now())->setDateTime($year, $month, 1, 0, 0, 0);
        $groups = \App\groups::where('target_date', $targetDate)->get();
        $groupEntities = [];
        foreach ($groups as $group) {
            $groupEntities[] = static::setGroupEntity($group);
        }
        return $groupEntities;
    }

    public static function getMatchingDataByMonthRange(\Carbon\Carbon $targetDate, int $monthRange)
    {
        $to = $targetDate;
        $from = $to->copy()->subMonth($monthRange);
        return \DB::select(
            'select'
            .'     e.id,'
            .'     e.name,'
            .'     e.department_id,'
            .'     e.position_id,'
            .'     gm.is_coordinator,'
            .'     pair.id as pair_id,'
            .'     pair.name as pair_name'
            .' from employees e'
            .' join group_members gm on e.id = gm.employee_id'
            .' join ('
            .'     select gm.group_id, e.id, e.name'
            .'     from employees e'
            .'     join group_members gm on e.id = gm.employee_id'
            .'     join groups g on gm.group_id = g.id'
            .'     where g.target_date between :from and :to'
            .' ) as pair on gm.group_id = pair.group_id order by e.name',
            [
                ':from' => $from,
                ':to' => $to,
            ]
        );
    }

    public static function getCoordinatorCountByMonthRange(\Carbon\Carbon $targetDate, int $monthRange)
    {
        $to = $targetDate;
        $from = $to->copy()->subMonth($monthRange);
        return \DB::select(
            'select'
            .'  e.id, sum(gm.is_coordinator) as total'
            .'  from employees e'
            .'  join group_members gm on e.id = gm.employee_id'
            .'  join groups g on g.id = gm.group_id'
            .'  where g.target_date between :from and :to'
            .'  group by e.id',
            [
                ':from' => $from,
                ':to' => $to,
            ]
        );
    }


    public static function getGroup(int $id)
    {
        $group = \App\groups::find($id);
        return static::setGroupEntity($group);
    }

    public static function storeGroups(int $year, int $month, array $groupList)
    {
        $targetDate = (\Carbon\Carbon::now())->setDateTime($year, $month, 1, 0, 0, 0);
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
        $targetDate = (\Carbon\Carbon::now())->setDateTime($year, $month, 1, 0, 0, 0);
        return \App\groups::where('target_date', $targetDate)->delete();
    }

    private static function setGroupEntity(\App\groups $group)
    {
        $groupEntity = new \App\Entity\Group();
        $groupEntity->id = $group->id;
        $groupEntity->name = $group->name;
        $groupEntity->targetDate = $group->target_date;
        $groupEntity->groupMembers = [];
        foreach ($group->employees as $key => $employee) {
            $groupMemberKey = $key;
            $isCoordinator = 0;
            // better to fix. isCoordinator setting.
            while ($groupMemberKey < count($group->employees)) {
                if ($group->group_members[$groupMemberKey]['employee_id'] === $employee['id']) {
                    $isCoordinator = $group->group_members[$groupMemberKey]['is_coordinator'];
                    break;
                }
                $groupMemberKey++;
            }

            $groupEntity->groupMembers[] = [
                'id' => $employee['id'],
                'name' => $employee['name'],
                'departmentName' => $employee->departments['name'],
                'positionName' => $employee->positions['name'],
                'isCoordinator' => $isCoordinator,
            ];
        }
        return $groupEntity;
    }
}
