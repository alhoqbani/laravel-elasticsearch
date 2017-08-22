import './bootstrap';
import Vue from 'vue';

Vue.component('ElasticSearch', require('./components/ElasticSearch.vue'));

const app = new Vue({
    el: '#app'
});
