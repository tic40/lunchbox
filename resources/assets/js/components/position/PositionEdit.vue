<template>
    <div>
        <h3>Edit Position</h3>
        <section>
            <form v-on:submit.prevent="submitEdit(position)">
                <div class="form-group">
                    <label for="edit-id">Id</label>
                    <input class="form-control" id="edit-id" v-model="position.id" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input class="form-control" id="edit-name" v-model="position.name" required/>
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
    import { updatePosition } from '../../api'

    export default {
        name: 'position-edit',
        data: function() {
            return {
            }
        },
        props: [
            'position',
            'isLoading',
            'viewType'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitEdit: function(position) {
                this.$emit('loading', true)
                updatePosition(position.id, {
                    name: position.name,
                })
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
