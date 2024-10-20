export default {
    state: {
        user_info: {},
    },
    getters: {
        user_info: s => s.user_info,
    },
    mutations: {
        saveUserInfo(state, users) {
            state.user_info = users;
        },

    },
    actions: {
        saveUserInfo({ commit }, info) {
            commit('saveUserInfo', info)
        }
    },
    modules: {}
}
