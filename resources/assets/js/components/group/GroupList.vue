<template>
    <div>
        <ul v-for="(group, groupListKey) in groupList" class="list-group col-md-6">
            <li class="list-group-item disabled">GROUP {{groupListKey + 1}}</li>
            <li v-for="(employee, groupKey) in group" class="list-group-item">
                {{groupKey+1}}. {{employee.name}}
                <i v-if="groupKey == 0" class="fa fa-star-o text-success" aria-hidden="true"></i>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'group-list',
        props: [
            'groupList'
        ]
    }
</script>
