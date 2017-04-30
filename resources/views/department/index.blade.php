@extends('layouts.app')
@section('content')
<div id="app-department" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- list -->
            <div v-if="currentView === viewType.list">
                <department-list
                    v-if="!isLoading"
                    :departments="departments"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @set-selected-department="setSelectedDepartment"
                    @change-view="changeView">
                </department-list>
            </div>

            <!-- create -->
            <div v-else-if="currentView === viewType.create">
                <department-create
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </department-create>
            </div>

            <!-- edit -->
            <div v-else-if="currentView === viewType.edit">
                <department-edit
                    :department="selectedDepartment"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </department-edit>
            </div>

            <!-- delete -->
            <div v-else-if="currentView === viewType.delete">
                <department-delete
                    :department="selectedDepartment"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </department-delete>
            </div>

        </div>
    </div>
</div>
@endsection
