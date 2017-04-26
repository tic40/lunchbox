<template>
    <div>
        <h3>Edit Department</h3>
        <section>
            <form v-on:submit.prevent="submitEdit(department)">
                <div class="form-group">
                    <label for="edit-id">Id</label>
                    <input class="form-control" id="edit-id" v-model="department.id" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input class="form-control" id="edit-name" v-model="department.name" required/>
                </div>

                <button type="submit" class="btn btn-default btn-primary" :disabled="isLoading">
                    Submit
                </button>
                <button class="btn btn-default" @click="changeView(viewType.list)" :disabled="isLoading">
                    Cancel
                </button>
            </form>
        </section>
    </div>
</template>

<script>
    import { updateDepartment } from '../../api'

    export default {
        name: 'department-edit',
        data: function() {
            return {
            }
        },
        props: [
            'department',
            'isLoading',
            'viewType'
        ],
        methods: {
            changeView: function(type) {
                this.$emit('change-view', type)
            },
            submitEdit: function(department) {
                this.$emit('loading', true)
                updateDepartment(department.id, {
                    name: department.name,
                })
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
