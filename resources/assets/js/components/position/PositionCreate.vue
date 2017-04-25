<template>
    <div>
        <h3>Create Position</h3>
        <section>
            <form v-on:submit.prevent="submitCreate(newPosition)">
                <div class="form-group">
                    <label for="create-name">Name</label>
                    <input class="form-control" id="create-name" v-model="newPosition.name" required/>
                </div>
                <button type="submit" class="btn btn-default btn-primary" >
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
        name: 'position-create',
        data: function() {
            return {
                newPosition: {
                    name: ''
                }
            }
        },
        props: [
            'viewType',
            'isLoading'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitCreate: function(newPosition) {
                this.$emit('submit-create', newPosition)
            }
        }
    }
</script>
