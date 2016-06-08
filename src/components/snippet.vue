<template>
    <div class="snippet">
        <iframe class="snippet__iframe" :style="{height: iframeHeight+'px'}" v-el:iframe></iframe>
        <div class="snippet__source" :style="{height: sourceHeight+'px'}" v-el:source>
            <div class="snippet__source__drag" @mousedown="startDrag"></div>
            <div class="grid">
                <div class="col s4 m4 l4">
                    <div class="snippet__source__window html">
                        <pre><code v-el:html v-text="html"></code></pre>
                    </div>
                </div>
                <div class="col s4 m4 l4">
                    <div class="snippet__source__window style">
                        <pre><code v-el:style v-text="style"></code></pre>
                    </div>
                </div>
                <div class="col s4 m4 l4">
                    <div class="snippet__source__window script">
                        <pre><code v-el:script v-text="script"></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Highlight from 'highlight.js'
export default {
    route: {
        data () {
            this.id = this.$route.params.id
            this.loadSnippet()
        }
    },
    watch: {
        id (val) {
            this.$els.iframe.src = "api/view.php?alias="+val
        },
        sourceHeight (val) {
            //this.iframeHeight = window.innerHeight - headerHeight - footerHeight - val
        }
    },
    data() {
        return {
            id: null,
            iframeHeight: null,
            sourceHeight: 300,
            headerHeight: 50,
            footerHeight: 50,
            html: 'html',
            style: 'style',
            script: 'script',
            startY: null,
            startHeight: null
        }
    },
    ready () {
        this.iframeHeight = window.innerHeight - this.headerHeight - this.footerHeight - this.sourceHeight
        this.loadSnippet()
    },
    methods: {

        loadSnippet () {
            this.$http({
                url: 'api/snippets.php?id='+this.id,
                method: 'GET'
            }).then((response) => {
                this.html = response.data.html
                this.script = response.data.script
                this.style = response.data.style
                this.applyHighlight()
            })
        },

        startDrag (e) {
            console.log('startDrag')
            document.addEventListener('mousemove', this.onDrag)
            document.addEventListener('mouseup', this.stopDrag)
            this.startY = e.clientY
            this.startHeight = this.$els.source.offsetHeight
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.add('noselect')
        },

        onDrag (e) {
            console.log('onDrag')
            if(e.clientY > this.headerHeight && e.clientY < window.innerHeight + this.footerHeight) {
                this.sourceHeight = ((this.startY + this.startHeight) - e.clientY + 15)
                this.iframeHeight = window.innerHeight - this.headerHeight - this.footerHeight - this.sourceHeight
            }
        },

        stopDrag () {
            console.log('stop drag')
            document.removeEventListener('mousemove', this.onDrag)
            document.removeEventListener('mouseup', this.stopDrag)
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.remove('noselect')
        },

        applyHighlight () {
            Highlight.highlightBlock(this.$els.html)
            Highlight.highlightBlock(this.$els.style)
            Highlight.highlightBlock(this.$els.script)
        }
    },
}
</script>

<style lang="scss">
    @import 'node_modules/highlight.js/styles/github.css';
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
            background: rgba(0,0,0,.1);
            height: 350px;
            position: fixed;
            bottom: 50px;
            left: 0; right: 0;
            width: 100%;
            &__drag {
                background: rgba(0,0,0,.7);
                height: 15px;
                margin-bottom: 10px;
            }
            &__window {
                margin-right: 10px;
                background: rgba(0,0,0,.5);
                width: 100%;
                min-height: 300px;
            }
        }

    }
</style>
