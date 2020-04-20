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
        },
        async login( {
            commit
        }, {
            email,
            password
        } ) {
            axios.post( '/api/kanban/auth/login', {
                email,
                password
            } ).then( response => {
                console.log( response.data )
            } )
        }
    },
}