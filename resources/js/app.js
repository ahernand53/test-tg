/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap')
window.Vue = require('vue')
window.$ = require('jquery')

// Dependencies
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {ClientTable, Event} from 'vue-tables-2'
import uuid from '@estudioliver/vue-uuid-v4'

Vue.use(ClientTable)
Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(uuid)

// Components
import ArticleListComponent from './components/articles/ListComponent.vue'
import ArticleCreateComponent from "./components/articles/CreateComponent.vue";

import CategoryListComponent from './components/categories/ListComponent.vue'
import CategoryCreateComponent from './components/categories/CreateComponent.vue'
import ReportComponent from './components/articles/ReportComponent.vue'

import HomeComponent from "./components/HomeComponent";


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'home',
            path: '/inicio',
            component: ArticleListComponent
        },
        {
            name: 'article.create',
            path: '/inicio/nuevo-articulo',
            component: ArticleCreateComponent
        },
        {
            name: 'articles.report',
            path: 'articulos/generar-reporte',
            component: ReportComponent
        },
        {
            name: 'category.index',
            path: '/inicio/categorias',
            component: CategoryListComponent
        },
        {
            name: 'category.create',
            path: '/inicio/nueva-categoria',
            component: CategoryCreateComponent
        }
    ]
})

Vue.component(
    'home-component',
    require('./components/HomeComponent.vue')
)

const app = new Vue({
    el: '#app',
    router,
    components: {
        HomeComponent
    }
})
