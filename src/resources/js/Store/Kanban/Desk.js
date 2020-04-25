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
        },
        async loadDesk({ commit }, deskId) {
            return axios
                .get(`/api/kanban/desk/${deskId}`)
                .then( response => {
                    if (response.data.data)
                        return response.data.data;
                    else
                        return false;
                })
        }
    },
}
