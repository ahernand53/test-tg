<template>

    <div class="m-2">
        <v-client-table class="shadow" :data="data" :columns="columns" :options="options">
            <button slot="options" slot-scope="props" class="btn btn-warning btn-sm mx-auto btn-block" data-toggle="modal" data-target="#edit" @click="modalEdit(props.row)">📝</button>

            <router-link slot="beforeFilter" class="btn btn-primary m-1 btn-block" :to="{name: 'article.create'}">Nuevo Articulo</router-link>
        </v-client-table>

        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar Articulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="register_number">Numero de registro</label>
                            <input disabled type="text" class="form-control shadow border-0" id="register_number" v-model="articleToUpdate.register_number">
                        </div>

                        <div class="form-group">
                            <label for="name">Nombre del articulo</label>
                            <input required type="text" class="form-control shadow border-0" id="name" v-model="articleToUpdate.name">
                            <label v-if="errors.name.has" class="text-danger">
                                {{ errors.name.message }}
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Cantidad</label>
                            <input required type="number" class="form-control shadow border-0" id="quantity" v-model="articleToUpdate.quantity">
                            <label v-if="errors.quantity.has" class="text-danger">
                                {{ errors.quantity.message }}
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="category">Categoria</label>
                            <select class="form-control shadow border-0" required name="category" id="category" v-model="articleToUpdate.category_id">
                                <option v-for="(value, key) in categories" :value="value.id" :key="key">{{ value.name }}</option>
                            </select>
                            <label v-if="errors.category.has" class="text-danger">
                                {{ errors.category.message }}
                            </label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-block"  @click="updateArticle(articleToUpdate, articleToUpdate.id)">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
  export default {
    data() {
      return {
        errors: {
          name: { message: '', has: false},
          quantity: { message: '', has: false},
          category: { message: '', has: false},
        },
        onEdit: false,
        articleToUpdate: {
          id: '',
          register_number: '',
          name: '',
          quantity: '',
          category_id: '',
        },
        categories: this.getCategories(),
        data: [],
        name: "ListComponent",
        columns: [
            'register_number',
            'name',
            'quantity',
            'category.name',
            'options'
        ],
        options: {
          headings: {
            register_number:    'Numero de registro',
            name:               'Nombre',
            quantity:           'Cantidad',
            'category.name':    'Categoria',
            options:            'opciones'
          },
          sortable: ['name', 'register_number', 'quantity'],
          filterable: ['register_number', 'name', 'category.name']
        }
      }
    },
    mounted() {
        this.getArticles()
    },
    methods: {
      getArticles() {
        axios.get('/api/articles')
            .then(response => this.data = response.data.data)
      },
      getCategories() {
        return axios.get('/api/categories')
            .then(response => this.categories = response.data.data)
      },
      modalEdit(data) {
        this.articleToUpdate = data
      },
      updateArticle(article, id) {
        this.errors.quantity.has = false
        this.errors.name.has = false
        this.errors.category.has = false
        let _this = this
        axios({
          method: 'put',
          url: `/api/categories/${article.category_id}/articles/${article.id}`,
          data: {
            name: article.name,
            quantity: article.quantity,
          }
        })
            .then(response => {
                $('#edit').modal('hide')
                this.getArticles();
            })
            .catch(error => {
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
