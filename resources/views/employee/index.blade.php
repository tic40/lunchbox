@extends('layouts.app')
@section('content')
<div id="employee" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- list view -->
            <div v-if="currentView === viewType.list">
                <employee-list
                    :employees="employees"
                    :is-login="isLogin"
                    @click-create="clickCreate"
                    @click-edit="clickEdit"
                    @click-delete="clickDelete">
                </employee-list>
            </div>

            <!-- create view -->
            <div v-else-if="currentView === viewType.create">
                <employee-create
                    :departments="departments"
                    :positions="positions"
                    :is-loading="isLoading"
                    :view-type="viewType"
                    @submit-create="submitCreate"
                    @change-view="changeView"
                >
                </employee-create>
            </div>

            <!-- edit view -->
            <div v-else-if="currentView === viewType.edit">
                <employee-edit
                    :employee="selectedEmployee"
                    :departments="departments"
                    :positions="positions"
                    :is-loading="isLoading"
                    :view-type="viewType"
                    @submit-edit="submitEdit"
                    @change-view="changeView"
                >
                </employee-edit>
            </div>

            <!-- delete view -->
            <div v-else-if="currentView === viewType.delete">
                <employee-delete
                    :employee="selectedEmployee"
                    :is-loading="isLoading"
                    :view-type="viewType"
                    @submit-delete="submitDelete"
                    @change-view="changeView"
                >
                </employee-delete>
            </div>

        </div>
    </div>
</div>
@endsection
