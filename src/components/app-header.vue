<template>
    <div class="app header">
        <h1>smccart.com <small>Playground and Portfolio for Sean McCart</small></h1>
        <div class="header__nav">
            <span class="header__nav__item" v-for="item in nav" v-link="'/'+item.alias">{{item.label}}</span>
            <div class="header__nav__menu">
                <i @click="toggleMenu" class="fa fa-bars"></i>
            </div>
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

    data () {
        return {
            nav: [
                {'label': 'Snippets', 'alias': 'snippets'},
                {'label': 'Projects', 'alias': 'projects'},
                {'label': 'Resources', 'alias': 'resources'},
                {'label': 'Contact', 'alias': 'contact'},
            ]
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
            padding: 10px 38px 0 0;
            span {
                display: inline-block;
                padding: 7px 20px 7px 20px;
                border: 1px solid rgba(255,255,255,0.05);
                background: rgba(255,255,255,0.03);
                margin-right: 5px;
                font-size: .8rem;
                border-radius: 3px;
                transition: all 0.2s ease;
                cursor: pointer;
                &:hover {
                    border: 1px solid rgba(255,255,255,0.3);
                    background: rgba(255,255,255,0.08);
                }
            }
            &__login {

            }
            &__theme {

            }
            &__menu {
                font-size: 24px;
                color: rgba(255,255,255,0.7);
                cursor: pointer;
                position: absolute;
                top: 10px; right: 10px;
            }

        }
    }

</style>
