<template>
    <div class="snippet">
        <snippet-iframe :src="iframeSrc" :height="ySplit+'px'" :style="{right: windowWidth-xSplit + 'px'}" v-el:iframe></snippet-iframe>
        <snippet-menu :data="menuData" :height="ySplit+'px'" :width="windowWidth-xSplit+'px'"></snippet-menu>
        <div class="snippet__ysplit" :style="{top: ySplit + 'px'}" @mousedown="dragY"></div>
        <div class="snippet__xsplit" :style="{left: xSplit + 'px', height: ySplit+'px'}" @mousedown="dragX"></div>
        <snippet-source 
            @change="save" 
            :data="source" 
            :height="windowHeight-ySplit-footerHeight-headerHeight+'px'" 
        >
        </snippet-source>
    </div>
</template>


<script>
import SnippetIframe from './iframe.vue'
import SnippetMenu from './menu.vue'
import SnippetSource from './source.vue'

export default {
    components: {
        'snippet-iframe': SnippetIframe,
        'snippet-menu': SnippetMenu,
        'snippet-source': SnippetSource
    },
    route: {
        data () {
            if(typeof this.$route.params.alias !== 'undefined') {
                this.alias = this.$route.params.alias
            }
            this.loadSnippet()
        }
    },
    data() {
        return {
            menuData: null,
            source: {
                html: {},
                script: {},
                style: {}
            },
            alias: 'default',
            title: '',
            ySplit: 400,
            xSplit: 300,
            drag: null,
            iframeSrc: null,
            headerHeight: 50,
            footerHeight: 40,
            windowHeight: null,
            windowWidth: null,
            save_delay: 1000,
            save_interval: null,
            read_only: false,
            loading: true
        }
    },
    ready () {
        this.loadMenu()
        this.windowHeight = window.innerHeight
        this.windowWidth = window.innerWidth
        this.xSplit = this.windowWidth - this.xSplit
        this.ySplit = this.windowHeight - this.ySplit
        window.addEventListener('resize', () => {
            this.onDrag()
        })
    },
    methods: {

        loadMenu () {
            this.$http({
                url: 'server/snippets.php?request=list',
                method: 'GET'
            }).then((response) => {
                this.menuData = response.data
            })
        },

        loadSnippet () {
            this.loading = true
            this.iframeSrc = "server/view.php?alias="+this.alias
            this.$http({
                url: 'server/snippets.php?request=get&alias='+this.alias,
                method: 'GET'
            }).then((response) => {
                this.source = {
                    html: {
                        raw: response.data.html,
                        lang: response.data.html_lang
                    },
                    style: {
                        raw: response.data.style,
                        lang: response.data.style_lang
                    },
                    script: {
                        raw: response.data.script,
                        lang: response.data.script_lang
                    }
                }
                setTimeout(() => {
                    this.loading = false
                }, 10)
                
            })
        },

        dragY () {
            this.drag = 'y'
            this.startDrag()
        },

        dragX () {
            this.drag = 'x'
            this.startDrag()
        },

        startDrag () {
            document.addEventListener('mousemove', this.onDrag)
            document.addEventListener('mouseup', this.stopDrag)
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.add('noselect')
            this.$els.iframe.style.pointerEvents = "none"
        },

        onDrag (e) {
            this.windowHeight = window.innerHeight
            this.windowWidth = window.innerWidth
            if(this.drag === 'y') {
                let clientY = (typeof e.clientY !== 'undefined') ? e.clientY : 0
                if(clientY > this.headerHeight && clientY < window.innerHeight + this.footerHeight) {
                    this.ySplit = e.clientY - this.headerHeight
                }
            } else if(this.drag === 'x') {
                this.xSplit = e.clientX
            }
        },

        stopDrag () {
            document.removeEventListener('mousemove', this.onDrag)
            document.removeEventListener('mouseup', this.stopDrag)
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.remove('noselect')
            this.$els.iframe.style.pointerEvents = "auto";
        },

        save (source) {

            if(!this.read_only && !this.loading) {
                clearInterval(this.save_interval)
                this.save_interval = setInterval(() => {
                    this.$http({
                        url: 'server/snippets.php?request=update&alias='+this.alias,
                        method: 'POST',
                        emulateJSON: true,
                        emulateHTTP: true,
                        data: source
                    }).then((response) => {
                        console.log('save successful')
                        this.iframeSrc = "server/view.php?alias="+this.alias+"&"+ Math.floor((Math.random() * 100000) + 1);
                    })
                    clearInterval(this.save_interval)
                }, this.save_delay)
            }
           
        }

    }
}
</script>

<style lang="scss">
    @import '../../sass/vars';

    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
     
    ::-webkit-scrollbar-track {
        @include bg-dark(.15);
        border-radius: 0px;
    }
     
    ::-webkit-scrollbar-thumb {
        border-radius: 0px;
        @include bg-dark(.3);
    }
    .snippet {
        position: relative;
        width: 100%;
        &__ysplit {
            position: absolute;
            width: 100%;
            z-index: 99999;
            @include bg-dark(.4);
            height: 3px;
            cursor: row-resize;
        }
        &__xsplit {
            position: absolute;
            height: 300px;
            z-index: 99999;
            @include bg-dark(.4);
            width: 3px;
            cursor: col-resize;
        }
        &__source {
            padding-top: 15px;
        }

    }
</style>
