<template>
    <div>
        <button v-if="isLogin" type="button" class="pull-right btn btn-success" @click="clickCreate">new position</button>
        <h3>Position List</h3>
        <div class="form-group">
            <label for="searchName">search by name </label>
            <input type="text" id="searchName" v-model="searchName">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(position, index) in searchByName(positions, searchName)">
                    <th scope="row" v-text="position.id"></th>
                    <td v-text="position.name"></td>
                    <td v-if="isLogin">

                        <button class="btn btn-link" @click="clickEdit(index)">
                            <span class="text-muted"><i class="fa fa-pencil" aria-hidden="true"></i> edit</span>
                        </button>

                        <button class="btn btn-link" @click="clickDelete(index)">
                            <span class="text-muted"><i class="fa fa-close" aria-hidden="true"></i> delete</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'position-list',
        data: function() {
            return {
                searchName: ''
            }
        },
        props: [
            'positions',
            'isLogin',
            'viewType'
        ],
        methods: {
            clickCreate: function() {
                this.$emit('change-view', this.viewType.create)
            },
            clickEdit: function(index) {
                this.$emit('set-selected-position', index)
                this.$emit('change-view', this.viewType.edit)
            },
            clickDelete: function(index) {
                this.$emit('set-selected-position', index)
                this.$emit('change-view', this.viewType.delete)
            },
            searchByName: function(positions, name) {
                if (name === undefined || name === '') { return positions }
                return positions.filter(function (position) {
                    return position.name.indexOf(name) > 0
                })
            },
        }
    }
</script>
