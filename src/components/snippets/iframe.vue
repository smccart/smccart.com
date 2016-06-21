<template>
    <div class="snippet__iframe" :style="{height: height}">
        <iframe :src="src" v-el:iframe v-show="!loading" transition="iframe"></iframe>
    </div>
</template>

<script>
export default {
    props: {
        height: {
            type: String,
            default: 'auto'
        },
        width: {
            type: String,
            default: '100%'
        },
        src: {
            type: String,
            default: 'about:blank'
        }
    },

    watch: {
        src () {
            console.log('src change')
            // this.loading = true
            // setTimeout(()=> {
            //     this.loading = false;
            // }, 500)
        }
    },

    data () {
        return {
            loading: true
        }
    },

    ready () {
            setTimeout(()=> {
                this.loading = false;
            }, 500)
    }
}
</script>

<style lang="scss">
    @import '../../sass/vars';
    .snippet__iframe {
        position: absolute;
        z-index: 1;
        top: 0px; right: 0px; bottom: 0; left: 0;
        box-sizing: border-box;
        &__loading {
            @include bg-dark(1);
            color: #FFF;
            line-height: 100%;
            vertical-align: middle;
            text-align: center;
            position: absolute;
            top: 0px; right: 0px; bottom: 0; left: 0; 
            &.load-transition {
                opacity: 1;
            }
            &.load-enter {
                transition: none;
            }
            &.load-leave {
                transition: all 0.3s ease;
                opacity: 0;
            }
        }
        iframe {
            border: none;
            @include bg-light(0.1);
            width: 100%;
            height: 100%;
            display: block;
            &.iframe-transition {
                transition: opacity 0.5s ease;
                opacity: 1;
            }
            &.iframe-leave {
                transition: none;
                opacity: 0;
            }
            &.iframe-enter {
                opacity: 0;
            }
        }
    }

</style>