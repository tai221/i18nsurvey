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

export function deleteParticipant(data) {
    return request({
        url: '/api/email/delete',
        method: 'post',
        data
    })
}

export function lockMail(data) {
    return request({
        url: '/api/email/lock',
        method: 'post',
        data
    })
}

export function unlockMail(data) {
    return request({
        url: '/api/email/unlock',
        method: 'post',
        data
    })
}
