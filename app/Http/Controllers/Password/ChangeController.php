<?php

namespace App\Http\Controllers\Password;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('password/change/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $params = $request->all();
        $user = \Auth::user();
        $this->validate($request, [
            'password_current' => 'required|password_current:' . $user->password,
            'password' => 'required|min:5|max:255',
            'password_confirmation' => 'required|password_confirmation:' . $params['password'],
        ]);

        // set new password
        $user->password = bcrypt($params['password']);
        if ($user->save() === false) {
            // error
            return view('password/change/index', ['error' => 'Failed to change password. Try it again please.']);
        }
        return view('password/change/update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
