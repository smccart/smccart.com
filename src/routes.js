
// Views
import Home from './components/home.vue'
import Snippets from './components/snippets/index.vue'
import Login from './components/login.vue'


export default {
    '/': {
        component: Home
    },
    '/login': {
      component: Login
    },
    '/snippets': {
        component: Snippets
    },
    '/snippets/:alias': {
        name: 'snippets',
        component: Snippets
    }
}