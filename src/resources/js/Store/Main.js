import Vuex from "vuex";
import modules from "./Bootstrap";

const store = new Vuex.Store( {
    modules,
} );

export default store;