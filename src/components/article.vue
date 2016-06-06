<template>
    <div class="article">
        <iframe :style="{height: iframeHeight}" v-el:iframe></iframe>
        <app-source :height.sync="sourceHeight" :data="data"></app-source>
    </div>
</template>
<script>
import AppSource from './source.vue'
export default {
    components: {
        AppSource
    },
    route: {
        data () {
            this.id = this.$route.params.id
        }
    },
    watch: {
        id (val) {
            console.log('set id')
            this.$els.iframe.src = "api/view.php?alias="+val
        },
        sourceHeight (val) {
            //this.iframeHeight = window.innerHeight - headerHeight - footerHeight - val
        }
    },
    data() {
        return {
            id: null,
            iframeHeight: 300,
            sourceHeight: 200,
            headerHeight: 50,
            footerHeight: 50
        }
    }
}
</script>

<style lang="scss">
    .article {
        position: relative;
        width: 100%;
        height:400px;
        iframe {
            display: block;
            position: absolute;
            z-index: 1;
            top: 0; right: 0; bottom: 0; left: 0;
            width: 100%;
            height: 100%;
            border: none;
            background: #FFF;
        }
    }
</style>
