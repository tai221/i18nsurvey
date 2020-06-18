import request from '../utils/request'

export function create(data) {
    return request({
        url: '/api/survey/create',
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

export function countPage(id) {
    return request({
        url: `/api/survey/countPage/${id}`,
        method: 'get',
    })
}

export function getListSurvey() {
    return request({
        url: '/api/survey/getListSurvey',
        method: 'get'
    })
}

export function deleteSurvey(data) {
    return request({
        url: '/api/survey/deleteSurvey',
        method: 'post',
        data
    })
}

export function changeStateActive(data) {
    return request({
        url: '/api/survey/changeStateActive',
        method: 'post',
        data
    })
}
