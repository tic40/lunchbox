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
    import { createDepartment } from '../../api'

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
            submitCreate: function(department) {
                this.$emit('loading', true)
                createDepartment({
                    name: department.name,
                })
                .then(response => {
                    this.$emit('change-view', this.viewType.list)
                })
            }
        }
    }
</script>
