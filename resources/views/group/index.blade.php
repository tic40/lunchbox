@extends('layouts.app')
@section('content')
<div id="group" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- list -->
            <div v-if="currentView === viewType.list">
                <div v-if="isLogin">
                    <div v-if="groupList.length > 0">
                        <button type="button" style="margin-left:0.4em" class="btn btn-danger pull-right" @click="clickDelete">delete</button>
                    </div>

                    <div v-else-if="groupList.length == 0 && yearMonth">
                        <button type="button" class="btn btn-success pull-right" @click="clickCreate(getYear, getMonth)">create</button>
                    </div>
                </div>

                <h3>Group List of <input id="date" type="month" v-model="yearMonth"></h3>
                <group-list
                    :group-list="groupList"
                    :year-month="yearMonth">
                </group-list>
            </div>

            <!-- create -->
            <div v-else-if="currentView === viewType.create">
                <h3>Create Group List For <strong>@{{yearMonth}}</strong></h3>
                <form v-on:submit.prevent="submitCreate()">

                    <div class="form-group">
                        <label for="generate-group-number">group number</label>
                        <input type="number" id="generate-group-number" v-model="groupNumber">
                        <button type="button" class="btn btn-default btn-success" @click="clickGenerate(getYear, getMonth, groupNumber)" :disabled="isLoading || groupNumber <= 0">
                            Generate
                        </button>
                    </div>

                    <button type="submit" class="btn btn-default btn-primary" :disabled="isLoading || !generatedGroupList">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                        Cancel
                    </button>
                </form>
                <div style="margin-top:2em">
                    <group-list :group-list="generatedGroupList"></group-list>
                </div>
            </div>

            <!-- delete -->
            <div v-else-if="currentView === viewType.delete">
                <h3>Create Group List For <strong>@{{yearMonth}}</strong></h3>
                <section>
                    <strong class="text-danger">Are you sure to delete?</strong>

                    <div style="margin-top: 1em">
                        todo: display target group list information here.
                    </div>

                    <div style="margin-top: 2em">
                        <button class="btn btn-default btn-primary" @click="submitDelete()" :disabled="isLoading">
                            Submit
                        </button>
                        <button type="button" class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                            Cancel
                        </button :disabled="isLoading">
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection
