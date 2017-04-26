require('./bootstrap')

// API
import {
    checkAuth,
    getEmployees,
    getDepartments,
    getPositions,
    getGroupList,
    getGenerateGroup
} from './api'

// components
import GroupList from './components/group/GroupList.vue'
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

// constants
const viewType = {
    list: 1,
    create: 2,
    edit: 3,
    delete: 4,
};

/**
 * employee
 */
if (document.querySelector('#employee')) {

    const employee = new Vue({
        el: '#employee',
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
            checkAuth()
            .then(response => {
                this.isLogin = response.isLogin
            })
            getEmployees()
            .then(response => {
                this.employees = response
            }),
            getDepartments()
            .then(response => {
                this.departments = response
            })
            getPositions()
            .then(response => {
                this.positions = response
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
if (document.querySelector('#department')) {

    const department = new Vue({
        el: '#department',
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
            checkAuth()
            .then(response => {
                this.isLogin = response.isLogin
            })
            getDepartments()
            .then(response => {
                this.departments = response
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
if (document.querySelector('#position')) {

    const position = new Vue({
        el: '#position',
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
            checkAuth()
            .then(response => {
                this.isLogin = response.isLogin
            })
            getPositions()
            .then(response => {
                this.positions = response
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
if (document.querySelector('#group')) {

    const group = new Vue({
        el: '#group',
        data: {
            isLogin: 0,
            viewType: viewType,
            currentView: viewType.list,
            groupList: null,
            generatedGroupList: null,
            currentDate: new Date(),
            yearMonth: '0000-00',
            groupNumber: 4,
            isLoading: false
        },
        components: {
            GroupList
        },
        created: function() {
            this.yearMonth = this.getCurrentYearMonth()
            checkAuth()
            .then(response => {
                this.isLogin = response.isLogin
            })
            getGroupList(this.getYear, this.getMonth)
            .then(response => {
                this.groupList = response
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
                getGroupList(this.getYear, this.getMonth)
                .then(response => {
                    console.log('get new group list' + val)
                    this.groupList = response
                })
            }
        },
        methods: {
            getCurrentYearMonth: function() {
                return [
                    this.currentDate.getFullYear(),
                    ("0" + (this.currentDate.getMonth() + 1)).slice(-2)
                ].join('-')
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    this.loading(true)
                    getGroupList(this.getYear, this.getMonth)
                    .then(response => {
                        this.groupList = response
                        this.currentView = type
                        this.loading(false)
                    })
                } else {
                    this.currentView = type
                    this.loading(false)
                }
            },
            clickCreate: function(year, month) {
                this.generatedGroupList = null;
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
            submitCreate: function() {
                console.log('submit create')
            },
            submitDelete: function() {
                console.log('submit delete')
            },
            loading: function(bool) {
                this.isLoading = bool
            }
        }
    })
}
