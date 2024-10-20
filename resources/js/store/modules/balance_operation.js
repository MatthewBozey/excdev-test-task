export default {
    state: {
        balance_operation: {},
    },
    getters: {
        balance_operation: s => s.balance_operation,
    },
    mutations: {
        saveOperations(state, operations) {
            state.balance_operation = operations;
        },

        appendOperation(state, operation) {
            state.balance_operation.unshift(operation);
        }
    },
    actions: {
        saveOperations({ commit }, operations) {
            commit('saveOperations', operations)
        },

        appendOperation({ commit}, operation) {
            commit('appendOperation', operation);
        }
    },
    modules: {}
}
