require('./bootstrap');

const GroupList = require('./components/group/GroupList.vue')
const EmployeeList = require('./components/employee/EmployeeList.vue')
const EmployeeCreate = require('./components/employee/EmployeeCreate.vue')
const EmployeeEdit = require('./components/employee/EmployeeEdit.vue')
const EmployeeDelete = require('./components/employee/EmployeeDelete.vue')

const DepartmentList = require('./components/department/DepartmentList.vue')
const DepartmentCreate = require('./components/department/DepartmentCreate.vue')
const DepartmentEdit = require('./components/department/DepartmentEdit.vue')
const DepartmentDelete = require('./components/department/DepartmentDelete.vue')

const PositionList = require('./components/position/PositionList.vue')
const PositionCreate = require('./components/position/PositionCreate.vue')
const PositionEdit = require('./components/position/PositionEdit.vue')
const PositionDelete = require('./components/position/PositionDelete.vue')

// constants
const viewType = {
    list: 1,
    create: 2,
    edit: 3,
    delete: 4,
};

// API
function fetch(url) {
    return promise = new Promise((resolve, reject) => {
        axios.get(url)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => { reject(e) })
    })
}
function post(url, request) {
    return new Promise((resolve, reject) => {
        axios.post(url, request)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => { reject(e) })
    })
}
function put(url, request) {
    return new Promise((resolve, reject) => {
        axios.put(url, request)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => { reject(e) })
    })
}
function destroy(url) {
    return new Promise((resolve, reject) => {
        axios.delete(url)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => { reject(e) })
    })
}

function checkAuth() {
    return fetch('api/auth')
}
function getEmployees() {
    return fetch('api/employee/list')
}
function createEmployee(request) {
    return post('api/employee', request)
}
function updateEmployee(id, request) {
    return put('api/employee/' + id, request)
}
function destroyEmployee(id, request) {
    return destroy('api/employee/' + id, request)
}

function getDepartments() {
    return fetch('api/department/list')
}
function createDepartment(request) {
    return post('api/department', request)
}
function updateDepartment(id, request) {
    return put('api/department/' + id, request)
}
function destroyDepartment(id, request) {
    return destroy('api/department/' + id, request)
}

function getPositions() {
    return fetch('api/position/list')
}
function createPosition(request) {
    return post('api/position', request)
}
function updatePosition(id, request) {
    return put('api/position/' + id, request)
}
function destroyPosition(id, request) {
    return destroy('api/position/' + id, request)
}

function getGroupList(year, month) {
    return fetch('api/group/' + year + '/' + month + '/list')
}
function getGenerateGroup(year, month, groupNumber) {
    return fetch('api/group/' + year + '/' + month + '/create/' + groupNumber)
}


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
            clickCreate: function(index) {
                this.changeView(this.viewType.create)
            },
            clickEdit: function(index) {
                this.setSelectedEmployee(index)
                this.changeView(this.viewType.edit)
            },
            clickDelete: function(index) {
                this.setSelectedEmployee(index)
                this.changeView(this.viewType.delete)
            },
            submitCreate: function(employee) {
                this.loading(true)
                createEmployee({
                    name: employee.name,
                    department_id: employee.departmentId,
                    position_id: employee.positionId
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitEdit: function(employee) {
                this.loading(true)
                updateEmployee(employee.id, {
                    name: employee.name,
                    department_id: employee.departmentId,
                    position_id: employee.positionId
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitDelete: function(employee) {
                this.loading(true)
                destroyEmployee(employee.id)
                .then(response => {
                    this.changeView(this.viewType.list)
                })
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
            clickCreate: function(index) {
                this.changeView(this.viewType.create)
            },
            clickEdit: function(index) {
                this.setSelectedDepartment(index)
                this.changeView(this.viewType.edit)
            },
            clickDelete: function(index) {
                this.setSelectedDepartment(index)
                this.changeView(this.viewType.delete)
            },
            submitCreate: function(department) {
                this.loading(true)
                createDepartment({
                    name: department.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitEdit: function(department) {
                this.loading(true)
                updateDepartment(department.id, {
                    name: department.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitDelete: function(department) {
                this.loading(true)
                destroyDepartment(department.id)
                .then(response => {
                    this.changeView(this.viewType.list)
                })
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
            clickCreate: function(index) {
                this.changeView(this.viewType.create)
            },
            clickEdit: function(index) {
                this.setSelectedPosition(index)
                this.changeView(this.viewType.edit)
            },
            clickDelete: function(index) {
                this.setSelectedPosition(index)
                this.changeView(this.viewType.delete)
            },
            submitCreate: function(position) {
                this.loading(true)
                createPosition({
                    name: position.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitEdit: function(position) {
                this.loading(true)
                updatePosition(position.id, {
                    name: position.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitDelete: function(position) {
                this.loading(true)
                destroyPosition(position.id)
                .then(response => {
                    this.changeView(this.viewType.list)
                })
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
