export default {
    namespaced: true,
    state: {
        desks : []
    },
    mutations: {
        setDesks: (state, desks) => state.desks = desks,
    },
    getters: {

    },
    actions: {
        async loadDesks({ commit }) {
            axios
                .get('/api/kanban/desk')
                .then( response => {
                    commit('setDesks', response.data.data);
                })
        }
    },
}
