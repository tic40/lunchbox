@extends('layouts.app')
@section('content')
<div id="department" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- view list -->
            <div v-if="currentView === viewType.list">
                <department-list
                    :departments="departments"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @click-create="clickCreate"
                    @click-edit="clickEdit"
                    @click-delete="clickDelete"
                >
                </department-list>
            </div>

            <!-- view create -->
            <div v-else-if="currentView === viewType.create">
                <department-create
                    :view-type="viewType"
                    :is-login="isLogin"
                    @submit-create="submitCreate"
                    @change-view="changeView"
                >
                </department-create>
            </div>

            <!-- view edit -->
            <div v-else-if="currentView === viewType.edit">
                <department-edit
                    :department="selectedDepartment"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @submit-edit="submitEdit"
                    @change-view="changeView"
                >
                </department-edit>
            </div>

            <!-- view delete -->
            <div v-else-if="currentView === viewType.delete">
                <department-delete
                    :department="selectedDepartment"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @submit-delete="submitDelete"
                    @change-view="changeView"
                >
                </department-delete>
            </div>

        </div>
    </div>
</div>
@endsection
