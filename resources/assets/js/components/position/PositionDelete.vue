<template>
    <div>
        <h3>Delete Position</h3>
        <section>
            <p class="text-danger">Are you sure to delete?</p>

            <p>id: {{position.id}}</p>
            <p>name: {{position.name}}</p>

            <button class="btn btn-default btn-danger" @click="submitDelete(position)" :disabled="isLoading">
                Delete
            </button>
            <button class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                Cancel
            </button>
        </section>
    </div>
</template>

<script>
    import { destroyPosition } from '../../api'

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
                this.$emit('loading', true)
                destroyPosition(position.id)
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
