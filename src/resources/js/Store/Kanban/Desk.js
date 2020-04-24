export default {
    namespaced: true,
    state: {
        desks : []
    },
    mutations: {

    },
    getters: {

    },
    actions: {
        async loadDesks({ commit }) {
            axios
                .get('/api/kanban/desk')
                .then( response => {
                    console.log(response.data);
                })
        }
    },
}
