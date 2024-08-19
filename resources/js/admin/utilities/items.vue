<template>


<div class="categories">
    
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">

                    <button class="btn btn-primary btn-sm float-end" @click="showItemModal"> 
                    <i class="fas fa-plus"></i>
                    Create
                    </button>

                    <button class="btn btn-outline-dark btn-sm float-end me-2" @click="$router.back()"> <i class="fas fa-arrow-left me-2"></i>Back</button>

                    <h5 class="card-title">Manage Items</h5>
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
                            <!-- <th>Image</th> -->
                            <th style="width: 115px">Create Date</th>
                            <th style="width: 100px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(item , index) in items" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{item.title}} </td>
                            <td> {{item.ar_title }} </td>
                            <td> {{item.description }} </td>
                            <td> {{ item.create_date }} </td>
                            <td>
                                <a href="javascript:;"  @click="editItem(item)" > <i class="fas fa-edit"></i> </a>                                

                                <a href="javascript:;" class="text-danger" @click="deleteItem(item)"  :disabled="deleting == item" > 
                                    <b-spinner small v-if="deleting == item"></b-spinner>    
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
  id="itemModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="itemModal">Add Item</h5>
        <h5 class="modal-title" v-if="editMode" id="itemModal">Edit Item</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postItem" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="item.title" name="name" required>
                </div>
            </div>
            
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="ar_title" placeholder="Aracic Title" class="form-control" v-model="item.ar_title" name="name" required>
                </div>
            </div>
          
          <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="description" class="row float-right col-form-label ">Description:</label>
                    </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea rows="5" class="form-control" id="description" v-model="item.description" placeholder="Description of item"></textarea>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button> -->

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postItem" :disabled="loading || !item.title" type="button" class="btn btn-success"> 
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i> 
        Create </button>

        <button v-if="editMode" @click="updateItem" :disabled="loading || !item.title" type="button" class="btn btn-primary"> 
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
            items: [],
            item:{
                title: "",
                ar_title: "",
                description: "",
                image: "",
            }
        }
    },
    mounted(){
        this.getAllItems();
    },
    methods:{

        getAllItems(){
            this.loading_data = true
            axios.post('/api/utility/'+ this.$route.params.id +'/items')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.items = res.data.items;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
                
        showItemModal(){
            this.resetForm();
            this.editMode=  false;
            $('#itemModal').modal('show')
        },
        selectImageDialog(){
            $('#category_image').click()
        },
        postItem()
        {
            if(this.item.title){

            this.loading = true;
            var fd = new FormData();
            fd.append('utility_id', this.$route.params.id)
            fd.append('title', this.item.title)
            fd.append('ar_title', this.item.ar_title)
            fd.append('description', this.item.description)

            axios.post('/api/item/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getAllItems();
                this.resetForm();
                $('#itemModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },
        
        updateItem()
        {
            if(this.item.title){

            
            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.item.title)
            fd.append('ar_title', this.item.ar_title)
            fd.append('description', this.item.description)

            axios.post('/api/item/'+ this.item.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getAllItems();
                this.resetForm();
                $('#itemModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editItem(item){
            this.resetForm();
            this.editMode=  true;
            this.item.id = item.id;
            this.item.title = item.title;
            this.item.ar_title = item.ar_title;
            this.item.description = item.description && item.description != 'null' ? item.description : '';
            // if(item.image){
            //     this.newImageSrc = '/storage/utilities/' + item.image
            // }
            $('#itemModal').modal('show')

        },
        deleteItem(item){

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

                    this.deleting = item;
                    axios.post('/api/item/ ' + item.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllItems();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.item.title = ''
            this.item.ar_title = ''
            this.item.description = ''
            this.item.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>

