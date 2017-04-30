<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GenerateGroup;
use App\Infrastructure\GroupRepository;
use App\Infrastructure\GroupMemberRepository;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $year, int $month)
    {
        return response()->json(
            GroupRepository::getGroupsByTargetDate($year, $month)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $year, int $month, int $groupNumber)
    {
        $generateGroup = new GenerateGroup;
        return response()->json(
            $generateGroup->execute($groupNumber)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $year, int $month)
    {
        \DB::beginTransaction();
        try {
            if (count(GroupRepository::getGroupsByTargetDate($year, $month)) > 0) {
                throw new \Exception('Groups of this month already exists.');
            }
            $resultGroups = GroupRepository::storeGroups($year, $month, $request['groupList']);
            $insertedGroups = GroupRepository::getGroupsByTargetDate($year, $month);
            $resultGroupMembers = GroupMemberRepository::storeGroupMembers($request['groupList'], $insertedGroups);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(
                $e->getMessage()
            );
        }
        return response()->json(
            intval($resultGroups && $resultGroupMembers)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $year, int $month)
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
        return response()->json(
            intval($resultGroupMember && $resultGroup)
        );
    }
}
