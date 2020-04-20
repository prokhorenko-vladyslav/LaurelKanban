import { mapActions, mapState } from "vuex";

export default {
    computed: {
        ...mapState(['loadingPool', 'loadingPoolTimer']),
    },
    methods: {
        ...mapActions(['addToLoadingPool', 'removeFromLoadingPool']),
        appendInterceptors() {
            this.appendRequestInterceptor();
            this.appendResponseInterceptor();
        },
        appendRequestInterceptor() {
            axios.interceptors.request.use((config) => {
                this.addToLoadingPool();
                return config;
            });
        },
        appendResponseInterceptor() {
            axios.interceptors.response.use((response) => {
                this.removeFromLoadingPool();
                return response;
            }, error => {
                this.removeFromLoadingPool();
                return Promise.reject(error);
            });
        }
    }
}
