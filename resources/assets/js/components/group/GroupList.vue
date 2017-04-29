<template>
    <div>
        <div v-if="groupList.length > 0">
            <ul v-for="(group, groupListKey) in groupList" class="list-group col-md-6">
                <li class="list-group-item disabled">GROUP: {{group.name}}</li>
                <li v-for="(member, groupKey) in group.groupMembers" class="list-group-item">
                    {{groupKey+1}}. {{member.name}}
                    <i v-if="member.isLeader == 1" class="fa fa-star-o text-danger" aria-hidden="true"></i>
                </li>
            </ul>
        </div>

        <div v-else-if="!yearMonth">
            <div class="alert alert-warning" key="emptyGroupList">
                <p>Date is not specified.</p>
            </div>
        </div>

        <div v-else>
            <div class="alert alert-warning" key="emptyGroupList">
                <p>The group of this month has not been generated yet.</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'group-list',
        props: [
            'groupList',
            'yearMonth'
        ]
    }
</script>
