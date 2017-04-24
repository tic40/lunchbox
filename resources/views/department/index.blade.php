@extends('layouts.app')

@section('content')
<div id="department" class="container" v-cloak>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div v-if="currentView === viewType.list">
                <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new department</button>

                <h3>Department List</h3>
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
                        <tr v-for="(department, key) in searchByName(departments, search.name)">
                            <th scope="row" v-text="department.id"></th>
                            <td v-text="department.name"></td>
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
                <h3>Create Department</h3>
                <section>

                    <form v-on:submit.prevent="submitCreate(newDepartment)">
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input class="form-control" id="create-name" v-model="newDepartment.name" required/>
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
                <h3>Edit Department</h3>
                <section>
                    <form v-on:submit.prevent="submitEdit(selectedDepartment)">
                        <div class="form-group">
                            <label for="edit-id">Id</label>
                            <input class="form-control" id="edit-id" v-model="selectedDepartment.id" disabled>
                        </div>
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input class="form-control" id="edit-name" v-model="selectedDepartment.name" required/>
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
                <h3>Delete Department</h3>
                <section>
                    <p class="text-danger">Are you sure to delete?</p>

                    <p>id: @{{selectedDepartment.id}}</p>
                    <p>name: @{{selectedDepartment.name}}</p>

                    <button class="btn btn-default btn-primary" @click="submitDelete(selectedDepartment)">
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
