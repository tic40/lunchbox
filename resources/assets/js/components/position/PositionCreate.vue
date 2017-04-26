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
    import { createPosition } from '../../api'

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
            submitCreate: function(position) {
                this.$emit('loading', true)
                createPosition({
                    name: position.name,
                })
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
