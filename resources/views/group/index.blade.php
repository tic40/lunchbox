@extends('layouts.app')

@section('content')
<div id="group" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div v-if="isLogin">
                <button type="button" class="btn btn-success" @click="clickGenerate(date.year, date.month)">generate</button>
                <button type="button" class="btn btn-danger" @click="clickDelete">delete</button>
            </div>

            <h3>Group List</h3>
            <label>Month:
                <input id="date" type="month" name="month" />
            </label>

            <ul v-for="(group, listKey) in groupList" class="list-group">
                <li v-for="(employee, groupKey) in group" class="list-group-item">
                    @{{employee.name}}
                    <i v-if="groupKey == 0" class="fa fa-star-o text-success" aria-hidden="true"></i>
                </li>
            </ul>

        </div>
    </div>
</div>
@endsection
