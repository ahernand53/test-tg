<template>

    <div class="row shadow">

        <div class="container py-3">
            <div class="row justify-content-center">

                <div class="col-3">
                    <div class="form-group">
                        <label for="start_date">Fecha Inicial</label>
                        <input v-model="start_date" id="start_date" type="date" class="form-control border-0 shadow">
                        <label v-if="errors.start_date.has" class="text-danger">
                            {{ errors.start_date.message }}
                        </label>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="end_date">Fecha Final</label>
                        <input v-model="end_date" id="end_date" type="date" class="form-control border-0 shadow">
                        <label v-if="errors.end_date.has" class="text-danger">
                            {{ errors.end_date.message }}
                        </label>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center">
                <div class="col-4">

                    <button v-show="!generating" class="btn btn-primary btn-block" @click="getReport()" v-on:click="generating = true">Descargar Reporte</button>

                    <button disabled class="btn btn-primary btn-block" v-show="generating">
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>

                </div>
            </div>
        </div>

    </div>

</template>

<script>
  export default {
    name: "ReportComponent",
    data() {
      return {
        generating: false,
        errors: {
          start_date: { message: '', has: false},
          end_date: { message: '', has: false}
        },
        start_date: '',
        end_date: ''
      }
    },
    methods: {

      getReport() {
        this.generating = true
        let _this = this
        axios({
          method: 'post',
          url: '/api/reports/generate-pdf',
          data: {
            start_date: this.start_date,
            end_date: this.end_date
          },
          responseType: 'blob'
        })
            .then(response => {
              const url = window.URL.createObjectURL(new Blob([response.data]))
              const link = document.createElement('a')
              link.href = url
              link.setAttribute('download', 'reportes.pdf')
              document.body.appendChild(link)
              link.click()
              _this.generating = false
            })
            .catch(error => {
              this.errors.start_date.has = false
              this.errors.end_date.has = false
              if (error.response.data.error.start_date) {
                _this.errors.start_date.message = error.response.data.error.start_date[0].replace('start date', 'fecha inicial')
                _this.errors.start_date.has = true
              }

              if (error.response.data.error.end_date) {
                _this.errors.end_date.message = error.response.data.error.end_date[0].replace('end date', 'fecha final').replace('start date', 'fecha inicial')
                _this.errors.end_date.has = true
              }

            })
        this.generating = false
      }
    }
  }
</script>

<style scoped>

</style>
