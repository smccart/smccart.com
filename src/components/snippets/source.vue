<template>
    <div class="snippet__source" :style="{height: height}">
        <div class="grid">
            <div class="col s4 m4">
                <div class="snippet__source__window html">
                    <header>HTML <span v-if="data.html.lang">({{data.html.lang}})</span>
                        <i class="material-icons" @click="toggleWrap('html')">wrap_text</i>
                    </header>
                    <pre v-el:html></pre>
                </div>
            </div>
            <div class="col s4 m4">
                <div class="snippet__source__window style">
                    <header>CSS <span v-if="data.style.lang">({{data.style.lang}})</span>
                        <i class="material-icons" @click="toggleWrap('style')">wrap_text</i>
                    </header>
                    <pre v-el:style></pre>
                </div>
            </div>
            <div class="col s4 m4">
                <div class="snippet__source__window script">
                    <header>JS <span v-if="data.script.lang">({{data.script.lang}})</span>
                        <i class="material-icons" @click="toggleWrap('script')">wrap_text</i>
                    </header>
                    <pre v-el:script></pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//var sass = require('node-sass');
import Jade from 'jade'

export default {
    props: {
        data: {
            type: Object,
            required: true
        },
        height: {
            type: String,
            default: 'auto'
        }
    },

    watch: {
        data () {
            this.updateEditors()
        },
        height () {
            this.editor.html.resize()
            this.editor.style.resize()
            this.editor.script.resize()
        }
    },

    ready () {
        this.initEditors()
    },

    data () {
        return {
            wrap: {
                html: false,
                style: false,
                script: false
            },
            editor: {
                html: null,
                style: null,
                script: null
            }
        }
    },

    methods: {
        initEditors () {
            let theme = "ace/theme/terminal"
            let options = {
                highlightActiveLine: false,
                showPrintMargin: false,
                displayIndentGuides: true,
                useSoftTabs: true,
                useWorker: false
            }

            this.editor.html = ace.edit(this.$els.html)
            this.editor.html.session.setMode("ace/mode/html")
            this.editor.html.setAutoScrollEditorIntoView(true);
            this.editor.html.setTheme(theme)
            this.editor.html.setOptions(options)
            this.editor.html.on('change', this.onChange)
            this.editor.html.$blockScrolling = Infinity

            this.editor.style = ace.edit(this.$els.style)
            this.editor.style.session.setMode("ace/mode/css")
            this.editor.style.setTheme(theme)
            this.editor.style.setOptions(options)
            this.editor.style.on('change', this.onChange)
            this.editor.style.$blockScrolling = Infinity

            this.editor.script = ace.edit(this.$els.script)
            this.editor.script.session.setMode("ace/mode/javascript")
            this.editor.script.setTheme(theme)
            this.editor.script.setOptions(options)
            this.editor.script.on('change', this.onChange)
            this.editor.script.$blockScrolling = Infinity
        },

        toggleWrap (type) {
            this.wrap[type] = !this.wrap[type]
            this.editor[type].getSession().setUseWrapMode(this.wrap[type])
        },

        updateEditors () {
            this.editor.html.setValue(this.data.html.raw)
            this.editor.html.clearSelection()
            this.editor.script.setValue(this.data.script.raw)
            this.editor.script.clearSelection()
            this.editor.style.setValue(this.data.style.raw)
            this.editor.style.clearSelection()
        },

        onChange () {
            let data = {
                html: this.editor.html.getValue(),
                script: this.editor.script.getValue(),
                style: this.editor.style.getValue(),
            }
            this.$emit('change', data)
        },

        compile () {
            let result = Jade.render('doctype html html(lang="en")')
            console.log(result)
        }
    }
}
</script>

<style lang="scss">
    
    @import '../../sass/vars';

    .snippet__source {
        @include bg-dark(.1);
        position: fixed;
        bottom: 40px; left: 0; right: 0;
        box-sizing: border-box;
        .grid {
            height: calc(100% - 10px);
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
            .ace_selection {
                background: rgba(255,255,255,0.1) !important;
            }
        }
        &__window {
            @include bg-dark(.5);
            width: 100%;
            height: 100%;
            border-radius: 0px;
            header {
                text-transform: uppercase;
                @include text-light(.8);
                font-size: 1rem;
                font-weight: 300;
                height: 30px;
                box-sizing: border-box;
                padding: 6px 10px 0 10px;
                @include bg-dark(.3);
                border-bottom: 1px solid;
                @include border-dark(.3);
                border-radius: 0px;
                span {
                    font-size: .75rem;
                    @include text-light(.5);
                }
                i {
                    float: right;
                    font-size: 20px;
                    @include text-light(.5);
                    cursor: pointer;
                    transition: color 0.2s ease;
                    &:hover {
                        @include text-light(1);
                    }
                }
            }
        }
    }

</style>