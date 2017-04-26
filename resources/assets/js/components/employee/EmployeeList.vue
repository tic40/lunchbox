<template>
    <div>
        <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new employee</button>
        <h3>Employee List</h3>
        <div class="form-group">
            <label for="search-name">search by name </label>
            <input type="text" id="search-name" v-model="searchName">
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
                <tr v-for="(employee, index) in searchByName(employees, searchName)">
                    <th scope="row" v-text="employee.id"></th>
                    <td v-text="employee.name"></td>
                    <td v-text="employee.departmentName"></td>
                    <td v-text="employee.positionName"></td>
                    <td v-if="isLogin">

                        <button class="btn btn-link" @click="clickEdit(index)">
                            <span class="text-muted"><i class="fa fa-pencil" aria-hidden="true"></i> edit</span>
                        </button>

                        <button class="btn btn-link" @click="clickDelete(index)">
                            <span class="text-muted"><i class="fa fa-close" aria-hidden="true"></i> delete</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'employee-list',
        data: function() {
            return {
                searchName: ''
            }
        },
        props: [
            'employees',
            'isLogin',
            'viewType'
        ],
        methods: {
            clickCreate: function() {
                this.$emit('change-view', this.viewType.create)
            },
            clickEdit: function(index) {
                this.$emit('set-selected-employee', index)
                this.$emit('change-view', this.viewType.edit)
            },
            clickDelete: function(index) {
                this.$emit('set-selected-employee', index)
                this.$emit('change-view', this.viewType.delete)
            },
            searchByName: function(employees, name) {
                if (name === undefined || name === '') { return employees }
                return employees.filter(function (employee) {
                    return employee.name.indexOf(name) > 0
                })
            }
        }
    }
</script>
