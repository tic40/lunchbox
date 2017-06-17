<template>
    <div>
        <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new employee</button>
        <h3>Employee List</h3>
        <div class="form-inline">
            <input type="text" class="form-control" id="search-name" v-model="search.name" placeholder="search name">
            <input type="text" class="form-control" id="search-department" v-model="search.department" placeholder="search department">
            <input type="text" class="form-control" id="search-position" v-model="search.position" placeholder="search position">
            <!--
            <select class="form-control" id="search-is-temporary-absence" v-model="search.isTemporaryAbsence">
                <option :value="null" :selected="search.isTemporaryAbsence == null">--</option>
                <option :value="0" :selected="search.isTemporaryAbsence == 0">not absence</option>

                <option :value="1" :selected="search.isTemporaryAbsence == 1">temporary absence</option>
            </select>
            -->
            <button type="button" class="btn btn-default btn" @click="resetSearchForm">reset</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(employee, index) in listFilter(employees, search.name, search.department, search.position)">
                    <th scope="row" v-text="employee.id"></th>
                    <td>
                        {{employee.name}}
                        <p v-if="employee.isTemporaryAbsence == 1" class="text-danger">(temporary absence)</p>
                    </td>
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
                search: {
                    name: '',
                    department: '',
                    position: ''
                },
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
            resetSearchForm: function() {
                this.search.name = ''
                this.search.department = ''
                this.search.position = ''
            },
            listFilter: function(employees, name, department, position) {
                if (
                    (name === undefined || name === '')
                    && (department === undefined || department === '')
                    && (position === undefined || position === '')
                ) {
                    return employees
                }
                let regexpName = new RegExp(name, 'i')
                let regexpDepartment = new RegExp(department, 'i')
                let regexpPosition = new RegExp(position, 'i')
                return employees.filter(function (employee) {
                    return (
                        regexpName.test(employee.name)
                        && regexpDepartment.test(employee.departmentName)
                        && regexpPosition.test(employee.positionName)
                    )
                })
            }
        },
    }
</script>
