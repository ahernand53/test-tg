<template>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <transition name="router-anim" enter-active-class="animated fadeInLeftBig" leave-active-class="animated fadeOutRightBig">
                    <router-view></router-view>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "HomeComponent",
    created() {
      this.$root.$on('category-created', function () {
        this.articleCreated = true
        let _this = this
        setTimeout(function () {
          _this.articleCreated = false
        }, 5000)
      })
      this.$root.$on('article-created', function () {
            this.articleCreated = true
            let _this = this
            setTimeout(function () {
              _this.articleCreated = false
            }, 5000)
      })
    }
  }
</script>

<style scoped>

</style>
