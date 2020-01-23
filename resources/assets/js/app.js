
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('data-maintenance', require('./components/trina/DataMaintenance.vue'));
Vue.component('portal-maintenance', require('./components/portal/DataMaintenance.vue'));
Vue.component('lot-record', require('./components/portal/LotRecord.vue'));
Vue.component('cab-record', require('./components/portal/CabinetInfo.vue'));
Vue.component('bom-maintenance', require('./components/portal/ProductType/BOM.vue'));
Vue.component('material-issuance', require('./components/portal/MaterialIssuance.vue'));
Vue.component('lot-assign', require('./components/portal/LotAssign.vue'));
Vue.component('stringer', require('./components/portal/Stringer.vue'));
Vue.component('missing-serials', require('./components/trina/MissingSerials.vue'));
Vue.component('mes', require('./components/portal/MES.vue'));

const app = new Vue({
    el: '#app'
});
