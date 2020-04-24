export default {
    namespaced: true,
    state: {
        user: null,
        accessToken : null,
        tokenType : null,
        initiated: false,
    },
    mutations: {
        setAccessToken: (state, accessToken) => {
            state.accessToken = accessToken;
        },
        setTokenType: (state, tokenType) => {
            state.tokenType = tokenType;
        },
        clearLocalStorageFromAuth: state => {
            localStorage.accessToken = null;
            localStorage.tokenType = null;
        },
        setUser: (state, user) => state.user = user,
        setInitiated: (state, initiated) => state.initiated = initiated,
    },
    getters: {
        getAccessToken: state => state.accessToken,
        getTokenType: state => state.tokenType,
        getInitiated: state => state.initiated,
    },
    actions: {
        async isAuth({ getters, dispatch }) {
            let isInLocalStorage = await dispatch('checkLocalStorage');
            return getters['getAccessToken'] && getters['getTokenType'] || isInLocalStorage;
        },
        checkLocalStorage({ commit }) {
            if (
                !localStorage.accessToken || !localStorage.tokenType ||
                localStorage.accessToken === 'null' || localStorage.accessToken === 'null'
            )
                return false;
            else {
                commit('setAccessToken', localStorage.accessToken);
                commit('setTokenType', localStorage.tokenType);
                return true;
            }
        },
        async init( {
            commit, getters
        } ) {
            if (!getters['getInitiated']) {
                axios
                    .get( '/api/kanban/auth/init' )
                    .then( response => {
                        commit('setUser', response.data.data);
                        commit('setInitiated', true);
                    } )
            }
        },
        async login( { commit }, { email, password } ) {
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
                    localStorage.accessToken = response.data.access_token;
                    localStorage.tokenType = response.data.token_type;

                    return {
                        status: true
                    };
                }
            } )
            .catch(error => {
                return {
                    status : false,
                    errors: error.response.data.errors,
                }
            })
        },
        async logout( { commit }) {
            return axios.get('/api/kanban/auth/logout').then( response => {
                if (response.status) {
                    commit('setAccessToken', null);
                    commit('setTokenType', null);
                    commit('clearLocalStorageFromAuth');
                    commit('setUser', null);
                }
            });
        },
        async register( { commit, dispatch }, { name, email, password, password_confirmation } ) {
            let isAuth = await dispatch('isAuth');
            if (isAuth) {
                await dispatch('logout');
            }
            return axios.post( '/api/kanban/auth/register', {
                name,
                email,
                password,
                password_confirmation
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
                .catch(error => {
                    return {
                        status : false,
                        errors: error.response.data.errors,
                    }
                })
        },
    },
}
