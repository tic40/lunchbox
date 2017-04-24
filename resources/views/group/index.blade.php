@extends('layouts.app')

@section('content')
<div id="group" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <label>Month:
                <input id="date" type="month" name="month" value="" />
            </label>

            <button type="button" class="btn btn-success" onclick="alert('グループが生成される');">generate</button>
            <button type="button" class="btn btn-danger" onclick="alert('グループを削除する');">delete</button>

            <h3>Group List</h3>

            @foreach ($groupList as $group)
                <ul class="list-group">
                    @foreach ($group as $employee)
                        <li class="list-group-item">
                            {{ $employee->name }}
                            @if ($loop->first)
                                <i class="fa fa-star-o text-success" aria-hidden="true"></i></li>
                            @endif
                    @endforeach
                </ul>
            @endforeach

        </div>
    </div>
</div>
@endsection
