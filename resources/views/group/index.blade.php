@extends('layouts.app')
@section('content')
<div id="app-group" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- list -->
            <div v-if="currentView === viewType.list">
                <div v-if="isLogin">
                    <div v-if="groupList.length > 0">
                        <button type="button" style="margin-left:0.4em" class="btn btn-danger pull-right" @click="clickDelete">delete</button>
                    </div>

                    <div v-else-if="groupList.length == 0 && yearMonth">
                        <button type="button" class="btn btn-success pull-right" @click="clickCreate(getYear, getMonth)">new group</button>
                    </div>
                </div>

                <h3>Group List for @{{yearMonth}}</h3>
                <div class="form-group">
                    <input id="date" type="month" v-model="yearMonth">
                    <button type="button" class="btn btn-default btn-sm" @click="yearMonth = getCurrentYearMonth()">this month</button>
                </div>

                <group-list
                    v-if="!isLoading"
                    :group-list="groupList"
                    :year-month="yearMonth">
                </group-list>
            </div>

            <!-- create -->
            <div v-else-if="currentView === viewType.create">
                <modal
                    v-if="showCreateConfirmModal"
                    @submit="submitCreate(getYear, getMonth, generatedGroupList)"
                    @close="showCreateConfirmModal = false">
                    <p slot="header">Are you sure to submit the group for @{{yearMonth}}?</p>
                </modal>

                <h3>Create Group List For <strong>@{{yearMonth}}</strong></h3>
                <div class="form-group">
                    <input type="number" id="generate-group-number" max="100" v-model="groupNumber" placeholder="group number" required>
                    <button type="button" class="btn btn-default btn-success" @click="clickGenerate(getYear, getMonth, groupNumber)" :disabled="isLoading || groupNumber <= 0">
                        <span v-if="generatedGroupList.length > 0">Re-Generate</span>
                        <span v-else>Generate</span>
                    </button>
                    <button v-if="generatedGroupList.length > 0" type="button" class="btn btn-default btn-primary" @click="showCreateConfirmModal = true" :disabled="isLoading">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                        Cancel
                    </button>
                </div>

                <group-list
                    :group-list="generatedGroupList"
                    :year-month="yearMonth">
                </group-list>
            </div>

            <!-- delete -->
            <div v-else-if="currentView === viewType.delete">
                <h3>Delete Group List For @{{yearMonth}}</h3>
                <section>
                    <div style="margin-top: 2em">
                        <p class="text-danger"><strong>Are you sure to delete?</strong></p>
                        <button class="btn btn-default btn-danger" @click="submitDelete(getYear, getMonth)" :disabled="isLoading">
                            Delete
                        </button>
                        <button type="button" class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                            Cancel
                        </button>
                    </div>

                    <div style="margin-top:1em">
                        <group-list
                            :group-list="groupList"
                            :year-month="yearMonth">
                        </group-list>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection
