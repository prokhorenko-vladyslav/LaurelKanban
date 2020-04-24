import Vue from "vue";
import Vuelidate from 'vuelidate';

Vue.use(Vuelidate)

const files = require.context( '../', true, /\.vue$/i )
files.keys().map( key => Vue.component( key.split( '/' ).pop().split( '.' )[ 0 ], files( key ).default ) );
