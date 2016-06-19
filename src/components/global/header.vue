<template>
    <div class="app header">
        <h1>smccart.com <small>Playground and Portfolio for Sean McCart</small></h1>
        <div class="header__nav">
            <span class="header__nav__item" 
                v-for="item in nav" 
                v-link="'/'+item.alias" 
            >
                {{item.label}}
            </span>
        </div>
    </div>
</template>


<script>
export default {

    data () {
        return {
            menu: false,
            nav: [
                {'label': 'Snippets', 'alias': 'snippets'},
                {'label': 'Projects', 'alias': 'projects'},
                {'label': 'About', 'alias': 'about'},
                {'label': 'Contact', 'alias': 'contact'},
            ]
        }
    },

    methods: {
        toggleMenu () {
            this.menu = !this.menu
        },
    }
}
</script>


<style lang="scss">

@import '../../sass/vars';
    
    .header {
        position: fixed;
        top: 0; right: 0; left: 0;
        padding: 0px;
        z-index: 9999;
        @include bg-dark(.4);
        border-bottom: 3px solid;
        @include border-dark(.2)
        padding-left: 20px;
        height: 50px;
        box-sizing: border-box;
        h1{
            font-size: 1.3rem;
            color: rgba(255,255,255,1);
            float: left;
            font-weight: 700;
            margin: 0;
            line-height: 50px;
            small {
                font-size: .8rem;
                color: rgba(255,255,255,0.7);
            }
        }
        &__nav {
            float: right;
            padding: 0px 20px 0 0;
            &__item {
                display: inline-block;
                padding: 0 20px 0 20px;
                margin-right: 5px;
                line-height: 50px;
                box-sizing: border-box;
                font-size: .8rem;
                transition: all 0.2s ease;
                cursor: pointer;
                &:hover {
                    @include bg-dark(.4);
                }
            }
            &__login {

            }
            &__theme {

            }

        }
    }

</style>
