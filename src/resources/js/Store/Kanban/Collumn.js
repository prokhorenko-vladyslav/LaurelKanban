export default {
    namespaced: true,
    mutations: {
        startDragging: state => state.dragging = true,
        endDragging: state => state.dragging = false,
        setDraggableCollumn: (state, draggableCollumn) => state.draggableCollumn = draggableCollumn,
    },
    actions: {
        async addCollumn({ commit }, { name, order, deskId }) {
            return axios
                .post(`/api/kanban/desk/${deskId}/collumn`, {
                    name,
                    order
                })
                .then( response => {
                    return response.data;
                });
        },
        async updateCollumn({ commit }, { name, order, deskId, collumnId }) {
            return axios
                    .put(`/api/kanban/desk/${deskId}/collumn/${collumnId}`, {
                        name,
                        order
                    })
                    .then( response => {
                        return response.data;
                    });
        },
        async updateCollumnOrdering({} , { deskId, newCollumnsOrdering }) {
            return axios
                .put(`/api/kanban/desk/${deskId}/collumn/reorder`, {
                    order : newCollumnsOrdering
                })
                .then( response => {
                    return response.data;
                });
        }
    },
}
