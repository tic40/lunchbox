@extends('layouts.app')

@section('content')
<div id="employee" class="container" v-cloak>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div v-if="currentView === viewType.list">
                <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new employee</button>

                <h3>Employee List</h3>
                <div class="form-group">
                    <label for="search-name">search by name </label>
                    <input type="text" id="search-name" v-model="search.name">
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department Name</th>
                            <th>Position Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(employee, key) in searchByName(employees, search.name)">
                            <th scope="row" v-text="employee.id"></th>
                            <td v-text="employee.name"></td>
                            <td v-text="employee.departmentName"></td>
                            <td v-text="employee.positionName"></td>
                            <td v-if="isLogin">

                                <button class="btn btn-link" @click="clickEdit(key)">
                                    <span class="text-muted"><i class="fa fa-pencil" aria-hidden="true"></i> edit</span>
                                </button>

                                <button class="btn btn-link" @click="clickDelete(key)">
                                    <span class="text-muted"><i class="fa fa-close" aria-hidden="true"></i> delete</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else-if="currentView === viewType.create">
                <h3>Create Employee</h3>
                <section>

                    <form v-on:submit.prevent="submitCreate(newEmployee)">
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input class="form-control" id="create-name" v-model="newEmployee.name" required/>
                        </div>
                        <div class="form-group">
                            <label for="create-department">Department</label>
                            <select class="form-control" id="create-department" v-model="newEmployee.departmentId" required>
                                <option v-for="department in departments" v-bind:value="department.id">
                                    @{{department.id}} | @{{department.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="create-position">Position</label>
                            <select class="form-control" id="create-position" v-model="newEmployee.positionId" required>
                                <option v-for="position in positions" v-bind:value="position.id">
                                    @{{position.id}} | @{{position.name}}
                                </option>
                            </select>
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
                <h3>Edit Employee</h3>
                <section>
                    <form v-on:submit.prevent="submitEdit(selectedEmployee)">
                        <div class="form-group">
                            <label for="edit-id">Id</label>
                            <input class="form-control" id="edit-id" v-model="selectedEmployee.id" disabled>
                        </div>
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input class="form-control" id="edit-name" v-model="selectedEmployee.name" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit-department">Department</label>
                            <select class="form-control" id="edit-department" v-model="selectedEmployee.departmentId" required>
                                <option v-for="department in departments" v-bind:value="department.id" :selected="department.id == selectedEmployee.departmentId">
                                    @{{department.id}} | @{{department.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-position">Position</label>
                            <select class="form-control" id="edit-position" v-model="selectedEmployee.positionId" required>
                                <option v-for="position in positions" v-bind:value="position.id" :selected="position.id == selectedEmployee.positionId">
                                    @{{position.id}} | @{{position.name}}
                                </option>
                            </select>
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
                <h3>Delete Employee</h3>
                <section>
                    <p class="text-danger">Are you sure to delete?</p>

                    <p>id: @{{selectedEmployee.id}}</p>
                    <p>name: @{{selectedEmployee.name}}</p>
                    <p>department name: @{{selectedEmployee.departmentName}}</p>
                    <p>position name: @{{selectedEmployee.positionName}}</p>

                    <button class="btn btn-default btn-primary" @click="submitDelete(selectedEmployee)">
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
