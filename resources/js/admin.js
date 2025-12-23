/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import Vue from 'vue'
import 'es6-promise/auto'

import "../../public/theme/one/index.css";
import ElementUI from 'element-ui';


Vue.use(ElementUI);

// Set Vue globally
window.Vue = Vue


const app = new Vue({
    el: '#app',
});
