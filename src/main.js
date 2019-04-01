import Vue from 'vue'
import Router from 'vue-router'
import App from './App'
import BootstrapVue from 'bootstrap-vue'
//import store from './store'
import router from './router'
import Axios from 'axios'

// axios
Vue.prototype.$http = Axios

Vue.use(Router)
Vue.use(BootstrapVue)
Vue.config.productionTip = false

var app = new Vue({
    router,
    el: '#app',
    components: {
        App: App
    },
    template: '<App />'
});
