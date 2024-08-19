<template>


<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create display blocks'"  class="btn btn-primary btn-sm float-end" @click="showblockModal"> <i class="fas fa-plus"></i> Create</button>
                    <h5 class="card-title"> Display Blocks</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative table-wrapper block-wrapper">
                    <loader v-if="loading_data" :small="false"></loader>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Arabic Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <!-- <th>Listing Count</th> -->
                                <th style="width: 115px">Create Date</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                        </thead>

                        <draggable v-model="blocks" tag="tbody" @change="sortUpdate" @start="drag=true" @end="sortUpdate">

                            <tr :id="block.id" v-for="(block , index) in blocks" :key="index">
                                <td> {{index + 1}} </td>
                                <td> {{block.title }}</td>
                                <td> {{block.ar_title }}</td>
                                <td> {{block.description }} </td>

                                <td>
                                    <span class="badge bg-danger" v-if="block.status == 0">Disabled</span>
                                    <span class="badge bg-success" v-if="block.status == 1">Active</span>
                                </td>

                                <!-- <td> {{ block.listings.length }} </td> -->
                                <td> {{ block.create_date }} </td>
                                <td>

                                    <a v-permission="'edit display blocks'" href="javascript:;"  @click="editBlock(block)" > <i class="fas fa-edit"></i> </a>
                                    <a v-permission="'delete display blocks'" href="javascript:;" class="text-danger" @click="deleteBlock(block)"  :disabled="deleting == block" >
                                        <b-spinner small v-if="deleting == block"></b-spinner>
                                        <i v-else  class="fas fa-trash-alt"></i>
                                    </a>

                                </td>
                            </tr>
                    </draggable>

                    </table>
                </div>
            </div>

        </div>
    </div>






<div
  class="modal fade"
  id="blockModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="blockModal">Add Block</h5>
        <h5 class="modal-title" v-if="editMode" id="blockModal">Edit Block</h5>

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
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="block.title" name="name" required>
                </div>
            </div>
              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Arabic Title" class="form-control" v-model="block.ar_title" name="name" required>
                </div>
            </div>

          <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="description" class="row float-right col-form-label ">Description:</label>
                    </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea rows="5" class="form-control" id="description" v-model="block.description" placeholder="Description of category"></textarea>
                </div>
          </div>

          <div class="form-group row">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                <label for="inputEmail1" class="row float-right col-form-label ">Status:</label>
            </div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" :checked="block.status == 1" v-model="block.status" value="1" id="status" />
                    <label class="form-check-label me-4" for="status">
                        Active
                    </label>
                    </div>
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button> -->

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postBlock" :disabled="loading || !block.title" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateBlock" :disabled="loading || !block.title" type="button" class="btn btn-primary">
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
            drag: false,
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            category: '',
            blocks: [],
            block:{
                title: "",
                ar_title: "",
                description: "",
                status: "",
            }
        }
    },
    mounted(){
        // if(!this.category){
        //     this.$router.back();
        // }
        this.getBlocks();
    },
    methods:{

        getBlocks(){
            this.loading_data = true
            axios.post('/api/display-blocks/all')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.blocks = res.data.blocks;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        showblockModal(){
            this.resetForm();
            this.editMode=  false;
            $('#blockModal').modal('show')
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
        postBlock()
        {
            if(this.block.title){

            this.loading = true;

            axios.post('/api/display-blocks/store', {
                title: this.block.title,
                ar_title: this.block.ar_title,
                description: this.block.description,
                status: this.block.status,
            })
            .then(response => {
                this.loading = false;
                this.getBlocks();
                this.resetForm();
                $('#blockModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateBlock()
        {
            if(this.block.title){

            this.loading = true;
            axios.post('/api/display-blocks/'+ this.block.id +'/update',  {
                title: this.block.title,
                ar_title: this.block.ar_title,
                description: this.block.description,
                status: this.block.status,
            })
            .then(response => {
                this.loading = false;
                this.getBlocks();
                this.resetForm();
                $('#blockModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editBlock(block){
            console.log(block)
            this.resetForm();
            this.editMode=  true;
            this.block.id = block.id;
            this.block.title = block.title;
            this.block.ar_title = block.ar_title;
            this.block.status = block.status;
            this.block.description = block.description && block.description != 'null' ? block.description : '';
            $('#blockModal').modal('show')

        },
        deleteBlock(block){

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

                    this.deleting = block;
                    axios.post('/api/display-blocks/ ' + block.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.deleting = ''
                        this.getBlocks();
                    }).catch( err => {

                        this.deleting = ''
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.block.title = ''
            this.block.ar_title = ''
            this.block.description = ''
            this.block.status = 0
        },
        sortUpdate(val){
            console.log(val)
            let ids = []
            this.blocks.map( block => {
                // console.log(block.id)
                ids.push(block.id)
            });
            axios.post('/api/blocks/update-sort-index' , {
                ids
            }).then( res => {
                console.log(res)
            }).catch(err => {
                console.log(err)
            })
        }


    }
}
</script>

<style>
@media screen and (max-width:768px) {
    .block-wrapper{
        padding-bottom: 30px;
    }
}
</style>
