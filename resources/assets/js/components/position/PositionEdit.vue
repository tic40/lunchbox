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

                <button type="submit" class="btn btn-default btn-primary">
                    Submit
                </button>
                <p class="btn btn-default" @click="changeView(viewType.list)">
                    Cancel
                </p>
            </form>
        </section>
    </div>
</template>

<script>
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
                this.$emit('submit-edit', position)
            }
        }
    }
</script>
