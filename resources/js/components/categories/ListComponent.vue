<template>

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <router-link :to="{ name: 'category.create'}" class="btn btn-primary m-2">➕Nueva Categoria</router-link>

            <table class="table">

                <thead>
                <tr>
                    <th>nombre</th>
                    <th>Fecha de creacion</th>
                    <th>botones</th>
                </tr>
                </thead>

                <tbody>
                    <tr v-for="category in categories" :key="category.id">
                        <td>{{ category.name }}</td>
                        <td>{{ category.created_at }}</td>
                        <td>
                            <button class="btn btn-warning" @click="editModal(category)">📝</button>
                        </td>
                    </tr>
                </tbody>

            </table>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Editar Categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name">Nombre de la categoria</label>
                                <input required type="text" class="form-control" id="name" v-model="categoryToUpdate.name">
                                <label v-if="errors.name.has" class="text-danger">
                                    {{ errors.name.message }}
                                </label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary"  @click="updateCategory(categoryToUpdate)">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
  export default {
    name: "ListComponent",
    data() {
      return {
        errors: {
          name: { message: '', has: false}
        },
        categoryToUpdate: {
          name: ''
        },
        categories: this.getCategories()
      }
    },
    methods: {
      editModal(category) {
        this.categoryToUpdate = category
        $('#edit').modal('show')
      },
      getCategories() {
        axios.get('/api/categories')
            .then(response => this.categories = response.data.data)
      },
      updateCategory(category) {
        this.errors.name.has = false
        let _this = this
        axios({
          method: 'put',
          url: `/api/categories/${category.id}`,
          data: {
            name: category.name
          }
        })
            .then(response => {
              $('#edit').modal('hide')
              this.getCategories()
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
