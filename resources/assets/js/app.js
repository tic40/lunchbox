require('./bootstrap');

//Vue.component('example', require('./components/Example.vue'));
/*
const app = new Vue({
    el: '#app'
});
*/

Vue.component('modal', require('./components/modal/Simple.vue'));

// constants
const viewType = {
    list: 1,
    create: 2,
    edit: 3,
    delete: 4,
};

// API
function fetch(url) {
    return new Promise((resolve, reject) => {
        axios.get(url)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => {
            reject(e)
        })
    })
}
function post(url, request) {
    return new Promise((resolve, reject) => {
        axios.post(url, request)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => {
            reject(e)
        })
    })
}
function put(url, request) {
    return new Promise((resolve, reject) => {
        axios.put(url, request)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => {
            reject(e)
        })
    })
}
function destroy(url) {
    return new Promise((resolve, reject) => {
        axios.delete(url)
        .then(response => {
            resolve(response.data)
        })
        .catch(e => {
            reject(e)
        })
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
function getGenerateGroup(year, month) {
    return fetch('api/group/' + year + '/' + month + '/create')
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
            employees: [],
            departments: [],
            positions: [],
            selectedEmployee: [],
            newEmployee: [],
            search: {
                name: ''
            }
        },
        /*
        components: {
            editForm
        },
        */
        mounted() {
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
            searchByName: function(employees, name) {
                if (name === undefined || name === '') { return employees }
                return employees.filter(function (employee) {
                    return employee.name.indexOf(name) > 0
                })
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    getEmployees()
                    .then(response => {
                        this.employees = response
                        this.currentView = type
                    })
                } else {
                    this.currentView = type
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
                destroyEmployee(employee.id)
                .then(response => {
                    this.changeView(this.viewType.list)
                })
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
            departments: [],
            selectedDepartment: [],
            newDepartment: [],
            search: {
                name: ''
            }
        },
        /*
        components: {
            editForm
        },
        */
        mounted() {
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
            searchByName: function(departments, name) {
                if (name === undefined || name === '') { return departments }
                return departments.filter(function (department) {
                    return department.name.indexOf(name) > 0
                })
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    getDepartments()
                    .then(response => {
                        this.departments = response
                        this.currentView = type
                    })
                } else {
                    this.currentView = type
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
                createDepartment({
                    name: department.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitEdit: function(department) {
                updateDepartment(department.id, {
                    name: department.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitDelete: function(department) {
                destroyDepartment(department.id)
                .then(response => {
                    this.changeView(this.viewType.list)
                })
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
            positions: [],
            selectedPosition: [],
            newPosition: [],
            search: {
                name: ''
            }
        },
        mounted() {
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
            searchByName: function(positions, name) {
                if (name === undefined || name === '') { return positions }
                return positions.filter(function (position) {
                    return position.name.indexOf(name) > 0
                })
            },
            changeView: function(type) {
                if (type == this.viewType.list) {
                    getPositions()
                    .then(response => {
                        this.positions = response
                        this.currentView = type
                    })
                } else {
                    this.currentView = type
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
                createPosition({
                    name: position.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitEdit: function(position) {
                updatePosition(position.id, {
                    name: position.name,
                })
                .then(response => {
                    this.changeView(this.viewType.list)
                })
            },
            submitDelete: function(position) {
                destroyPosition(position.id)
                .then(response => {
                    this.changeView(this.viewType.list)
                })
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
            groupList: [],
            date: {
                year: '',
                month: ''
            }
        },
        mounted() {
            let date = new Date()
            this.date.year = date.getFullYear()
            this.date.month = date.getMonth() + 1

            checkAuth()
            .then(response => {
                this.isLogin = response.isLogin
            })
            getGroupList(this.date.year, this.date.month)
            .then(response => {
                this.groupList = response
            })
        },
        methods: {
            clickGenerate: function(year, month) {
                getGenerateGroup(year, month)
                .then(response => {
                    this.groupList = response
                })
            },
            clickDelete: function() {
                console.log('delete')
            }
        }
    })
}
