import axios from 'axios'
import auth from '../store/modules/auth'

// create an axios instance
const service = axios.create({
    baseURL: 'http://127.0.0.1:8000',
    timeout: 30000 // request timeout
})

// request interceptor
service.interceptors.request.use(
    (config) => {
        // Do something before request is sent
        if (auth.state.token) {
            config.headers.Authorization = `Bearer ${auth.state.token}`
        }
        return config
    },
    (error) => {
        // Do something with request error
        console.log("error at request interceptor") // for debug
        Promise.reject(error)
    }
)

// response interceptor
service.interceptors.response.use(
    (response) => response,
    (error) => {
        console.log(`err${error}`) // for debug
        Message({
            message: error.message,
            type: 'error',
            duration: 5 * 1000
        })
        return Promise.reject(error)
    }
)

export default service
