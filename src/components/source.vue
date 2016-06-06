<template>
    <div class="app source" :style="{'height': height+'px'}">
        <div class="source__drag" @mousedown="startDrag"></div>
        <div class="grid">
            <div class="col s4 m4 l4">
                <div class="source__window source__window--html" v-text="html">
                </div>
            </div>
            <div class="col s4 m4 l4">
                <div class="source__window source__window--style" v-text="style">
                </div>
            </div>
            <div class="col s4 m4 l4">
                <div class="source__window source__window--script" v-text="script">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        height: {
            type: Number,
            default: 300
        },
        html: {
            type: String,
            default: 'asdfasd asdfasfas fasdf asdasfd f'
        },
        style:{
            type: String,
            default: 'asfdas asdfa sdfasd asdf  asdfd'
        },
        script: {
            type: String,
            default: 'asdfadsf'
        }
    },

    ready () {


    },

    methods: {
        startDrag (e) {
            console.log('start drag')
            document.addEventListener('mousemove', this.onDrag)
            document.addEventListener('mouseup', this.stopDrag)
            this.startY = e.clientY
            this.startHeight = this.height
        },

        onDrag (e) {
            console.log(e.clientY)
            if(e.clientY > 50 && e.clientY < window.innerHeight + 50) {
                this.height = ((this.startY + this.startHeight) - e.clientY)
            }
        },

        stopDrag () {
            console.log('stop drag')
            document.removeEventListener('mousemove', this.onDrag)
            document.removeEventListener('mouseup', this.stopDrag)
        }
    },

    data() {
        return {
            startY: null,
            startHeight: null
        }
    }
}
</script>

<style lang="scss">

.source {
    background: rgba(0,0,0,.1);
    height: 350px;
    position: fixed;
    bottom: 40px;
    left: 0; right: 0;
    width: 100%;
    &__drag {
        background: rgba(0,0,0,.7);
        height: 10px;
        margin-bottom: 10px;
    }
    &__window {
        margin-right: 10px;
        background: rgba(0,0,0,.5);
        width: 100%;
        min-height: 300px;
    }
}

</style>
