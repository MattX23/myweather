require('./bootstrap');

window.Vue = require('vue');

Vue.component('city-search', require('./components/CitySearchComponent.vue').default);
Vue.component('home', require('./components/HomeComponent.vue').default);
Vue.component('location-modal', require('./components/LocationModalComponent.vue').default);
Vue.component('my-weather', require('./components/MyWeatherComponent.vue').default);
Vue.component('signup-modal', require('./components/SignupModalComponent.vue').default);

const app = new Vue({
    el: '#app',
});
