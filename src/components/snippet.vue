<template>
    <div class="snippet">
        <iframe class="snippet__iframe" :style="{height: iframeHeight+'px'}" v-el:iframe></iframe>
        <div class="snippet__source" :style="{height: sourceHeight+'px'}" v-el:source>
            <div class="snippet__source__drag" @mousedown="startDrag"></div>
            <div class="grid">
                <div class="col s4 m4">
                    <div class="snippet__source__window html">
                        <header>HTML</header>
                        <pre><code class="html" v-el:html>{{html}}</code></pre>
                    </div>
                </div>
                <div class="col s4 m4">
                    <div class="snippet__source__window style">
                        <header>CSS</header>
                        <pre><code class="css" v-el:style v-text="style"></code></pre>
                    </div>
                </div>
                <div class="col s4 m4">
                    <div class="snippet__source__window script">
                        <header>JS</header>
                        <pre><code class="javascript" v-el:script v-text="script"></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>


<script>
import Scroll from 'perfect-scrollbar'
import Highlight from 'highlight.js'

export default {
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
            alias: 'default',
            iframeHeight: null,
            sourceHeight: 300,
            headerHeight: 50,
            footerHeight: 40,
            html: null,
            style: null,
            script: null,
            startY: null,
            startHeight: null
        }
    },
    ready () {
        this.iframeHeight = window.innerHeight - this.headerHeight - this.footerHeight - this.sourceHeight
    },
    methods: {

        loadSnippet () {
            this.$els.iframe.src = "api/view.php?alias="+this.alias
            this.$http({
                url: 'api/snippets.php?id='+this.alias,
                method: 'GET'
            }).then((response) => {
                this.html = response.data.html
                this.script = response.data.script
                this.style = response.data.style
                setTimeout(() => {
                    this.setWidths()
                    this.applyHighlight()
                    this.applyScroll()
                }, 10)

            })
        },

        startDrag (e) {
            document.addEventListener('mousemove', this.onDrag)
            document.addEventListener('mouseup', this.stopDrag)
            this.startY = e.clientY
            this.startHeight = this.$els.source.offsetHeight
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.add('noselect')
            this.$els.iframe.style.pointerEvents = "none";
        },

        onDrag (e) {
            if(e.clientY > this.headerHeight && e.clientY < window.innerHeight + this.footerHeight) {
                this.sourceHeight = ((this.startY + this.startHeight) - e.clientY)
                this.iframeHeight = window.innerHeight - this.headerHeight - this.footerHeight - this.sourceHeight
            }
        },

        stopDrag () {
            document.removeEventListener('mousemove', this.onDrag)
            document.removeEventListener('mouseup', this.stopDrag)
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.remove('noselect')
            this.$els.iframe.style.pointerEvents = "auto";
        },

        applyHighlight () {
            Highlight.highlightBlock(this.$els.html)
            Highlight.highlightBlock(this.$els.style)
            Highlight.highlightBlock(this.$els.script)
        },

        setWidths () {
            this.$els.html.style.width = this.$els.html.offsetWidth +'px'
            this.$els.style.style.width = this.$els.style.offsetWidth +'px'
            this.$els.script.style.width = this.$els.script.offsetWidth +'px'
        },

        applyScroll () {
            let options = {
                minScrollbarLength: 20,
                theme: 'smccart'
            }
           let pre_tags = this.$els.source.querySelectorAll('pre')
           for(i = 0; i < pre_tags.length; i++) {
                Scroll.destroy(pre_tags[i])
                Scroll.initialize(pre_tags[i], options)
           }
        }
    },
}
</script>

<style lang="scss">
    @import '../sass/vars';
    @import 'node_modules/perfect-scrollbar/src/css/main.scss';
    @import 'node_modules/highlight.js/styles/tomorrow-night-bright.css';

    .snippet {
        position: relative;
        width: 100%;
        height:400px;
        &__iframe {
            display: block;
            position: absolute;
            z-index: 1;
            top: 0; right: 0; bottom: 0; left: 0;
            width: 100%;
            height: 100%;
            border: none;
            background: #FFF;
        }
        &__source {
            @include bg-dark(.1);
            position: fixed;
            bottom: 40px; left: 0; right: 0;
            box-sizing: border-box;
            min-height: 150px;
            .grid {
                height: calc(100% - 30px);
                box-sizing: border-box;
                .col {
                    height: 100%;
                    box-sizing: border-box;
                    padding: 0 10px 0 0;
                    &:first-child {
                        padding-left: 10px;
                    }
                }
            }
            // .ps-theme-smccart {
            //     @include ps-container(map-merge($ps-theme-default, (
            //         border-radius: 3px,
            //         rail-default-opacity: 1,
            //         rail-container-hover-opacity: 1,
            //         rail-hover-opacity: 1,
            //         bar-bg: #000,
            //         bar-container-hover-bg: #aaa,
            //         bar-hover-bg: #999,
            //         rail-hover-bg: #eee
            //     )));
            // }
            code{
                margin: 0;
                font-size: .8rem;
                @include bg-dark(0);
                font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
                width: 100%;
            }
            pre {
                height: calc(100% - 30px);
                position: relative;
                overflow: hidden;
                margin: 0;
            }
            &__drag {
                @include bg-dark(.4);
                height: 10px;
                margin-bottom: 10px;
                cursor: row-resize;
            }
            &__window {
                @include bg-dark(.4);
                width: 100%;
                height: 100%;
                border-radius: 3px;
                header {
                    @include text-light(.8);
                    font-size: 1rem;
                    font-weight: 300;
                    height: 30px;
                    box-sizing: border-box;
                    padding: 6px 10px 0 10px;
                    @include bg-dark(.25);
                    border-bottom: 1px solid;
                    @include border-dark(.3);
                    border-radius: 3px;
                }
            }
        }

    }
</style>
