<template>
    <div>
        <div v-if="groupList.length > 0">
            <button type="button" class="btn btn-default btn-sm" :class="[{'btn-success' : openSearch}]" @click="openSearch = !openSearch"><i class="fa fa-search" aria-hidden="true"></i></button>
            <span v-if="openSearch">
                <input type="text" id="search-group-name" v-model="search.groupName" placeholder="group name">
                <input type="text" id="search-employee-name" v-model="search.employeeName" placeholder="employee name">
                <input type="text" id="search-department-name" v-model="search.departmentName" placeholder="department name">
                <input type="text" id="search-position-name" v-model="search.positionName" placeholder="position name">
                <button type="button" class="btn btn-default btn-sm" @click="resetSearchForm">reset</button>
            </span>

            <div>
                <p>
                    <i class="fa fa-star-o text-danger" aria-hidden="true"></i>: group leader
                </p>
                <ul v-for="(group, groupListKey) in listFilter(groupList, search.groupName, search.employeeName, search.departmentName, search.positionName)" class="list-group col-md-6">

                    <li class="list-group-item disabled">GROUP: {{group.name}}</li>
                    <li v-for="(member, groupKey) in group.groupMembers" class="list-group-item">
                        {{groupKey+1}}. {{member.name}}
                        <strong><i v-if="member.isLeader == 1" class="fa fa-star-o text-danger faa-vertical animated" aria-hidden="true"></i></strong>
                        ({{member. departmentName}}/{{member.positionName}})
                    </li>
                </ul>
            </div>
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
        data: function() {
            return {
                search: {
                    groupName: '',
                    employeeName: '',
                    departmentName: '',
                    positionName: ''
                },
                openSearch: false
            }
        },
        props: [
            'groupList',
            'yearMonth'
        ],
        methods: {
            resetSearchForm: function() {
                this.search.groupName = ''
                this.search.employeeName = ''
                this.search.departmentName = ''
                this.search.positionName = ''
            },
            listFilter: function(groupList, groupName, employeeName, departmentName, positionName) {
                if (
                    (groupName === undefined || groupName === '')
                    && (employeeName === undefined || employeeName === '')
                    && (departmentName === undefined || departmentName === '')
                    && (positionName === undefined || positionName === '')
                ) {
                    return groupList
                }
                let regexpGroup = new RegExp(groupName, 'i')
                let regexpEmployee = new RegExp(employeeName, 'i')
                let regexpDepartment = new RegExp(departmentName, 'i')
                let regexpPosition = new RegExp(positionName, 'i')
                return groupList.filter(function (group) {
                    return (regexpGroup.test(group.name)
                        && group.groupMembers.filter(function (member) {
                            return (regexpEmployee.test(member.name)
                                && regexpDepartment.test(member.departmentName)
                                && regexpPosition.test(member.positionName)
                            )
                        }).length > 0
                    )
                })
            }
        }
    }
</script>
