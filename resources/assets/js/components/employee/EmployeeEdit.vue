<template>
    <div>
        <section>
            <form v-on:submit.prevent="submitEdit(employee)">
                <div class="form-group">
                    <label for="edit-id">Id</label>
                    <input class="form-control" id="edit-id" v-model="employee.id" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input class="form-control" id="edit-name" v-model="employee.name" required/>
                </div>
                <div class="form-group">
                    <label for="edit-department">Department</label>
                    <select class="form-control" id="edit-department" v-model="employee.departmentId" required>
                        <option v-for="department in departments" :value="department.id" :selected="department.id == employee.departmentId">
                            {{department.id}} | {{department.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-position">Position</label>
                    <select class="form-control" id="edit-position" v-model="employee.positionId" required>
                        <option v-for="position in positions" :value="position.id" :selected="position.id == employee.positionId">
                            {{position.id}} | {{position.name}}
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-default btn-primary" :disabled="isLoading">
                    Submit
                </button>
                <button type="button" class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                    Cancel
                </button>
            </form>
        </section>
    </div>
</template>

<script>
    import { updateEmployee } from '../../api'

    export default {
        name: 'employee-edit',
        data: function() {
            return {
            }
        },
        props: [
            'viewType',
            'employee',
            'departments',
            'positions',
            'isLoading'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitEdit: function(employee) {
                this.$emit('loading', true)
                updateEmployee(employee.id, {
                    name: employee.name,
                    department_id: employee.departmentId,
                    position_id: employee.positionId
                })
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
