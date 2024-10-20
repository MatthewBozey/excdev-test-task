export default {
    state: {
        operation_type: {},
    },
    getters: {
        operation_type: s => s.operation_type,
    },
    mutations: {
        saveOperationType(state, operation) {
            state.operation_type = operation;
        },

        appendOperationType(state, operation) {
            state.operation_type.unshift(operation);
        }
    },
    actions: {
        saveOperationTypes({ commit }, t) {
            commit('saveOperationType', t)
        },

        appendOperationType({ commit}, operation) {
            commit('appendOperationType', operation);
        }
    },
    modules: {}
}
