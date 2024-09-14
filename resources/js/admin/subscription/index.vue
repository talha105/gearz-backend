<template>


<div class="categories">

      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create transmission'" class="btn btn-primary btn-sm float-end" @click="showTransmissionModal">
                        <i class="fas fa-plus"></i>
                        Create
                    </button>
                    <h5 class="card-title">Manage Subscription</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative table-wrapper">
                    <loader v-if="loading_data" :small="false"></loader>
                    <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>price</th>
                                <th>duration</th>
                                <th>user</th>
                                <th>Create Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        <tbody>

                            <tr v-for="(transmission , index) in transmissions" :key="index">
                                <td> {{index + 1}} </td>
                                <td> {{transmission.title}} </td>
                                <td> {{transmission.price }} </td>
                                <td> {{transmission.duration }} </td>
                                <td> {{ "All" }} </td>
                                <td> {{ transmission.create_date }} </td>
                                <td>

                                    <a v-permission="'edit transmission'" href="javascript:;"  @click="editTransmission(transmission)" > <i class="fas fa-edit"></i> </a>
                                    <a v-permission="'delete transmission'" href="javascript:;" class="text-danger" @click="deleteTransmission(transmission)"  :disabled="deleting == transmission" >
                                        <b-spinner small v-if="deleting == transmission"></b-spinner>
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
  id="transmissionModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="transmissionModal">Add Subscription</h5>
        <h5 class="modal-title" v-if="editMode" id="transmissionModal">Edit Subscription</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postTransmission" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="transmission.title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Price:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="price" placeholder="Price" class="form-control" v-model="transmission.price" name="price" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Description:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="description" placeholder="Description" class="form-control" v-model="transmission.description" name="description" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Duration:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="duration" placeholder="Duration" class="form-control" v-model="transmission.duration" name="duration" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Users:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="user_id" placeholder="Users" class="form-control" v-model="transmission.duration" name="user_id" required>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postTransmission" :disabled="loading || !transmission.title" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateTransmission" :disabled="loading || !transmission.title" type="button" class="btn btn-primary">
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
            transmissions: [],
            transmission:{
                title: "",
                ar_title: "",
                description: "",
                image: "",
            }
        }
    },
    mounted(){
        this.getAllTransmission();
    },
    methods:{

        getAllTransmission(){
            this.loading_data = true
            axios.post('/api/subscriptions/all')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.transmissions = res.data.subscriptions;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },

        showTransmissionModal(){
            this.resetForm();
            this.editMode=  false;
            $('#transmissionModal').modal('show')
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
        postTransmission()
        {
            if(this.transmission.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.transmission.title)
            fd.append('description', this.transmission.description)
            fd.append('price', this.transmission.price)
            fd.append('duration', this.transmission.duration)


            axios.post('/api/subscription/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getAllTransmission();
                this.resetForm();
                $('#transmissionModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateTransmission()
        {
            if(this.transmission.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.transmission.title)
            fd.append('description', this.transmission.description)
            fd.append('price', this.transmission.price)
            fd.append('duration', this.transmission.duration)

            axios.post('/api/subscription/'+ this.transmission.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getAllTransmission();
                this.resetForm();
                $('#transmissionModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editTransmission(transmission){
            this.resetForm();
            this.newImageSrc = ''
            this.editMode=  true;
            this.transmission.id = transmission.id;
            this.transmission.title = transmission.title;
            this.transmission.description = transmission.description && transmission.description != 'null' ? transmission.description : '';
            this.transmission.price = transmission.price;
            this.transmission.duration = transmission.duration;
            this.transmission.user_id = transmission.user_id=="all"?undefined:transmission.user_id;

            if(transmission.image){
                this.newImageSrc = '/storage/transmissions/' + transmission.image
            }
            $('#transmissionModal').modal('show')

        },
        deleteTransmission(transmission){

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

                    this.deleting = transmission;
                    axios.post('/api/subscription/ ' + transmission.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllTransmission();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.transmission.title = ''
            this.transmission.ar_title = ''
            this.transmission.description = ''
            this.transmission.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>

<style>

</style>
