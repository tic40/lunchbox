@extends('layouts.app')
@section('content')
<div id="position" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- view list -->
            <div v-if="currentView === viewType.list">
                <position-list
                    :positions="positions"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @click-create="clickCreate"
                    @click-edit="clickEdit"
                    @click-delete="clickDelete"
                >
                </position-list>
            </div>

            <!-- view create -->
            <div v-else-if="currentView === viewType.create">
                <position-create
                    :view-type="viewType"
                    :is-login="isLogin"
                    @submit-create="submitCreate"
                    @change-view="changeView"
                >
                </position-create>
            </div>

            <!-- view edit -->
            <div v-else-if="currentView === viewType.edit">
                <position-edit
                    :position="selectedPosition"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @submit-edit="submitEdit"
                    @change-view="changeView"
                >
                </position-edit>
            </div>

            <!-- view delete -->
            <div v-else-if="currentView === viewType.delete">
                <position-delete
                    :position="selectedPosition"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @submit-delete="submitDelete"
                    @change-view="changeView"
                >
                </position-delete>
            </div>

        </div>
    </div>
</div>
@endsection
