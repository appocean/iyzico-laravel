import Vue from 'vue'
import App from './App.vue'
import i18n from './i18n'
import VueSimpleAlert from "vue-simple-alert"
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueSimpleAlert);

Vue.config.productionTip = false

Vue.use(VueAxios, axios)


new Vue({
    i18n,
    render: h => h(App)
}).$mount('#app')
