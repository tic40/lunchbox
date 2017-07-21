<?php

namespace App\Http\Controllers\Password;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $authUser = \Auth::user();
        $params = $request->all();

        $error = false;
        if ($params['password'] !== $params['password_confirmation']) {
            // return error. different between password and password_confirmation
            $error = true;
            \Log::info('different');
        }
        if (Hash::check($params['password_current'], $authUser->password) === false) {
            // return error. input correct password
            $error = true;
            \Log::info('incorrect');
        }
        if (Hash::check($params['password'], $authUser->password)) {
            // return error. same password
            $error = true;
            \Log::info('same password');
        }

        $user = User::find($authUser->id);
        $user->password = bcrypt($params['password']);
        $result = $user->save();

        if ($error === true || $result === 0) {
            return view('password/change/index');
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
