<template>
    <div class="footer">
        <span class="footer__copyright">&copy; Sean McCart 2016</span>
    </div>
</template>


<script>
export default {
  data () {
    return {
      // Note: modifying `msg` below will not cause changes to occur with
      // hot-reload. As reloaded components preserve their initial state,
      // modifying these values will have no effect.
      msg: 'Hello World!'
    }
  }
}
</script>

<style lang="scss">

    .footer {
        background: rgba(0,0,0,.3);
        position: fixed;
        bottom: 0; right: 0; left: 0;
        height: 40px;
        padding: 10px 20px 0 20px;
        box-sizing: border-box;

        &__copyright {
            font-size: .8rem;
        }

    }

</style>
