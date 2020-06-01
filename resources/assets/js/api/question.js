import request from '../utils/request'

export function create(data) {
    return request({
        url: '/api/question/create',
        method: 'post',
        data
    })
}

export function getListQuestions(data) {
    return request({
        url: `/api/question/getListQuestions`,
        method: 'post',
        data
    })
}
export function getQuestion(data) {
    return request({
        url: `/api/question/getQuestion`,
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
