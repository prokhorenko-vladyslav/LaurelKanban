export default {
    namespaced: true,
    state: {
        user: {},
    },
    mutations: {

    },
    getters: {

    },
    actions: {
        async init( {
            commit
        } ) {
            axios
                .get( '/api/kanban/auth/init' )
                .then( response => {
                    console.log( response.data );
                } )
        }
    },
}