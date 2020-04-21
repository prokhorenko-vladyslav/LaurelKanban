import { mapActions, mapState } from "vuex";

export default {
    computed: {
        ...mapState(['loadingPool', 'loadingPoolTimer']),
        ...mapState('Auth', ['accessToken', 'tokenType']),
    },
    methods: {
        ...mapActions(['addToLoadingPool', 'removeFromLoadingPool']),
        ...mapActions('Auth', ['isAuth']),
        appendInterceptors() {
            this.appendRequestInterceptor();
            this.appendResponseInterceptor();
        },
        appendRequestInterceptor() {
            axios.interceptors.request.use(async (config) => {
                this.addToLoadingPool();

                let isAuth = await this.isAuth();

                console.log(isAuth, `${this.tokenType} ${this.accessToken}`);
                if (isAuth)
                    config.headers.Authorization = `${this.tokenType} ${this.accessToken}`;

                return config;
            });
        },
        appendResponseInterceptor() {
            axios.interceptors.response.use((response) => {

                console.log(response);
                this.removeFromLoadingPool();
                return response;
            }, error => {
                this.removeFromLoadingPool();
                return Promise.reject(error);
            });
        }
    }
}
