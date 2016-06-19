<template>
    <div class="snippet__menu" :style="{height: height, width: width}">
        <ul>
            <li v-for="item in data"
                v-link="{ name: 'snippets', params: { alias: item.alias } }"
            >
                {{item.title}}
            </li>
        </ul>
        <div class="snippet__menu__gutter" :style="{height: height}">
            <i class="material-icons">menu</i>
        </div>
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
        data: {
            type: Array,
            default: null
        }
    }
}
</script>

<style lang="scss">

    @import '../../sass/vars';

    .snippet__menu {
        @include bg-dark(0.2);
        min-width: 200px;
        float: right;
        overflow: hidden;
        z-index: 0;
        &__gutter {
            @include bg-dark(.4);
            width: 30px;
            height: 300px;
            position: absolute;
            top: 0; right: 0; bottom: 0;
            text-align: center;
            i {
                cursor: pointer;
                font-size: 24px;
                transition: color 0.2s ease;
                @include text-light(0.5);
                &:hover {
                    @include text-light(1);
                }
            }
        }
        ul {
            margin: 0 25px 0 0;
            padding: 5px;
            list-style: none;
            li {
                line-height: 40px;
                padding-left: 20px;
                margin: 5px;
                @include bg-dark(.3);
                font-size: .8rem;
                @include text-light(.8);
                cursor: pointer;
                transition: all 0.3s ease;
                &:hover {
                    @include bg-dark(.5);
                }
            }
        }
    }
</style>
