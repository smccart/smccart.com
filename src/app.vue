<template>
    <div id="app">
        <app-header :view="view"></app-header>

        <main>
            <router-view transition="app"></router-view>
        </main>

        <app-footer></app-footer>
    </div>
</template>

<script type="text/babel">
import AppHeader from './components/global/header.vue'
import AppFooter from './components/global/footer.vue'

export default {
    replace: false,

    ready () {
        
        this.$http({
            url: 'server/snippets.php?request=list',
            method: 'GET'
        }).then((response) => {
            this.snippets = response.data
            this.snippet = this.snippets[0].alias
        })


    },

    components: {
        AppHeader,
        AppFooter
    },

    data () {
        return {
            view: 'home'
        }
    }
}
</script>

<style lang="scss">
    
    @import url(https://fonts.googleapis.com/icon?family=Material+Icons);
    @import url(https://fonts.googleapis.com/css?family=Raleway);

    .app-transition {
        transition: all 0.4s ease;
        opacity: 1;
    }
    .app-enter, .app-leave {
        opacity: 0;
    }

    body {
        font-family: 'Raleway', sans-serif;
        //background-image: url("http://www.planwallpaper.com/static/images/kartandtinki1_photo-wallpapers_02.jpg");
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-color: #22252E;
        background-size: cover;
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
