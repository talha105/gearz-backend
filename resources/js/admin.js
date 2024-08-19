/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex'
Vue.use(Vuex)
// used for vuex
import 'es6-promise/auto'
import createPersistedState from "vuex-persistedstate";
import persistantDate from './store.js'
import Cookies from "js-cookie";


const store = new Vuex.Store({
    modules: {
      persistantDate,
    //   otherData,
    },
    plugins: [createPersistedState({
      paths: ['persistantDate'],
      // storage: window.sessionStorage,
      storage: {
        getItem: (key) => Cookies.get(key),
        setItem: (key, value) =>
          Cookies.set(key, value, { expires: 1, secure: false }),
        removeItem: (key) => Cookies.remove(key)
      }
    })],
  })





import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'

window.toastr = require('toastr')

Vue.use(VueToastr2)




import vSelect from 'vue-select'

Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

// Adding all local components
import './admin/components.js';
import './admin/imports.js';


import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css';

// register globally
Vue.component('multiselect', Multiselect)

import { router } from './adminRoutes.js';

Vue.directive('permission', {

    inserted(el, binding, vnode, old) {
        if(binding.value && !store.getters.hasPermission(binding.value)) {
            console.log('vnode.elm', vnode.elm)
            vnode.elm.parentElement.removeChild(vnode.elm)
        }
    }
})



router.beforeEach( (to, from, next) => {
    if(to.meta && to.meta.permission) {
        if(store.getters.hasPermission(to.meta.permission)) {
            return next()
        }else{
            router.push('/admin/dashboard')
            toastr.error('Authorization Failed!')
        }
    }
    return next()
} )


const admin = new Vue({
    router,
    store,
    el: '#admin',
    computed:{
        yearList() {
            let date = new Date();
            let year = date.getFullYear();
            let years = [];
            for (let i = year - 32; i <= year + 1; i++) {
                years.push(i);
            }
            return years;
        },
    },
    watch:{
        $route (to, from){
            // console.log(to, from)
            window.scrollTo(0, 0)
        },
    },

});
