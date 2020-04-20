export default {
    namespaced: true,
    state: {
        user: {},
        accessToken : null,
        tokenType : null,
    },
    mutations: {
        setAccessToken: (state, accessToken) => {
            state.accessToken = accessToken;
            if (accessToken)
                localStorage.accessToken = accessToken;
        },
        setTokenType: (state, tokenType) => {
            state.tokenType = tokenType;
            if (tokenType)
                localStorage.tokenType = tokenType;
        },
    },
    getters: {
        getAccessToken: state => state.accessToken,
        getTokenType: state => state.tokenType,
    },
    actions: {
        async isAuth({ getters, dispatch }) {
            let isInLocalStorage = await dispatch('checkLocalStorage');
            return getters['getAccessToken'] && getters['getTokenType'] || isInLocalStorage;
        },
        checkLocalStorage({ commit }) {
            if (!localStorage.accessToken || !localStorage.tokenType)
                return false;
            else {
                commit('setAccessToken', localStorage.accesToken);
                commit('setTokenType', localStorage.accesToken);
                return true;
            }
        },
        async init( {
            commit
        } ) {
            axios
                .get( '/api/kanban/auth/init' )
                .then( response => {

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
