import request from '../utils/request'

export function logout() {
    return request({
        url: '/api/logout',
        method: 'post'
    })
}

export function login(data) {
    return request({
        url: '/api/login',
        method: 'post',
        data
    })
}

export function getUserInfo() {
    return request({
        url: '/api/getUserInfo',
        method: 'post'
    })
}

export function sendMail(data) {
    return request({
        url: '/api/password/create',
        method: 'post',
        data
    })
}
