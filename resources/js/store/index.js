import {createStore} from 'vuex';
import createMultiTabState from 'vuex-multi-tab-state';
import users from './modules/users.js'
import notification from "./modules/notification.js";
import user_balance from "./modules/user_balance.js";
import balance_operation from "./modules/balance_operation.js";
import operation_type from "./modules/operation_type.js";

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
        users,
        notification,
        user_balance,
        balance_operation,
        operation_type
    },
    plugins: [createMultiTabState()]
})
