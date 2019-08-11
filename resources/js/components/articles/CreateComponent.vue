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
                                <label for="register_number">Numero de registro</label>
                                <input disabled type="text" class="form-control" id="register_number" v-model="register_number">
                                <button class="btn btn-primary btn-sm" @click="newRegisterNumber">Nuevo numero</button>
                            </div>

                            <div class="form-group">
                                <label for="name">Nombre del articulo</label>
                                <input required type="text" class="form-control" id="name" v-model="name">
                                <label v-if="errors.name.has" class="text-danger">
                                    {{ errors.name.message }}
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Cantidad</label>
                                <input required type="number" class="form-control" id="quantity" v-model="quantity">
                                <label v-if="errors.quantity.has" class="text-danger">
                                    {{ errors.quantity.message }}
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="category">Categoria</label>
                                <select required name="category" id="category" v-model="category">
                                    <option v-for="(value, key) in categories" :value="value.id" :key="key">{{ value.name }}</option>
                                </select>
                                <label v-if="errors.category.has" class="text-danger">
                                    {{ errors.category.message }}
                                </label>
                            </div>

                            <router-link :to="{ name: 'home'}" class="btn btn-danger">Cancelar</router-link>
                            <button class="btn btn-success" @click="saveArticle">Crear</button>

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
            name: { message: '', has: false },
            category: { message: '', has: false },
            quantity: { message: '', has: false }
        },
        register_number: this.$uuidKey(),
        name: null,
        quantity: null,
        category: null,
        categories: this.getCategories()
      }
    },
    methods: {
      getCategories() {
        return axios.get('/api/categories')
            .then(response => this.categories = response.data.data)
      },
      newRegisterNumber() {
         this.register_number = this.$uuidKey()
      },
      saveArticle() {
        this.errors.quantity.has = false
        this.errors.name.has = false
        this.errors.category.has = false
        let _this = this
        axios({
          method: 'post',
          url: `/api/categories/${this.category}/articles`,
          data: {
            register_number: this.register_number,
            name: this.name,
            quantity: this.quantity
          }
        })
            .then(response => {
              this.$router.push({name: 'home'})
              this.$root.$emit('article-created', response.data.data)
            })
            .catch(function (error) {
              if (error.response.data.code === 404) {
                _this.errors.category.has = true
                _this.errors.category.message = 'Seleccione una categoria'
              }

              if(error.response.data.error.name) {
                _this.errors.name.has = true
                _this.errors.name.message = error.response.data.error.name[0].replace('name', 'nombre')
              }

              if(error.response.data.error.quantity) {
                _this.errors.quantity.has = true
                _this.errors.quantity.message = error.response.data.error.quantity[0].replace('quantity', 'cantidad')
              }
            })
      }
    }
  }
</script>

<style scoped>

</style>
