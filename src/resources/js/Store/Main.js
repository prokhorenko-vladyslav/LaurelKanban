import Vuex from "vuex";
import modules from "./Bootstrap";

const store = new Vuex.Store( {
    getters: {
        // getRouter: state => $router,
    },
    modules,
} );

export default store;
