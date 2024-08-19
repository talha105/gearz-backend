<template>


<div class="categories">

      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create genre'" class="btn btn-primary btn-sm float-end" @click="showGenreModal">
                        <i class="fas fa-plus"></i>
                        Create
                    </button>
                    <h5 class="card-title">Manage Genres</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative table-wrapper">
                    <loader v-if="loading_data" :small="false"></loader>
                    <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Arabic Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th style="width: 115px">Create Date</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                        <tbody>

                            <tr v-for="(genre , index) in genres" :key="index">
                                <td> {{index + 1}} </td>
                                <td> {{genre.title}} </td>
                                <td> {{genre.ar_title }} </td>
                                <td> {{genre.description }} </td>
                                <td>
                                    <img v-if="genre.image" :src="'/storage/genres/' + genre.image" class="category-image" />
                                    <img v-else src="/img/no-image-found.jpg" class="category-image" />
                                </td>
                                <td> {{ genre.create_date }} </td>
                                <td>

                                    <a v-permission="'edit genre'" href="javascript:;"  @click="editGenre(genre)" > <i class="fas fa-edit"></i> </a>
                                    <a v-permission="'delete genre'" href="javascript:;" class="text-danger" @click="deleteGenre(genre)"  :disabled="deleting == genre" >
                                        <b-spinner small v-if="deleting == genre"></b-spinner>
                                        <i v-else  class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>







<div
  class="modal fade"
  id="genreModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="genreModal">Add Genre</h5>
        <h5 class="modal-title" v-if="editMode" id="genreModal">Edit Genre</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postGenre" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="genre.title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="ar_title" placeholder="Aracic Title" class="form-control" v-model="genre.ar_title" name="name" required>
                </div>
            </div>

          <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="description" class="row float-right col-form-label ">Description:</label>
                    </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea rows="5" class="form-control" id="description" v-model="genre.description" placeholder="Description of genre"></textarea>
                </div>
          </div>

          <div class="form-group row">
                <div class="col-sm-12 col-md-2 col-lg-2">
                <label for="inputEmail1" class="row float-right col-form-label ">Image:</label>
            </div>
            <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog" class="upload-category-image" />
                <button class="btn btn-success btn-sm w-100 mt-2" type="button" @click="selectImageDialog" >Upload</button>
                <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
            </div>

          </div>

        </form>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button> -->

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postGenre" :disabled="loading || !genre.title" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateGenre" :disabled="loading || !genre.title" type="button" class="btn btn-primary">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-edit"></i>
        Update </button>

      </div>
    </div>
  </div>
</div>



</div>
</template>

<script>
import button from '../partials/button.vue'
export default {
  components: { button },
    data(){
        return{
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            genres: [],
            genre:{
                title: "",
                ar_title: "",
                description: "",
                image: "",
            }
        }
    },
    mounted(){
        this.getAllGenres();
    },
    methods:{

        getAllGenres(){
            this.loading_data = true
            axios.post('/api/genres/all')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.genres = res.data.genres;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },

        showGenreModal(){
            this.resetForm();
            this.editMode=  false;
            $('#genreModal').modal('show')
        },
        imageSelected(event){
            let file = event.target.files[0]
            if(!file) return;
            // console.log(file)
            this.new_image = file
            let src = URL.createObjectURL(file)
            this.newImageSrc = src
        },

        selectImageDialog(){
            $('#category_image').click()
        },
        postGenre()
        {
            if(this.genre.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.genre.title)
            fd.append('ar_title', this.genre.ar_title)
            fd.append('description', this.genre.description)

            axios.post('/api/genre/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getAllGenres();
                this.resetForm();
                $('#genreModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateGenre()
        {
            if(this.genre.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.genre.title)
            fd.append('ar_title', this.genre.ar_title)
            fd.append('description', this.genre.description)

            axios.post('/api/genre/'+ this.genre.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getAllGenres();
                this.resetForm();
                $('#genreModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editGenre(genre){
            this.resetForm();
            this.newImageSrc = ''
            this.editMode=  true;
            this.genre.id = genre.id;
            this.genre.title = genre.title;
            this.genre.ar_title = genre.ar_title;
            this.genre.description = genre.description && genre.description != 'null' ? genre.description : '';
            if(genre.image){
                this.newImageSrc = '/storage/genres/' + genre.image
            }
            $('#genreModal').modal('show')

        },
        deleteGenre(genre){

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    this.deleting = genre;
                    axios.post('/api/genre/ ' + genre.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllGenres();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.genre.title = ''
            this.genre.ar_title = ''
            this.genre.description = ''
            this.genre.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>

<style>

</style>
