<template>
    <div id="app">
        <app-header :menu.sync="menuOpen"></app-header>

        <app-menu :view.sync="view" :data="snippets" v-if="menuOpen" transition="menu"></app-menu>

        <main>
            <router-view></router-view>
        </main>

        <app-footer></app-footer>
    </div>
</template>

<script>
import AppHeader from './components/app-header.vue'
import AppFooter from './components/app-footer.vue'
import AppMenu from './components/menu.vue'

export default {
    replace: false,

    ready () {
        
        this.$http({
            url: 'server/snippets.php',
            method: 'GET'
        }).then((response) => {
            this.snippets = response.data
            this.snippet = this.snippets[0].alias
        })


    },

    components: {
        AppHeader,
        AppFooter,
        AppMenu
    },

    data () {
        return {
            articles: null,
            menuOpen: false,
            view: 'home'
        }
    }
}
</script>

<style lang="scss">
    @import url(https://fonts.googleapis.com/css?family=Raleway);

    body {
        font-family: 'Raleway', sans-serif;
        background: #2e425f;
        color: #FFF;
        letter-spacing: 1px;
        padding: 0;
        margin: 0;
        padding-top: 50px;
    }

.menu-transition {
    transition: all 0.3s ease;
    transform: translateX(0px);
}
.menu-enter, .menu-leave {
    transform: translateX(280px);
}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none;   /* Chrome/Safari/Opera */
  -khtml-user-select: none;    /* Konqueror */
  -moz-user-select: none;      /* Firefox */
  -ms-user-select: none;       /* Internet Explorer/Edge */
  user-select: none;           /* Non-prefixed version, currently
                                  not supported by any browser */
}

</style>
