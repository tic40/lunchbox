<template>
    <div>
        <!-- edit modal -->
        <transition name="modal" v-if="showEditModal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-header">
                            EDIT
                        </div>
                        <form v-on:submit.prevent="submitEdit()">
                            <div class="modal-body text-center">
                                <strong>{{replaceMember.from.name}} ({{replaceMember.from.departmentName}}/{{replaceMember.from.positionName}})</strong>

                                <div>
                                    <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                </div>

                                <select class="form-control" v-model="replaceMember.to" required>
                                    <option v-for="member in getMemberListFromGroupList" :value="member" :disabled="member.id=='group'">
                                        <span v-if="member.id=='group'">
                                            _____GROUP: {{member.name}}_____
                                        </span>
                                        <span v-else>
                                            {{member.name}}
                                            ({{member.departmentName}}/{{member.positionName}})
                                        </span>

                                    </option>
                                </select>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    OK
                                </button>
                                <button type="button" class="btn btn-default" @click="showEditModal=false">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>

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
                    <i class="fa fa-star-o text-danger" aria-hidden="true"></i>: coordinator
                </p>
                <ul v-for="(group, groupListKey) in listFilter(groupList, search.groupName, search.employeeName, search.departmentName, search.positionName)" class="list-group col-md-6">

                    <li class="list-group-item disabled">GROUP: {{group.name}}</li>
                    <li v-for="(member, groupKey) in group.groupMembers" class="list-group-item">
                        {{groupKey+1}}. {{member.name}}
                        <strong><i v-if="member.isCoordinator == 1" class="fa fa-star-o text-danger faa-vertical animated" aria-hidden="true"></i></strong>
                        ({{member.departmentName}}/{{member.positionName}})

                        <button class="btn btn-link btn-sm pull-right" @click="clickEdit(member, groupListKey, groupKey)" v-if="canEdit">
                            <span class="text-muted"><i class="fa fa-exchange" aria-hidden="true"></i></span>
                        </button>
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
                openSearch: false,
                showEditModal: false,
                replaceMember: {
                    'from': null,
                    'to': null
                }
            }
        },
        props: [
            'groupList',
            'yearMonth',
            'canEdit'
        ],
        computed: {
            getMemberListFromGroupList: function() {
                let editList = []
                this.groupList.forEach( function(group, groupListKey) {
                    editList.push({
                        'id': 'group',
                        'name': group.name
                    })
                    group.groupMembers.forEach(function (member, groupKey) {
                        var addMember = member
                        addMember.groupListKey = groupListKey
                        addMember.groupKey = groupKey
                        editList.push(addMember)
                    })
                })
                return editList
            }
        },
        methods: {
            clickEdit: function(member, groupListKey, groupKey) {
                if (!this.canEdit) { return }
                this.replaceMember.to = null
                this.replaceMember.from = member
                this.replaceMember.from.groupListKey = groupListKey
                this.replaceMember.from.groupKey = groupKey
                this.showEditModal = true
            },
            submitEdit: function () {
                let from = this.replaceMember.from
                let to = this.replaceMember.to

                // swap isCoordinator
                let tmp = to.isCoordinator
                to.isCoordinator = from.isCoordinator
                from.isCoordinator = tmp

                this.groupList[from.groupListKey].groupMembers[from.groupKey] = to
                this.groupList[to.groupListKey].groupMembers[to.groupKey] = from

                this.showEditModal = false
            },
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
