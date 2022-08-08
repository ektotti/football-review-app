/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('TacticalBoard', require('./components/TacticalBoard.vue').default);
Vue.component('CreatePost', require('./components/CreatePost.vue').default);
Vue.component('FixtureCard', require('./components/FixtureCard.vue').default);
Vue.component('PostCard', require('./components/PostCard.vue').default);
Vue.component('PostImageCarousel', require('./components/PostImageCarousel.vue').default);
Vue.component('Profiel', require('./components/Profiel.vue').default);
Vue.component('Modal', require('./components/Modal.vue').default);
Vue.component('SearchPost', require('./components/SearchPost.vue').default);

Vue.filter('formatPlayerName',function(value){
    let nameSeparatedWithSpace = value.split('　');
    if([...nameSeparatedWithSpace[0]].length < 5 ){
        return nameSeparatedWithSpace[0];
    }else{
        return nameSeparatedWithSpace[0].substr(0, 4);
    }
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});