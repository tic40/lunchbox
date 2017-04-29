@extends('layouts.app')
@section('content')
<div id="position" class="container" v-cloak>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- list -->
            <div v-if="currentView === viewType.list">
                <position-list
                    v-if="!isLoading"
                    :positions="positions"
                    :view-type="viewType"
                    :is-login="isLogin"
                    @set-selected-position="setSelectedPosition"
                    @change-view="changeView">
                </position-list>
            </div>

            <!-- create -->
            <div v-else-if="currentView === viewType.create">
                <position-create
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </position-create>
            </div>

            <!-- edit -->
            <div v-else-if="currentView === viewType.edit">
                <position-edit
                    :position="selectedPosition"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </position-edit>
            </div>

            <!-- delete -->
            <div v-else-if="currentView === viewType.delete">
                <position-delete
                    :position="selectedPosition"
                    :view-type="viewType"
                    :is-loading="isLoading"
                    @loading="loading"
                    @change-view="changeView">
                </position-delete>
            </div>

        </div>
    </div>
</div>
@endsection
