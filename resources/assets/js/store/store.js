import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import survey from "./modules/survey";

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules: {
        auth,
        survey,

    }
})