
require('./bootstrap');

window.Vue = require('vue');
window.axios=require('axios');



Vue.component('home-slider-component', require('./components/client/HomeSliderComponent.vue').default);
Vue.component('home-slider-article-component', require('./components/client/HomeSliderArticleComponent.vue').default);
Vue.component('article-component', require('./components/client/ArticleComponent.vue').default);
Vue.component('store-component', require('./components/client/StoreComponent.vue').default);




Vue.component('error', require('./components/custom/error.vue').default);






const app = new Vue({
    el: '#front',
});





/* npms

npm install verte --save


*/