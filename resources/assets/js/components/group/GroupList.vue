<template>
    <div>
        <ul v-for="(group, groupListKey) in groupList" class="list-group col-md-6">
            <li class="list-group-item disabled">GROUP: {{group.name}}</li>
            <li v-for="(member, groupKey) in group.groupMembers" class="list-group-item">
{{member}}
                {{groupKey+1}}. {{member.name}}
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
