const state = {
    survey_id: localStorage.getItem('survey_id') || null,
}

const mutations = {
    setSuveyId(state, id) {
        state.survey_id = id
    },
    deleteSurveyId(state) {
        state.survey_id = null
    }
}

const actions = {
    setSuveyId: ({ commit }, id) => {
        localStorage.setItem('survey_id', id)
        commit('setSuveyId', id)
    },
    deleteSurveyId: ({ commit }) => {
        localStorage.removeItem('survey_id')
        commit('deleteSurveyId')
    }
}

const getters = {
    surveyId(state) {
        return state.survey_id
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
