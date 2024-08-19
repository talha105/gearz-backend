<template>


<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create makes'" class="btn btn-primary btn-sm float-end" @click="showMakeModal"> <i class="fas fa-plus"></i> Create</button>
                    <h5 class="card-title"> Makes </h5>
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
                            <th>Image</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(make , index) in makes" :key="index">
                            <td> {{index + 1}} </td>
                            <td>

                                <router-link :to="'/admin/make/' + make.id + '/models'"  > {{make.title }} </router-link>
                                </td>
                            <td> {{make.ar_title }} </td>
                            <td>
                                <img v-if="make.image" :src="'/storage/makes/' + make.image" class="category-image" />
                                <img v-else src="/img/no-image-found.jpg" class="category-image" />
                            </td>
                            <td> {{ make.create_date }} </td>
                            <td>

                                <a v-permission="'edit makes'" href="javascript:;"  @click="editMake(make)" > <i class="fas fa-edit"></i> </a>
                                <a v-permission="'delete makes'" href="javascript:;" class="text-danger" @click="deleteMake(make)"  :disabled="deleting == make" >
                                    <b-spinner small v-if="deleting == make"></b-spinner>
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
  id="makeModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="makeModal">Add Make</h5>
        <h5 class="modal-title" v-if="editMode" id="makeModal">Edit Make</h5>

        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postMake" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="make.title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Arabic Title" class="form-control" v-model="make.ar_title" name="name" required>
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

        <button v-if="!editMode" @click="postMake" :disabled="loading || !make.title" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateMake" :disabled="loading || !make.title" type="button" class="btn btn-primary">
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
            makes: [],
            make:{
                title: "",
                ar_title: "",
                image: "",
            }
        }
    },
    mounted(){
        this.getMakes();
    },
    methods:{

        getMakes(){
            this.loading_data = true
            axios.post('/api/makes')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.makes = res.data.makes;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        showMakeModal(){
            this.resetForm();
            this.editMode=  false;
            $('#makeModal').modal('show')
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
        postMake()
        {
            if(this.make.title){

            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.make.title)
            fd.append('ar_title', this.make.ar_title)

            axios.post('/api/make/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getMakes();
                this.resetForm();
                $('#makeModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateMake()
        {
            if(this.make.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.make.title)
            fd.append('ar_title', this.make.ar_title)

            axios.post('/api/make/'+ this.make.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getMakes();
                this.resetForm();
                $('#makeModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editMake(make){
            console.log(make)
            this.resetForm();
            this.editMode=  true;
            this.make.id = make.id;
            this.make.title = make.title;
            this.make.ar_title = make.ar_title;
            if(make.image){
                this.newImageSrc = '/storage/makes/' + make.image
            }
            $('#makeModal').modal('show')

        },
        deleteMake(make){

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

                    this.deleting = make;
                    axios.post('/api/make/ ' + make.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.deleting = ''
                        this.getMakes();
                    }).catch( err => {

                        this.deleting = ''
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.make.title = ''
            this.make.ar_title = ''
            this.make.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>
