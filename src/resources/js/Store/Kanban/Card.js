export default {
    namespaced: true,
    state: {

    },
    mutations: {

    },
    getters: {

    },
    actions: {
        async addNewCard({ commit }, { name, description, order, deskId, collumnId }) {
            return axios
                .post(`/api/kanban/desk/${deskId}/card`, {
                    name,
                    description,
                    order,
                    collumn_id : collumnId
                })
                .then( response => {
                    return response.data;
                });
        }
    },
}
