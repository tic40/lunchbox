<template>
    <div>
        <h3>Delete Position</h3>
        <section>
            <p class="text-danger">Are you sure to delete?</p>

            <p>id: @{{position.id}}</p>
            <p>name: @{{position.name}}</p>

            <button class="btn btn-default btn-primary" @click="submitDelete(position)">
                Submit
            </button>
            <button class="btn btn-default" @click="changeView(viewType.list)">
                Cancel
            </button>
        </section>
    </div>
</template>

<script>
    export default {
        name: 'position-delete',
        props: [
            'position',
            'viewType',
            'isLoading'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitDelete: function(position) {
                this.$emit('submit-delete', position)
            }
        }
    }
</script>
