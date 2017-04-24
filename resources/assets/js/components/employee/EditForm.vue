<template>
    <div>
        <div class="form-group">
            <label for="edit-name">Name</label>
            <input class="form-control" id="edit-name" v-model="employee.name" required/>
        </div>
        <span v-once>{{beforeEdit}}</span> -> {{employee}}
        <div class="form-group">
            <label for="edit-department">Department</label>
            <select class="form-control">
                <option v-for="department in departments" v-bind:value="employee.departmentId">
                    {{department.id}} | {{department.name}}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'edit-form',
        props: [
            'employee',
            'departments'
        ]
    }
</script>
