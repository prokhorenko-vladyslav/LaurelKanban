import Vue from "vue";
import Vuex from "vuex";
import { sync } from 'vuex-router-sync';
import store from '../Store/Main'
import router from '../Config/vue-router';

sync(store, router);
Vue.use( Vuex );
