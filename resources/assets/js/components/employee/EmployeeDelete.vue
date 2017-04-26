<template>
    <div>
        <h3>Delete Employee</h3>
        <section>
            <strong class="text-danger">Are you sure to delete?</strong>

            <div style="margin-top: 1em">
                <p>id: {{employee.id}}</p>
                <p>name: {{employee.name}}</p>
                <p>department name: {{employee.departmentName}}</p>
                <p>position name: {{employee.positionName}}</p>
            </div>

            <div style="margin-top: 2em">
                <button class="btn btn-default btn-primary" @click="submitDelete(employee)" :disabled="isLoading">
                    Submit
                </button>
                <button type="button" class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                    Cancel
                </button :disabled="isLoading">
            </div>
        </section>
    </div>
</template>

<script>
    import { destroyEmployee } from '../../api'

    export default {
        name: 'employee-delete',
        data: function() {
            return {
            }
        },
        props: [
            'viewType',
            'employee',
            'isLoading'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitDelete: function(employee) {
                this.$emit('loading', true)
                destroyEmployee(employee.id)
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
