import Vue from 'vue'
import Vuex from 'vuex'
import config from './modules/config'
import user from './modules/user'
import * as actions from './actions'
import * as getters from './getters'
import * as mutations from './mutations'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
        config: {},
    },
    modules: {
        config,
        rounds,
        user 
    },
    strict: debug,
    plugins: []      
})