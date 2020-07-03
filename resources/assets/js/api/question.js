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
export function getAllQuestions(data) {
    return request({
        url: `/api/question/getAllQuestions`,
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

export function deleteQuestion(data) {
    return request({
        url: '/api/question/deleteQuestion',
        method: 'post',
        data
    })
}

export function sendMail(data) {
    return request({
        url: '/api/password/create',
        method: 'post',
        data
    })
}

// export function uploadImage() {
//     return request({
//         url: '/api/image/upload',
//         method: 'post',
//     })
// }
