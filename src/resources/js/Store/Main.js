import Vuex from "vuex";

export default new Vuex.Store( {
    modules: () => console.log( import( './Bootstrap' ) ),
} );