<template>
    <div>
        <h3>Delete Department</h3>
        <section>
            <strong class="text-danger">Are you sure to delete?</strong>

            <div style="margin-top: 1em">
                <p>id: {{department.id}}</p>
                <p>name: {{department.name}}</p>
            </div>

            <div style="margin-top: 1em">
                <button class="btn btn-default btn-danger" @click="submitDelete(department)" :disabled="isLoading">
                    Delete
                </button>
                <button class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                    Cancel
                </button>
            </div>
        </section>
    </div>
</template>

<script>
    import { destroyDepartment } from '../../api'

    export default {
        name: 'department-delete',
        props: [
            'department',
            'viewType',
            'isLoading'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitDelete: function(department) {
                this.$emit('loading', true)
                destroyDepartment(department.id)
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
