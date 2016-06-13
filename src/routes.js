
// Views
import Home from './components/home.vue'
import Snippet from './components/snippet.vue'
import Login from './components/login.vue'


export default {
    '/': {
        component: Home
    },
    '/login': {
      component: Login
    },
    '/snippets': {
        component: Snippet
    },
    '/snippets/:alias': {
        name: 'snippets',
        component: Snippet
    }
}