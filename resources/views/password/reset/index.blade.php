@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>Password Reset</h1>
        <p>
            Please contact to the Administrator.
        <p>
        <table class="table">
            <tr>
                <th>admin name</th>
                <th>email</th>
            </tr>
            <td>{{$adminName}}</td>
            <td>{{$adminContact}}</td>
        </table>
    </div>
</div>
@endsection
