<template>
    <div>
        <h3>Delete Department</h3>
        <section>
            <strong class="text-danger">Are you sure to delete?</strong>

            <div style="margin-top: 1em">
                <p>id: @{{department.id}}</p>
                <p>name: @{{department.name}}</p>
            </div>

            <div style="margin-top: 1em">
                <button class="btn btn-default btn-primary" @click="submitDelete(department)" :disabled="isLoading">
                    Submit
                </button>
                <button class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                    Cancel
                </button>
            </div>
        </section>
    </div>
</template>

<script>
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
                this.$emit('submit-delete', department)
            }
        }
    }
</script>
