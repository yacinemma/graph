/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'
import vSelect from 'vue-select'
import { library } from '@fortawesome/fontawesome-svg-core'
import { 
    faTrashAlt, faEye, faEdit,faPlus,
} from '@fortawesome/free-solid-svg-icons';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Home from './components/Graphs.vue';
import Graph from './components/Graph.vue';
import Statistic from './components/Statistic.vue';

library.add(faTrashAlt, faEye, faEdit,faPlus);

Vue.use(VueRouter);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('graphs', require('./components/Graphs.vue').default);
Vue.component('app', require('./components/App.vue').default);
Vue.component('v-select', vSelect)

// Const 
export const router = new VueRouter({
	mode: 'hash',
	routes: [
		{
			path: '/',
			component: Home,
		},
		{
			path: '/graph/:id',
			prop: true,
			name: 'show-graph',
			component: Graph,
			
		},
		{
			path: '/graph/:id/statistics',
			prop: true,
			name: 'statistic-graph',
			component: Statistic,
			
		},
	],
});


const app = new Vue({
  router,
  el: '#app'
});
