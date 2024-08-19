
window.Vue = require('vue');


import StarRating from 'vue-star-rating'
Vue.component('star-rating', StarRating);


import draggable from 'vuedraggable'
Vue.component('draggable', draggable)


import { BSpinner } from 'bootstrap-vue'
Vue.component('BSpinner', BSpinner)

Vue.component('pagination', require('laravel-vue-pagination'));

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
