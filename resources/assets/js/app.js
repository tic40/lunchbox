require('./bootstrap')

// API
import {
    checkAuth,
    getEmployees,
    getDepartments,
    getPositions,
    getGroupList,
    getGenerateGroup,
    createGroup,
    destroyGroup
} from './api'

// components
import EmployeeList from './components/employee/EmployeeList.vue'
import EmployeeCreate from './components/employee/EmployeeCreate.vue'
import EmployeeEdit from './components/employee/EmployeeEdit.vue'
import EmployeeDelete from './components/employee/EmployeeDelete.vue'
import DepartmentList from './components/department/DepartmentList.vue'
import DepartmentCreate from './components/department/DepartmentCreate.vue'
import DepartmentEdit from './components/department/DepartmentEdit.vue'
import DepartmentDelete from './components/department/DepartmentDelete.vue'
import PositionList from './components/position/PositionList.vue'
import PositionCreate from './components/position/PositionCreate.vue'
import PositionEdit from './components/position/PositionEdit.vue'
import PositionDelete from './components/position/PositionDelete.vue'
import GroupList from './components/group/GroupList.vue'

// constants
const viewType = {
    list: 1,
    create: 2,
    edit: 3,
    delete: 4
}
const appIds = {
    employee: '#app-employee',
    department: '#app-department',
    position: '#app-position',
    group: '#app-group'
}

/**
 * employee
 */
if (document.querySelector(appIds.employee)) {
    const appEmployee = new Vue({
        el: appIds.employee,
        data: {
            isLogin: 0,
            viewType: viewType,
            currentView: viewType.list,
            employees: null,
            departments: null,
            positions: null,
            selectedEmployee: null,
            isLoading: false,
        },
        components: {
            EmployeeList,
            EmployeeCreate,
            EmployeeEdit,
            EmployeeDelete
        },
        created: function() {
            this.loading(true)
            Promise.all([
                checkAuth(),
                getEmployees(),
                getDepartments(),
                getPositions(),
            ])
            .then(responses => {
                this.isLogin = responses[0].isLogin
                this.employees = responses[1]
                this.departments = responses[2]
                this.positions = responses[3]
                this.loading(false)
            })
        },
        methods: {
            setSelectedEmployee: function(index) {
                this.selectedEmployee = this.employees[index]
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    this.loading(true)
                    getEmployees()
                    .then(response => {
                        this.employees = response
                        this.currentView = type
                        this.loading(false)
                    })
                } else {
                    this.currentView = type
                    this.loading(false)
                }
            },
            loading: function(bool) {
                this.isLoading = bool
            }
        }
   });
}

/**
 * department
 */
if (document.querySelector(appIds.department)) {
    const appDepartment = new Vue({
        el: appIds.department,
        data: {
            isLogin: 0,
            viewType: viewType,
            currentView: viewType.list,
            departments: null,
            selectedDepartment: null,
            isLoading: false
        },
        components: {
            DepartmentList,
            DepartmentCreate,
            DepartmentEdit,
            DepartmentDelete
        },
        created: function() {
            this.loading(true)
            Promise.all([
                checkAuth(),
                getDepartments(),
            ])
            .then(responses => {
                this.isLogin = responses[0].isLogin
                this.departments = responses[1]
                this.loading(false)
            })
        },
        methods: {
            setSelectedDepartment: function(index) {
                this.selectedDepartment = this.departments[index]
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    this.loading(true)
                    getDepartments()
                    .then(response => {
                        this.departments = response
                        this.currentView = type
                        this.loading(false)
                    })
                } else {
                    this.currentView = type
                    this.loading(false)
                }
            },
            loading: function(bool) {
                this.isLoading = bool
            }
        }
   });
}


/**
 * position
 */
if (document.querySelector(appIds.position)) {
    const appPosition = new Vue({
        el: appIds.position,
        data: {
            isLogin: 0,
            viewType: viewType,
            currentView: viewType.list,
            positions: null,
            selectedPosition: null,
            isLoading: false
        },
        components: {
            PositionList,
            PositionCreate,
            PositionEdit,
            PositionDelete
        },
        created: function() {
            this.loading(true)
            Promise.all([
                checkAuth(),
                getPositions(),
            ])
            .then(responses => {
                this.isLogin = responses[0].isLogin
                this.positions = responses[1]
                this.loading(false)
            })
        },
        methods: {
            setSelectedPosition: function(index) {
                this.selectedPosition = this.positions[index]
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    this.loading(true)
                    getPositions()
                    .then(response => {
                        this.positions = response
                        this.currentView = type
                        this.loading(false)
                    })
                } else {
                    this.currentView = type
                    this.loading(false)
                }
            },
            loading: function(bool) {
                this.isLoading = bool
            }
        }
   });
}

/**
 * group
 */
if (document.querySelector(appIds.group)) {
    const appGroup = new Vue({
        el: appIds.group,
        data: {
            isLogin: 0,
            viewType: viewType,
            currentView: viewType.list,
            groupList: [],
            generatedGroupList: [],
            currentDate: new Date(),
            yearMonth: '0000-00',
            groupNumber: null,
            isLoading: false
        },
        components: {
            GroupList
        },
        created: function() {
            this.loading(true)
            this.yearMonth = this.getCurrentYearMonth()
            Promise.all([
                checkAuth(),
                getGroupList(this.getYear, this.getMonth)
            ])
            .then(responses => {
                this.isLogin = responses[0].isLogin
                this.groupList = responses[1]
                this.loading(false)
            })
        },
        computed: {
            getYear: function() {
                return this.yearMonth.split('-')[0]
            },
            getMonth: function() {
                return this.yearMonth.split('-')[1]
            }
        },
        watch: {
            yearMonth: function (val, oldVal) {
                this.getGroupList()
            }
        },
        methods: {
            getGroupList: function() {
                if (this.yearMonth == '' || this.yearMonth == undefined) {
                    this.groupList = []
                } else {
                    this.loading(true)
                    getGroupList(this.getYear, this.getMonth)
                    .then(response => {
                        this.groupList = response
                        this.loading(false)
                    })
                }
            },
            getCurrentYearMonth: function() {
                return [
                    this.currentDate.getFullYear(),
                    ("0" + (this.currentDate.getMonth() + 1)).slice(-2)
                ].join('-')
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    this.getGroupList()
                    this.currentView = type
                } else {
                    this.currentView = type
                    this.loading(false)
                }
            },
            clickCreate: function(year, month) {
                this.generatedGroupList = [];
                this.changeView(this.viewType.create)
            },
            clickDelete: function() {
                this.changeView(this.viewType.delete)
            },
            clickGenerate: function(year, month, groupNumber) {
                this.loading(true)
                getGenerateGroup(year, month, groupNumber)
                .then(response => {
                    this.generatedGroupList = response
                    this.loading(false)
                })
            },
            submitCreate: function(year, month, groupList) {
                createGroup(year, month, {
                    groupList: groupList
                })
                .then(response => {
                    console.log(response)
                    this.changeView(this.viewType.list)
                })
            },
            submitDelete: function(year, month) {
                destroyGroup(year, month)
                .then(response => {
                    console.log(response)
                    this.changeView(this.viewType.list)
                })
            },
            loading: function(bool) {
                this.isLoading = bool
            }
        }
    })
}
