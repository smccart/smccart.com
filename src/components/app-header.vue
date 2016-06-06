<template>
    <div class="app header">
        <h1>smccart.com <small>Playground and Portfolio for Sean McCart</small></h1>
        <div class="header__nav">
            <span class="header__nav__theme">Theme</span>
            <span class="header__nav__login" v-link="'/login'">Login</span>
            <i @click="toggleMenu" class="header__nav__menu fa fa-bars"></i>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        menu: {
            type: Boolean,
            required: true
        }
    },

    methods: {
        toggleMenu () {
            this.menu = !this.menu
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
        padding-top: 45px;
    }

    .header {
        background: rgba(0,0,0,.3);
        position: fixed;
        top: 0; right: 0; left: 0;
        padding-left: 20px;
        height: 50px;
        box-sizing: border-box;
        h1{
            font-size: 1.3rem;
            color: rgba(255,255,255,1);
            float: left;
            small {
                font-size: .8rem;
                color: rgba(255,255,255,0.7);
            }
        }
        &__nav {
            float: right;
            padding: 10px 10px 0 0;
            span {
                display: inline-block;
                padding: 5px 15px 5px 15px;
                border: 1px solid rgba(255,255,255,0.5);
                margin-right: 10px;
                font-size: .8rem;
            }
            &__login {

            }
            &__theme {

            }
            &__menu {
                font-size: 24px;
                cursor: pointer;
            }

        }
    }

</style>
