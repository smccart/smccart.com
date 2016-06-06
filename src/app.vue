<template>
    <div id="app">
        <app-header :menu.sync="menuOpen"></app-header>

        <app-menu :view.sync="article" :data="articles" v-if="menuOpen" transition="menu"></app-menu>

        <main>
            <router-view></router-view>
        </main>

<!--         <app-article :alias="article"></app-article> -->

        <app-source :data="data"></app-source>

        <app-footer></app-footer>
    </div>
</template>

<script>
import AppHeader from './components/app-header.vue'
import AppFooter from './components/app-footer.vue'
import AppSource from './components/source.vue'
import AppMenu from './components/menu.vue'
import AppArticle from './components/article.vue'

export default {
    replace: false,

    ready () {
        this.$http({
            url: 'api/articles.php',
            method: 'GET'
        }).then((response) => {
            this.articles = response.data
            this.article = this.articles[0].alias
        })


    },

    components: {
        AppHeader,
        AppFooter,
        AppSource,
        AppMenu,
        AppArticle
    },

    data () {
        return {
            articles: null,
            menuOpen: false,
            article: 'my-first-post'
        }
    }
}
</script>

<style lang="scss">
body {
    font-family: Helvetica, sans-serif;
}

.menu-transition {
    transition: all 0.3s ease;
    transform: translateX(0px);
}
.menu-enter, .menu-leave {
    transform: translateX(280px);
}

</style>
