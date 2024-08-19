/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Lang from 'lang.js';


// Vue.use(Lang)
// const default_locale = window.default_language;
// const fallback_locale = window.fallback_locale;
const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;
const messages = window.messages;

var lang = new Lang();


// lang.setMessages(messages);
// lang.setFallback('ar');
// lang.setLocale('ar');
// Vue.prototype.trans = new Lang( { messages, locale: default_locale , fallback: fallback_locale } );
// console.log(default_locale , fallback_locale , messages , lang)


// window.default_locale
Vue.prototype.trans = new Lang( { messages: window.languages, locale: default_locale, fallback: 'en' } );

// And Above Chunk 👍 
Lang.prototype._getMessage = function(key, locale) {

    locale = locale || this.getLocale();

    if (this.messages[locale] === undefined) {
        locale = this.getFallback();
    }

    if (this.messages[locale][key] === undefined) {
        locale = this.getFallback();
    }

    if (this.messages[locale][key] === undefined) {
        return null;
    }

   // Added this one - if key value doesn't found, return to fallback
   // To handle this case: {"Hello: ""}
   if (!this.messages[locale][key]) {
        locale = this.getFallback();
    }

    return this.messages[locale][key];
}

// Vue.prototype.trans = new Lang( { messages, locale: default_locale, fallback: fallback_locale } );
// var lang = new Lang({
//   messages: source,
//   locale: 'fr',
//   fallback: 'zn'
// });

// console.log(lang.getLocale())


import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
window.toastr = require('toastr')
Vue.use(VueToastr2)

import moment from 'moment';



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
  


import vSelect from 'vue-select'

Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';



import { BSpinner , BSkeletonWrapper , BSkeleton , BCard , BSkeletonImg , BOverlay , BProgress} from 'bootstrap-vue'
Vue.component('BSpinner', BSpinner)
Vue.component('BSkeleton', BSkeleton)
Vue.component('BCard', BCard)
Vue.component('BSkeletonWrapper', BSkeletonWrapper)
Vue.component('BSkeletonImg', BSkeletonImg)
Vue.component('b-overlay', BOverlay)
Vue.component('b-progress', BProgress)



// moment.updateLocale('ar');

Vue.filter('formatedDateWithDay', function (date) {
  return moment(date).locale(store.getters.getCurrentLocale).format("Do MMM YYYY")
  // return moment(date).format("Do MMM YYYY")
})
Vue.filter('formatDifferenceDate', function (date) {
  return moment(date).locale(store.getters.getCurrentLocale).fromNow();
})

Vue.filter('diffInHours', function (date) {

  var timeStore = moment(date);
  var currentTime = moment();

  console.log(timeStore,currentTime)
  return currentTime.diff(timeStore, 'h');

})

Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    { path: '/', component: require('./main/home.vue').default },
    
    { path: '/view/:listing_id/listing', component: require('./main/view-ad.vue').default },

    { path: '/category/:category_id/listings/:make_id?/:model_id?' , name: "ads-listings"  , props: true , component: require('./main/category-ads.vue').default },
    
    { path: '/categories/:block_id/listings' , props: true , component: require('./main/category-ads.vue').default },
    
    { path: '/search-listings/:genre' , name: 'search-listings' , props: true , component: require('./main/category-ads.vue').default },
    
    // { path: '/category/:category_id/listings' , name: "ads-listings"  , props: true , component: require('./main/category-ads.vue').default },

    { path: '/category-ads', component: require('./main/category-ads.vue').default },
    { path: '/view-ad', component: require('./main/view-ad.vue').default },
    { path: '/profile-menu', component: require('./main/user/profile-menu.vue').default },
    { path: '/more', component: require('./main/user/more.vue').default },
    { path: '/profile', component: require('./main/user/profile-new.vue').default },


    { path: '/seller/home',  name: 'seller-home', component: require('./main/user/dashboard/home.vue').default },
    { path: '/seller/post-listing',  name: 'seller-post-listing', component: require('./main/user/dashboard/listing-form.vue').default },
    { path: '/seller/edit-listing/:listing_id',  name: 'seller-edit-listing', component: require('./main/user/dashboard/listing-form.vue').default },
    { path: '/seller/my-listings',  name: 'seller-my-listings', component: require('./main/user/dashboard/my-listings.vue').default },
    { path: '/seller/profile',  name: 'seller-my-listings', component: require('./main/user/dashboard/profile.vue').default },
    
    // { path: '/user-login', name: 'login' , component: require('./main/user/user-auth.vue').default },
    { path: '/user-login', name: 'login' , component: require('./main/user/user-login.vue').default },
    { path: '/seller-login', name: 'login' , component: require('./main/user/seller-login.vue').default },
    
    
    { path: '/terms-and-condition', component: require('./main/terms-and-condition.vue').default },
    { path: '/contact-us', component: require('./main/contact-us.vue').default },
    { path: '*', component: require('./main/404.vue').default },
  ]

const router = new VueRouter({
    mode: 'history',
    routes,
    // linkActiveClass: "_active",
})

const dashboard_routes = [
  'seller-home',
  'seller-post-listing',
  'seller-edit-listing',
  'seller-my-listings',
]


// router.beforeEach((to, from, next) => {
  
//   // store.commit('setPrevRoute' , from);

//   if( dashboard_routes.includes(to.name) && (!store.getters.isAuthenticated || store.getters.isAuthenticated && store.getters.isAuthenticated.type != 'seller') ){
//     // store.commit('logout')
//     next('/');
    
//   }else if( to.name == 'login' && store.getters.isAuthenticated ){
//     next('/profile-menu');
//   }else{
//     next();
//   }
// })


import Swal from 'sweetalert2'
window.Swal = Swal;
// import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  // timerProgressBar: true,
  // didOpen: (toast) => {
  //   toast.addEventListener('mouseenter', Swal.stopTimer)
  //   toast.addEventListener('mouseleave', Swal.resumeTimer)
  // }
})
window.Toast = Toast;


import VueQuillEditor from 'vue-quill-editor'
 
// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
 
// Vue.use(VueQuillEditor, /* { default global options } */)

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    [{ 'align': [] }],
  ];

Vue.use(VueQuillEditor,   { 
  modules: {
    toolbar: toolbarOptions
  }    
})



import StarRating from 'vue-star-rating'
Vue.component('star-rating', StarRating);


  
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('item-card', require('./main/partials/itemCard.vue').default);
Vue.component('wrapper', require('./wrapper.vue').default);
Vue.component('left-panel', require('./main/user/dashboard/partials/left-panel.vue').default);
Vue.component('loader', require('./main/partials/loader.vue').default);
Vue.component('bottom-nav', require('./main/partials/bottom-nav.vue').default);
Vue.component('listing-filters', require('./main/partials/filters').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store,
    data:{
      prevRoute : "",
    },
    el: '#app',
    methods:{
      numberWithCommas(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // return price.toString().replace(/\B(?=(\d{2})+(?!\d))/g, ",");
    },
    },
    watch:{
        $route (to, from){
            // console.log(to, from)
            window.scrollTo(0, 0)      
        },
    },

});
