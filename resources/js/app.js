/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import Vue from 'vue'
import 'es6-promise/auto'
import axios from 'axios'

import "../../public/theme/one/index.css";
import ElementUI from 'element-ui';


import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import VueAuth from '@websanova/vue-auth'
import ElementLocale from 'element-ui/lib/locale'
import VueChatScroll from 'vue-chat-scroll'
import VueCountdown from "@chenfengyuan/vue-countdown";
import Vuelidate from 'vuelidate'
import VueClipboard from 'vue-clipboard2'


import auth from './auth';
import router from './router';
import store  from './store'
import i18n from "./i18n";
import EasyRefresh from 'vue-easyrefresh'
import Tawk from './utils/tawk'

Vue.use(ElementUI);
Vue.use(VueChatScroll)
Vue.use(EasyRefresh)
Vue.use(Vuelidate)
Vue.use(Tawk, {
    tawkSrc: "https://embed.tawk.to/68f11e5ef76abd195137795c/",
  });



VueClipboard.config.autoSetContainer = true 
Vue.use(VueClipboard)

// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
Vue.use(VueAxios, axios)
Vue.use(VueAuth, auth)


ElementLocale.i18n((key, value) => i18n.t(key, value))


import App from './pages/App'

Vue.component(VueCountdown.name, VueCountdown);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('app-footer', require('./components/AppFooter.vue').default);
Vue.component('app-header', require('./components/AppHeader.vue').default);
Vue.component('play-header', require('./components/PlayHeader.vue').default);

Vue.component('chat-item', require('./components/ChatItem.vue').default);
Vue.component('bet-input', require('./components/BetInput.vue').default);
Vue.component('vuelidate-input-error', require('./components/VuelidateInputError.vue').default);

Vue.component('language-switcher', require('./components/LanguageSwitcher.vue').default);



const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store: store,  
    i18n
});
