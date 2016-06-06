<template>
    <div class="article">
        <iframe v-el:iframe></iframe>
    </div>
</template>
<script>
export default {
    route: {
        activate () {
            console.log('activate')
        }
    },
    ready () {
        console.log('ready')
    },
    watch: {
        id (val) {
            this.$els.iframe.src = "api/view.php?alias="+val
        }
    },
    props: {
        id: {
            type: String,
            default: null
        }
    },
    data() {
        return {

        }
    }
}
</script>

<style lang="scss">
    .article {
        position: relative;
        width: 100%;
        iframe {
            display: block;
            top: 0; right: 0; bottom: 0; left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    }
</style>
