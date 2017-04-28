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
        $groups = GroupRepository::getGroupsByTargetDate($year, $month);
        $targetDate = \Carbon\Carbon::create($year, $month, 1);
        $current = \Carbon\Carbon::now();
        $current->day = 1;
        $canEdit = ($targetDate < $current) ? 1 : 0;

        return response()->json(
            [
                'groupList' => $groups,
                'canEdit' => $canEdit,
            ]
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
    public function store(int $year, int $month, Request $request)
    {
        $targetDate = \Carbon\Carbon::create($year, $month, 1);
/*
        $group_members = $request[];
        $group_members = $request[];
*/
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
        //
    }
}
