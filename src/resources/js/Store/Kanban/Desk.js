export default {
    namespaced: true,
    state: {
        desks : []
    },
    mutations: {
        setDesks: (state, desks) => state.desks = desks,
        pushNewDesk : (state, desk) => state.desks.push(desk),
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
        },
        addDesk({ commit }, { name, description, isFavorite, isPrivate }) {
            return axios
                .post(`/api/kanban/desk`, {
                    name,
                    description,
                    isFavorite,
                    isPrivate
                })
                .then( response => {
                    if (response.data.status) {
                        commit('pushNewDesk', {
                            id : response.data.data.id,
                            name,
                            description,
                            isFavorite,
                            isPrivate
                        });
                    }

                    return response.data;
                })
                .catch( error => {
                    if (error.response.data.errors) {
                        return {
                            status : false,
                            errors : error.response.data.errors,
                        }
                    }
                })
        }
    },
}
