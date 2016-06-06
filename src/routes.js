
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
    '/snippet/:id': {
        name: 'snippet',
        component: Snippet
    }
}