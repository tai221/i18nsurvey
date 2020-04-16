import { getUserInfo, login, logout } from '../../api/auth'
import {
    setToken, setTokenRemember, getToken, removeToken
} from '../../utils/auth'

const state = {
    token: getToken() || null,
    username: localStorage.getItem('username') || null

}

const mutations = {
    retrieveToken(state, token) {
        state.token = token
    },
    destroyToken(state) {
        state.token = null
    },
    setUsername(state, username) {
        state.username = username
    },
    deleteUsername(state) {
        state.username = null
    }
}

const actions = {
    retrieveToken(context, data) {
        return new Promise((resolve, reject) => {
            login(data.account)
                .then((response) => {
                    console.log(response.data)
                    const token = response.data.access_token
                    if (data.remember) {
                        setTokenRemember(token)
                    } else {
                        setToken(token)
                    }
                    localStorage.setItem('username', data.account.username)
                    context.commit('retrieveToken', token)
                    context.commit('setUsername', data.account.username)
                    resolve(response)
                })
                .catch((error) => {
                    console.log(error)
                    reject(error)
                })
        })
    },
    destroyToken(context) {
        return new Promise((resolve, reject) => {
            logout()
                .then((response) => {
                    removeToken()
                    localStorage.removeItem('username')
                    context.commit('destroyToken')
                    context.commit('deleteUsername')
                    resolve(response)
                })
                .catch((error) => {
                    removeToken()
                    context.commit('destroyToken')
                    context.commit('deleteUsername')
                    reject(error)
                })
        })
    },
    getUserInfo(context) {
        return new Promise((resolve, reject) => {
            getUserInfo()
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }

}

const getters = {
    loggedIn(state) {
        return state.token !== null
    },
    username(state) {
        return state.username
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
