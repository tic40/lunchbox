@extends('layouts.app')

@section('content')
<div id="group" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div v-if="currentView === viewType.list">

                <!-- actions -->
                <div v-if="isLogin">

                    <div v-if="groupList">
                        <button type="button" class="btn btn-success" @click="clickReCreate(getYear, getMonth)">re-create</button>
                        <button type="button" class="btn btn-danger" @click="clickDelete">delete</button>
                    </div>

                    <div v-else>
                        <button type="button" class="btn btn-success" @click="clickCreate(getYear, getMonth)">
                            create
                        </button>
                    </div>
                </div>

                <h3>Group List of <input id="date" type="month" v-model="yearMonth" :value="getCurrentYearMonth" /></h3>
                    <div v-if="groupList">
                        <group-list :group-list="groupList"></group-list>
                    </div>

                    <div v-else>
                        <div class="alert alert-warning" key="emptyGroupList">
                            The group of this month has not been generated yet.
                            <p v-if="isLogin">Please create group of the month.</p>
                        </div>
                    </div>
            </div>

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
