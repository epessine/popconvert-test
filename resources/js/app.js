require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('home', require('./components/Home.vue').default);
Vue.component('orders-create', require('./components/orders/Create.vue').default);
Vue.component('orders-index', require('./components/orders/Index.vue').default);

const app = new Vue({
    el: '#app',
});
