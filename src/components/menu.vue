<template>
    <div class="menu">
        <ul>
            <li v-for="item in data"><a v-link="{ name: 'snippets', params: { alias: item.alias } }">{{item.title}}</a></li>
        </ul>
    </div>
</template>
<script>
export default {
    props: {
        data: {
            type: Array,
            required: true
        },
        view:{
            type: String,
            required: true
        }
    }
}
</script>
<style lang="scss">

.menu {
    background: rgba(0,0,0,.5);
    width: 280px;
    font-size: .9rem;
    position: fixed;
    right: 0; top: 50px;
    height: 400px;
    z-index: 999;
    ul {
        list-style: none;
        margin: 0;
        padding: 0;
        li {
            padding: 10px;
            font-size: .9rem;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }
    }
}

</style>
