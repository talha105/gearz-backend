<template>


<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create makes'" class="btn btn-primary btn-sm float-end" @click="showModelModal"> <i class="fas fa-plus"></i> Create</button>
                    <button class="btn btn-outline-dark btn-sm float-end me-2" @click="$router.back()"> <i class="fas fa-arrow-left"></i> Back</button>
                    <h5 class="card-title"> {{make ? make.title : ''}} Models</h5>
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
                                <th>Genre</th>
                                <th style="width: 115px">Create Date</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(model , index) in models" :key="index">
                                <td> {{index + 1}} </td>
                                <td>
                                    <router-link :to="`/admin/model/${model.id}/variants`"> {{model.title }} </router-link>
                                </td>
                                <td> {{ model.ar_title }} </td>
                                <td> {{ model.genre && model.genre.title }} </td>
                                <td> {{ model.create_date }} </td>
                                <td>

                                    <a v-permission="'edit makes'" href="javascript:;"  @click="editModel(model)" > <i class="fas fa-edit"></i> </a>
                                    <a v-permission="'delete makes'" href="javascript:;" class="text-danger" @click="deleteModel(model)"  :disabled="deleting == model" >
                                        <b-spinner small v-if="deleting == model"></b-spinner>
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
  id="modelModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="modelModal">Add Model</h5>
        <h5 class="modal-title" v-if="editMode" id="modelModal">Edit Model</h5>

        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postModel" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="model.title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Arabic Title" class="form-control" v-model="model.ar_title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Select Genre:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <v-select
                        placeholder="Select Genre"
                        :options="genres"
                        :reduce="genre => genre.id"
                        label="title"
                        v-model="model.genre_id"
                        :clearable="false"
                    ></v-select>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postModel" :disabled="loading || !model.title || !model.genre_id" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateModel" :disabled="loading || !model.title || !model.genre_id" type="button" class="btn btn-primary">
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
export default {
    data(){
        return{
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            make: '',
            models: [],
            genres: [],
            model:{
                title: "",
                ar_title: "",
                genre_id: "",
                image: "",
            }
        }
    },
    mounted(){
        this.getModel();
        this.getCategories();
    },
    methods:{

        getModel(){
            this.loading_data = true
            axios.post('/api/make/' + this.$route.params.make_id + '/models' )
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.models = res.data.models;
                this.make = res.data.make;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        getCategories() {
            axios
            .post("/api/category/all-details")
            .then(res => {
                this.genres = res.data.genres;
            })
            .catch(err => {
                console.log(err);
            });
        },
        showModelModal(){
            this.resetForm();
            this.editMode=  false;
            $('#modelModal').modal('show')
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
        postModel()
        {
            if(this.model.title){

            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            // fd.append('image', file)
            fd.append('title', this.model.title)
            fd.append('ar_title', this.model.ar_title)
            fd.append('make_id', this.make.id)
            fd.append('genre_id', this.model.genre_id)

            axios.post('/api/model/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getModel();
                this.resetForm();
                $('#modelModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateModel()
        {
            if(this.model.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.model.title)
            fd.append('ar_title', this.model.ar_title)
            fd.append('genre_id', this.model.genre_id)

            axios.post('/api/model/'+ this.model.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getModel();
                this.resetForm();
                $('#modelModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editModel(model){
            // console.log(model)
            this.resetForm();
            this.editMode=  true;
            this.model.id = model.id;
            this.model.title = model.title;
            this.model.genre_id = model.genre_id;
            this.model.ar_title = model.ar_title;
            if(model.image){
                this.newImageSrc = '/storage/models/' + model.image
            }
            $('#modelModal').modal('show')

        },
        deleteModel(model){

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

                    this.deleting = model;
                    axios.post('/api/model/ ' + model.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.deleting = ''
                        this.getModel();
                    }).catch( err => {

                        this.deleting = ''
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.model.title = ''
            this.model.ar_title = ''
            this.model.genre_id = ''
            this.model.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>
