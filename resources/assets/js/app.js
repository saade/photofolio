import Vue from 'vue';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'

require('popper.js');
require('bootstrap');

window.GLightbox = require('glightbox');
window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/* Portifolio */
Vue.component('portifolio-list', require('./components/portifolio/portifolio-list.vue').default)
Vue.component('portifolio-create', require('./components/portifolio/portifolio-create.vue').default)
Vue.component('portifolio-edit', require('./components/portifolio/portifolio-edit.vue').default)
Vue.component('portifolio-upload', require('./components/portifolio/portifolio-upload.vue').default)

/* Portifolio Item */
Vue.component('portifolio-item--set-cover', require('./components/portifolio-item/portifolio-item--set-cover.vue').default)
Vue.component('portifolio-item--set-hidden', require('./components/portifolio-item/portifolio-item--set-hidden.vue').default)
Vue.component('portifolio-item--change-layout', require('./components/portifolio-item/portifolio-item--change-layout.vue').default)
Vue.component('portifolio-item--delete', require('./components/portifolio-item/portifolio-item--delete.vue').default)

/* Category */
Vue.component('category-create', require('./components/category/category-create.vue').default)
Vue.component('category-list', require('./components/category/category-list.vue').default)
Vue.component('category-edit', require('./components/category/category-edit.vue').default)

Vue.use(ElementUI, { locale });
new Vue({
    el: '#app'
});