<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GenerateGroup;

class GroupController extends Controller
{

    protected $generateService;

    public function __construct(
        GenerateGroup $generateGroup
    ) {
        $this->generateGroup = $generateGroup;
    }

    public function index()
    {
        $groupList = $this->generateGroup->execute();
        return view('group/index', ['groupList' => $groupList]);
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }
}
