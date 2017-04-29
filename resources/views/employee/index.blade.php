@extends('layouts.app')
@section('content')
<div id="employee" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- list -->
            <div v-if="currentView === viewType.list">
                <employee-list
                    v-if="!isLoading"
                    :employees="employees"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @set-selected-employee="setSelectedEmployee"
                    @change-view="changeView">
                </employee-list>
            </div>

            <!-- create -->
            <div v-else-if="currentView === viewType.create">
                <employee-create
                    :departments="departments"
                    :positions="positions"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </employee-create>
            </div>

            <!-- edit -->
            <div v-else-if="currentView === viewType.edit">
                <employee-edit
                    :employee="selectedEmployee"
                    :departments="departments"
                    :positions="positions"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </employee-edit>
            </div>

            <!-- delete -->
            <div v-else-if="currentView === viewType.delete">
                <employee-delete
                    :employee="selectedEmployee"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </employee-delete>
            </div>

        </div>
    </div>
</div>
@endsection
