<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-2 mb-2">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Nuevo Articulo</h4>
                </div>

                <div class="card-content">

                    <div class="row justify-content-center">

                        <div class="col-8">

                            <div class="form-group">
                                <label for="name">Nombre del articulo</label>
                                <input required type="text" class="form-control" id="name" v-model="categoryToCreate.name">
                                <label v-if="errors.name.has" class="text-danger">
                                    {{ errors.name.message }}
                                </label>
                            </div>

                            <router-link :to="{ name: 'article.index'}" class="btn btn-danger">Cancelar</router-link>
                            <button class="btn btn-success" @click="saveCategory(categoryToCreate)">Crear</button>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "CreateComponent",
    data() {
      return {
        errors: {
          name: { message: '', has: false}
        },
        categoryToCreate: {
          name: ''
        },
      }
    },
    methods: {
      saveCategory(category) {
        this.errors.name.has = false
        let _this = this
        axios({
          method: 'post',
          url: `/api/categories`,
          data: {
            name: category.name
          }
        })
            .then(response => {
              this.$router.push({name: 'category.index'})
            })
            .catch(error => {
              if (error.response.data.error.name) {
                _this.errors.name.has = true
                _this.errors.name.message = error.response.data.error.name[0].replace('name', 'nombre')
              }
            })
      }
    }
  }
</script>

<style scoped>

</style>
