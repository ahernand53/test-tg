<template>
    <div class="container">

        <div v-if="articleCreated" class="alert alert-success" role="alert">
            Articulo creado exitosamente!
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li class="m-2"><router-link :to="{ name: 'home'}">Articulos</router-link></li>
                            <li class="m-2"><router-link :to="{ name: 'category.index'}">Categorias</router-link></li>
                        </ol>
                    </div>

                    <div class="card-content">
                        <router-view></router-view>
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
