<template>
    <div class="container">

        <div v-if="articleCreated" class="alert alert-success" role="alert">
            Articulo creado exitosamente!
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <transition name="router-anim" enter-active-class="animated fadeInLeftBig" leave-active-class="animated fadeOutRightBig">
                            <router-view></router-view>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "HomeComponent",
    data() {
      return {
        articleCreated: false
      }
    },
    created() {
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
