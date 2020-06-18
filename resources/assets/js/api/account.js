import request from '../utils/request'

export function createAccount(data) {
    return request({
        url: '/api/account/create',
        method: 'post',
        data
    })
}

export function fetchListAccount(data) {
    return request({
        url: '/api/account/get',
        method: 'post',
        data
    })
}

export function deleteAccount(data) {
    return request({
        url: '/api/account/delete',
        method: 'post',
        data
    })
}

export function lockAccount(data) {
    return request({
        url: '/api/account/lock',
        method: 'post',
        data
    })
}

export function unlockAccount(data) {
    return request({
        url: '/api/account/unlock',
        method: 'post',
        data
    })
}
