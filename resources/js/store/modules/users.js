export default {
    state: {
        users: [],
    },
    getters: {
        users: s => s.users,
        getUserById: (state) => (id) => {
            return state.users.find(u => u.id === id)
        }
    },
    mutations: {
        saveUsers(state, users) {
            state.users = users;
        },

        pushUser(state, user) {
            state.users.push(user);
        },

        deleteUser(state, data) {
            const index = state.users.findIndex(u => u.id === data.id);
            console.log(index);
            if (index !== -1) {
                state.users.splice(index, 1);
            }
        },

        replaceUser(state, data) {
            const index = state.users.findIndex(u => u.id === data.id);
            if (index !== -1) {
                state.users.splice(index, 1, data);
            }
        }
    },
    actions: {
        saveUsers({ commit }, users) {
            commit('saveUsers', users)
        },

        pushUser( { commit }, user) {
            commit('pushUser', user);
        },

        deleteUserById( { commit }, data) {
            commit('deleteUser', data);
        },

        replaceUser( { commit }, data) {
            commit('replaceUser', data);
        },
    },
    modules: {}
}
