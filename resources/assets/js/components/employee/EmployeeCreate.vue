<template>
    <div>
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
                        <option v-for="department in departments" :value="department.id">
                            {{department.id}} | {{department.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="create-position">Position</label>
                    <select class="form-control" id="create-position" v-model="newEmployee.positionId" required>
                        <option v-for="position in positions" :value="position.id">
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
    export default {
        name: 'employee-create',
        data: function() {
            return {
                newEmployee: {
                    name: '',
                    departmentId: '',
                    positionId: ''
                }
            }
        },
        props: [
            'viewType',
            'departments',
            'positions',
            'isLoading'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitCreate: function(newEmployee) {
                this.$emit('submit-create', newEmployee)
            }
        }
    }
</script>
