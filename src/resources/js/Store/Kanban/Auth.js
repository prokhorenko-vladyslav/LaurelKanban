export default {
    namespaced: true,
    state: {
        user: {},
        accessToken : null,
        tokenType : null,
    },
    mutations: {
        setAccessToken: (state, accessToken) => state.accessToken = accessToken,
        setTokenType: (state, tokenType) => state.tokenType = tokenType,
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
            return axios.post( '/api/kanban/auth/login', {
                email,
                password
            } ).then( response => {
                if (response.data.errors)
                    return {
                        status: false,
                        errors : response.data.errors
                    };
                else {
                    commit('setAccessToken', response.data.access_token);
                    commit('setTokenType', response.data.token_type);

                    return {
                        status: true
                    };
                }
            } )
        }
    },
}
