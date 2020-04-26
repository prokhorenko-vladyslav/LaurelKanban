export default {
    namespaced: true,
    state: {

    },
    mutations: {

    },
    getters: {

    },
    actions: {
        async updateCollumn({ commit }, { name, order, deskId, collumnId }) {
            return axios
                    .put(`/api/kanban/desk/${deskId}/collumn/${collumnId}`, {
                        name,
                        order
                    })
                    .then( response => {
                        return response.data;
                    });
        }
    },
}
