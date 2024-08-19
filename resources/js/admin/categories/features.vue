<template>


<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm float-end" @click="showFeatureModal"> <i class="fas fa-plus"></i> Create</button>
                    <button class="btn btn-outline-dark btn-sm float-end me-2" @click="$router.back()"> <i class="fas fa-arrow-left"></i> Back</button>
                    <h5 class="card-title"> {{category ? category.title : ''}} Features</h5>
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
                            <th style="width: 400px">Description</th>
                            <th>Image</th>
                            <th style="width: 115px">Create Date</th>
                            <th style="width: 100px">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(feature , index) in features" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{feature.title }} </td>
                            <td> {{feature.ar_title }} </td>
                            <td> {{feature.description }} </td>
                            <td>
                                <img v-if="feature.image" :src="'/storage/features/' + feature.image" class="category-image" />
                                <img v-else src="/img/no-image-found.jpg" class="category-image" />
                            </td>
                            <td> {{ feature.create_date }} </td>
                            <td>

                                <a href="javascript:;"  @click="editFeature(feature)" > <i class="fas fa-edit"></i> </a>
                                <a href="javascript:;" class="text-danger" @click="deleteFeature(feature)"  :disabled="deleting == feature" >
                                    <b-spinner small v-if="deleting == feature"></b-spinner>
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
  id="featureModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="featureModal">Add Feature</h5>
        <h5 class="modal-title" v-if="editMode" id="featureModal">Edit Feature</h5>

        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postFeature" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="feature.title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="ar_title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="ar_title" placeholder="Arabic Title" class="form-control" v-model="feature.ar_title" name="name" required>
                </div>
            </div>

          <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="description" class="row float-right col-form-label ">Description:</label>
                    </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea rows="5" class="form-control" id="description" v-model="feature.description" placeholder="Description of feature"></textarea>
                </div>
          </div>

          <div class="form-group row">
                <div class="col-sm-12 col-md-2 col-lg-2">
                <label for="inputEmail1" class="row float-right col-form-label ">Image:</label>
            </div>
            <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog" class="upload-category-image" />
                <button class="btn btn-success btn-sm w-100 mt-2" type="button" @click="selectImageDialog" >Upload</button>
                <input type="file" @change="imageSelected" ref="feature_image" id="feature_image" class="d-none" />
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button> -->

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postFeature" :disabled="loading || !feature.title" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateFeature" :disabled="loading || !feature.title" type="button" class="btn btn-primary">
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
    props:{
        // category:{

        // }
    },
    data(){
        return{
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            category: '',
            features: [],
            feature:{
                title: "",
                ar_title: "",
                description: "",
                image: "",
            }
        }
    },
    mounted(){
        // if(!this.category){
        //     this.$router.back();
        // }
        // console.log(this.$route.params.cat_id)
        this.getSubCategories();
    },
    methods:{

        getSubCategories(){
            this.loading_data = true
            axios.post('/api/category/' + this.$route.params.cat_id + '/features')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.category = res.data.category;
                this.features = res.data.features;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        showFeatureModal(){
            this.resetForm();
            this.editMode=  false;
            $('#featureModal').modal('show')
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
            $('#feature_image').click()
        },
        postFeature()
        {
            if(this.feature.title){

            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.feature.title)
            fd.append('ar_title', this.feature.ar_title)
            fd.append('category_id', this.category.id)
            fd.append('description', this.feature.description)

            axios.post('/api/feature/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getSubCategories();
                this.resetForm();
                $('#featureModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateFeature()
        {
            if(this.feature.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.feature.title)
            fd.append('ar_title', this.feature.ar_title)
            fd.append('description', this.feature.description)

            axios.post('/api/feature/'+ this.feature.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getSubCategories();
                this.resetForm();
                $('#featureModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editFeature(feature){
            // console.log(feature)
            this.resetForm();
            this.editMode=  true;
            this.feature.id = feature.id;
            this.feature.title = feature.title;
            this.feature.ar_title = feature.ar_title;
            this.feature.description = feature.description && feature.description != 'null' ? feature.description : '';
            if(feature.image){
                this.newImageSrc = '/storage/features/' + feature.image
            }
            $('#featureModal').modal('show')

        },
        deleteFeature(feature){

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

                    this.deleting = feature;
                    axios.post('/api/feature/ ' + feature.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.deleting = ''
                        this.getSubCategories();
                    }).catch( err => {

                        this.deleting = ''
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.feature.title = ''
            this.feature.ar_title = ''
            this.feature.description = ''
            this.feature.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>
