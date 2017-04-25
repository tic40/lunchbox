<template>
    <div>
        <h3>Create Department</h3>
        <section>
            <form v-on:submit.prevent="submitCreate(newDepartment)">
                <div class="form-group">
                    <label for="create-name">Name</label>
                    <input class="form-control" id="create-name" v-model="newDepartment.name" required/>
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
        name: 'department-create',
        data: function() {
            return {
                newDepartment: {
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
            submitCreate: function(newDepartment) {
                this.$emit('submit-create', newDepartment)
            }
        }
    }
</script>
