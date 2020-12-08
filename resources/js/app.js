
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);
import Vue from 'vue'

import Datetime from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
window.Vue.use(Datetime)
import { Settings } from 'luxon'
Settings.defaultLocale = 'ru'

/*import tinymce from 'vue-tinymce-editor'
window.Vue.component('tinymce', tinymce)*/

import NewsIndex from './components/news/NewsComponent';
import NewsCreate from './components/news/NewsCreate.vue';
import moment from 'moment';
/*import CompaniesEdit from './components/news/NewsEdit.vue';*/
NewsIndex
const routes = [
    {
        path: '/',
        components: {
            newsIndex: NewsIndex
        }
    },
    {path: '/home/news/create', component: NewsCreate, name: 'createNews'},
   /* {path: '/home/news/edit/:id', component: NewsEdit, name: 'editNews'},*/
]

const router = new VueRouter({ routes })
const app = new Vue({ router }).$mount('#app')
