import Vue from 'vue'
import App from './app.vue'
import Routes from './routes.js'
import VueResource from 'vue-resource'
import Router from 'vue-router'

//Vue Resource
Vue.use(VueResource);
Vue.http.options.root = '';
Vue.http.headers.common['Authorization'] = 'Basic YXBpOnBhc3N3b3Jk';

// Developer Mode
Vue.config.devtools = true


//Router
Vue.use( Router )
var router = new Router( )
router.map( Routes )
router.start( App, 'body' )