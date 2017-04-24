@extends('layouts.app')

@section('content')
<div id="position" class="container" v-cloak>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div v-if="currentView === viewType.list">
                <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new position</button>

                <h3>Position List</h3>
                <div class="form-group">
                    <label for="search-name">search by name </label>
                    <input type="text" id="search-name" v-model="search.name">
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(position, key) in searchByName(positions, search.name)">
                            <th scope="row" v-text="position.id"></th>
                            <td v-text="position.name"></td>
                            <td v-if="isLogin">

                                <button class="btn btn-link" @click="clickEdit(key)">
                                    <span class="text-muted"><i class="fa fa-pencil" aria-hidden="true"></i> edit</span>
                                </button>

                                <!--
                                <button class="btn btn-link" @click="clickDelete(key)">
                                    <span class="text-muted"><i class="fa fa-close" aria-hidden="true"></i> delete</span>
                                </button>
                                -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else-if="currentView === viewType.create">
                <h3>Create Position</h3>
                <section>

                    <form v-on:submit.prevent="submitCreate(newPosition)">
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input class="form-control" id="create-name" v-model="newPosition.name" required/>
                        </div>
                        <button type="submit" class="btn btn-default btn-primary">
                            Submit
                        </button>
                        <p class="btn btn-default" @click="changeView(viewType.list)">
                            Cancel
                        </p>
                    </form>
                </section>
            </div>

            <div v-else-if="currentView === viewType.edit">
                <h3>Edit Position</h3>
                <section>
                    <form v-on:submit.prevent="submitEdit(selectedPosition)">
                        <div class="form-group">
                            <label for="edit-id">Id</label>
                            <input class="form-control" id="edit-id" v-model="selectedPosition.id" disabled>
                        </div>
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input class="form-control" id="edit-name" v-model="selectedPosition.name" required/>
                        </div>

                        <button type="submit" class="btn btn-default btn-primary">
                            Submit
                        </button>
                        <p class="btn btn-default" @click="changeView(viewType.list)">
                            Cancel
                        </p>
                    </form>
                </section>
            </div>

            <div v-else-if="currentView === viewType.delete">
                <h3>Delete Position</h3>
                <section>
                    <p class="text-danger">Are you sure to delete?</p>

                    <p>id: @{{selectedPosition.id}}</p>
                    <p>name: @{{selectedPosition.name}}</p>

                    <button class="btn btn-default btn-primary" @click="submitDelete(selectedPosition)">
                        Submit
                    </button>
                    <p class="btn btn-default" @click="changeView(viewType.list)">
                        Cancel
                    </p>
                </section>
            </div>

        </div>
    </div>
</div>
@endsection
