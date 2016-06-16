<template>
    <div class="snippet">
        <iframe class="snippet__iframe" :style="{height: iframeHeight+'px'}" v-el:iframe></iframe>
        <div class="snippet__source" :style="{height: sourceHeight+'px'}" v-el:source>
            <div class="snippet__source__drag" @mousedown="startDrag"></div>
            <div class="grid">
                <div class="col s4 m4">
                    <div class="snippet__source__window html">
                        <header>HTML</header>
                        <pre v-el:html>{{html}}</pre>
                    </div>
                </div>
                <div class="col s4 m4">
                    <div class="snippet__source__window style">
                        <header>CSS</header>
                        <pre v-el:style v-text="style"></pre>
                    </div>
                </div>
                <div class="col s4 m4">
                    <div class="snippet__source__window script">
                        <header>JS</header>
                        <pre v-el:script v-text="script"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>


<script>

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
            startHeight: null,
            html_editor: null,
            script_editor: null,
            style_editor: null,
            save_delay: 1000,
            save_interval: null
        }
    },
    ready () {
        this.iframeHeight = window.innerHeight - this.headerHeight - this.footerHeight - this.sourceHeight
    },
    methods: {

        loadSnippet () {
            this.$els.iframe.src = "server/view.php?alias="+this.alias
            this.$http({
                url: 'server/snippets.php?type=get&id='+this.alias,
                method: 'GET'
            }).then((response) => {
                this.html = response.data.html
                this.script = response.data.script
                this.style = response.data.style
                setTimeout(() => {
                    this.applyEditor()
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
            this.$els.iframe.style.pointerEvents = "none"
        },

        onDrag (e) {
            if(e.clientY > this.headerHeight && e.clientY < window.innerHeight + this.footerHeight) {
                this.sourceHeight = ((this.startY + this.startHeight) - e.clientY)
                this.iframeHeight = window.innerHeight - this.headerHeight - this.footerHeight - this.sourceHeight
                this.html_editor.resize()
                this.style_editor.resize()
                this.script_editor.resize()
            }
        },

        stopDrag () {
            document.removeEventListener('mousemove', this.onDrag)
            document.removeEventListener('mouseup', this.stopDrag)
            let $body = document.getElementsByTagName('body')[0]
            $body.classList.remove('noselect')
            this.$els.iframe.style.pointerEvents = "auto";
        },

        applyEditor () {
            let theme = "ace/theme/terminal"
            let options = {
                highlightActiveLine: false,
                showPrintMargin: false,
                displayIndentGuides: true,
                useSoftTabs: true,
                useWorker: false
            }

            this.html_editor = ace.edit(this.$els.html)
            this.html_editor.session.setMode("ace/mode/html")
            this.html_editor.setAutoScrollEditorIntoView(true);
            this.html_editor.setTheme(theme)
            this.html_editor.setOptions(options)
            this.html_editor.on('change', this.save)

            this.style_editor = ace.edit(this.$els.style)
            this.style_editor.session.setMode("ace/mode/css")
            this.style_editor.setTheme(theme)
            this.style_editor.setOptions(options)
            this.style_editor.on('change', this.save)

            this.script_editor = ace.edit(this.$els.script)
            this.script_editor.session.setMode("ace/mode/javascript")
            this.script_editor.setTheme(theme)
            this.script_editor.setOptions(options)
            this.script_editor.on('change', this.save)
        },


        save () {
            clearInterval(this.save_interval)
            this.save_interval = setInterval(() => {
                let html = this.html_editor.getValue()
                let script = this.script_editor.getValue()
                let style = this.style_editor.getValue()

                this.$http({
                    url: 'server/snippets.php?action=update&id='+this.alias,
                    method: 'POST'
                }).then((response) => {
                    this.$els.iframe.src = "server/view.php?alias="+this.alias
                })

                clearInterval(this.save_interval)
            }, this.save_delay)
        }

    }
}
</script>

<style lang="scss">
    @import '../sass/vars';

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
            pre {
                height: calc(100% - 30px);
                position: relative;
                font-size: .9rem;
                @include bg-dark(0);
                background: transparent;
                margin: 0;
                font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
                .ace_gutter {
                    @include text-light(.3);
                    @include bg-dark(.1);
                }
                .ace_gutter-active-line {
                    @include bg-dark(.1);
                }
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
