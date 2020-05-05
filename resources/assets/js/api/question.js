import request from '../utils/request'

export function create(data) {
    return request({
        url: '/api/question/create',
        method: 'post',
        data
    })
}

export function fetchSurvey(id) {
    return request({
        url: `/api/survey/fetch/${id}`,
        method: 'get',
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
