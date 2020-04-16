import request from '../utils/request'

export function create(data) {
    return request({
        url: '/api/email/create',
        method: 'post',
        data
    })
}

export function fetchList(data) {
    return request({
        url: '/api/email/get',
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
