<template>
    <div>
        <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new department</button>
        <h3>Department List</h3>
        <div class="form-inline">
            <input type="text" id="searchName" class="form-control" v-model="searchName" placeholder="search name">
            <button type="text" @click="searchName = ''" class="btn btn-default">reset</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(department, index) in searchByName(departments, searchName)">
                    <th scope="row" v-text="department.id"></th>
                    <td v-text="department.name"></td>
                    <td v-if="isLogin">

                        <button class="btn btn-link" @click="clickEdit(index)">
                            <span class="text-muted"><i class="fa fa-pencil" aria-hidden="true"></i> edit</span>
                        </button>

<!--
                        <button class="btn btn-link" @click="clickDelete(index)">
                            <span class="text-muted"><i class="fa fa-close" aria-hidden="true"></i> delete</span>
                        </button>
-->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'department-list',
        data: function() {
            return {
                searchName: ''
            }
        },
        props: [
            'viewType',
            'departments',
            'isLogin'
        ],
        methods: {
            clickCreate: function() {
                this.$emit('change-view', this.viewType.create)
            },
            clickEdit: function(index) {
                this.$emit('set-selected-department', index)
                this.$emit('change-view', this.viewType.edit)
            },
            clickDelete: function(index) {
                this.$emit('set-selected-department', index)
                this.$emit('change-view', this.viewType.delete)
            },
            searchByName: function(employees, str) {
                if (str === undefined || str === '') { return employees }
                let regexp = new RegExp(str, 'i')
                return employees.filter(function (employee) {
                    return regexp.test(employee.name)
                })
            }
        }
    }
</script>
