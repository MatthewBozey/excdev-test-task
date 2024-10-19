import {createStore} from 'vuex';
import createMultiTabState from 'vuex-multi-tab-state';
import users from './modules/users.js'

export default createStore({
    state: {
        loading: false,
        secondary_loading: false
    },
    getters: {
        loading: (state) => (state.loading),
        secondary_loading: (state) => (state.secondary_loading)
    },
    mutations: {

        SET_LOADING: (state, value) => {
            state.loading = value;
        },

        SET_SECONDARY_LOADING: (state, value) => {
            state.secondary_loading = value;
        }
    },
    actions: {},
    modules: {
        users
    },
    plugins: [createMultiTabState()]
})
