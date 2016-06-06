
// Views
import Home from './components/home.vue'
import Article from './components/article.vue'
import Login from './components/login.vue'


export default {
    '/': {
        component: Home
    },
    '/login': {
      component: Login
    },
    '/article/:id': {
        name: 'article',
        component: Article
    }
}