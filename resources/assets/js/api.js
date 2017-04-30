function fetch(url) {
    return new Promise((resolve, reject) => {
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

export function checkAuth() {
    return fetch('api/auth')
}
export function getEmployees() {
    return fetch('api/employee/list')
}
export function createEmployee(request) {
    return post('api/employee', request)
}
export function updateEmployee(id, request) {
    return put('api/employee/' + id, request)
}
export function destroyEmployee(id, request) {
    return destroy('api/employee/' + id, request)
}

export function getDepartments() {
    return fetch('api/department/list')
}
export function createDepartment(request) {
    return post('api/department', request)
}
export function updateDepartment(id, request) {
    return put('api/department/' + id, request)
}
export function destroyDepartment(id, request) {
    return destroy('api/department/' + id, request)
}

export function getPositions() {
    return fetch('api/position/list')
}
export function createPosition(request) {
    return post('api/position', request)
}
export function updatePosition(id, request) {
    return put('api/position/' + id, request)
}
export function destroyPosition(id, request) {
    return destroy('api/position/' + id, request)
}

export function getGroupList(year, month) {
    return fetch('api/group/' + year + '/' + month + '/list')
}
export function getGenerateGroup(year, month, groupNumber) {
    return fetch('api/group/' + year + '/' + month + '/create/' + groupNumber)
}
export function createGroup(year, month, request) {
    return post('api/group/' + year + '/' + month, request)
}
export function destroyGroup(year, month) {
    return destroy('api/group/' + year + '/' + month)
}

