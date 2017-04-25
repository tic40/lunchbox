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
                <tr v-for="(position, key) in searchByName(positions, searchName)">
                    <th scope="row" v-text="position.id"></th>
                    <td v-text="position.name"></td>
                    <td v-if="isLogin">

                        <button class="btn btn-link" @click="clickEdit(key)">
                            <span class="text-muted"><i class="fa fa-pencil" aria-hidden="true"></i> edit</span>
                        </button>

                        <!--
                        <button class="btn btn-link" @click="clickDelete(key)">
                            <span class="text-muted"><i class="fa fa-close" aria-hidden="true"></i> delete</span>
                        </button>
                        -->
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
            'viewType',
            'positions',
            'isLogin'
        ],
        methods: {
            clickCreate: function() {
                this.$emit('click-create')
            },
            clickEdit: function(key) {
                this.$emit('click-edit', key)
            },
            clickDelete: function(key) {
                this.$emit('click-delete', key)
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
