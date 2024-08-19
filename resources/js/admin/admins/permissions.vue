<template>


<div class="categories">
    
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm float-end" @click="showRoleModal"> 
                    <i class="fas fa-plus"></i>
                    Create
                    </button>
                    <h5 class="card-title">Manage Roles</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative table-wrapper">
                    <loader v-if="loading_data" :small="false"></loader>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 115px">Create Date</th>
                            <th style="width: 100px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(admin , index) in admins" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{admin.name}} </td>
                            <td> {{admin.email }} </td>
                            <td> {{admin.type }} </td>
                            
                            <td> {{ admin.create_date }} </td>
                            <td>
                                

                                <a href="javascript:;"  @click="editCategory(admin)" > <i class="fas fa-edit"></i> </a>
                                

                                <a href="javascript:;" class="text-danger" @click="deleteCategory(admin)"  :disabled="deleting == admin" > 
                                    <b-spinner small v-if="deleting == admin"></b-spinner>    
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
  id="adminModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="adminModal">Add Admin</h5>
        <h5 class="modal-title" v-if="editMode" id="adminModal">Edit Admin</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postAdmin" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="Name" class="row float-right col-form-label ">Name:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="Name" placeholder="Name" class="form-control" v-model="admin.name" name="name" required>
                </div>
            </div>
            
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="email" class="row float-right col-form-label ">Email:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="email" :disabled="editMode" id="email" placeholder="Email" class="form-control" v-model="admin.email" name="name" required>
                </div>
            </div>
            
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="Password" class="row float-right col-form-label ">Password:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="Password" placeholder="Password" class="form-control" v-model="admin.password" name="name" required>
                </div>
            </div>
            
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="confirm_password" class="row float-right col-form-label ">Confirm Password:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="confirm_password" placeholder="Confirm Password" class="form-control" v-model="admin.confirm_password" name="name" required>
                </div>
            </div>
            
        </form>
    </div>

    <div class="modal-footer">
        
        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postAdmin" :disabled="loading || !admin.email || !admin.confirm_password || !admin.password || !admin.name" type="button" class="btn btn-success"> 
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i> 
        Create </button>

        <button v-if="editMode" @click="updateCategory" :disabled="loading || !admin.email" type="button" class="btn btn-primary"> 
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
            admins: [],
            admin:{
                name: "",
                email: "",
                password: "",
                confirm_password: "",
            }
        }
    },
    mounted(){
        this.getAllAdmins();
    },
    methods:{

        getAllAdmins(){
            this.loading_data = true
            axios.post('/api/admins/all')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.admins = res.data.admins;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },

        showRoleModal(){
            this.resetForm();
            this.editMode=  false;
            $('#adminModal').modal('show')
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
        postAdmin()
        {
            if(this.admin.email){            
            this.loading = true;

            axios.post('/api/admin/store', this.admin)
            .then(response => {
                this.loading = false;
                this.getAllAdmins();
                this.resetForm();
                $('#adminModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },
        
        updateCategory()
        {
            if(this.admin.email){            
            this.loading = true;
            axios.post('/api/admin/'+ this.admin.id +'/update', this.admin )
            .then(response => {
                this.loading = false;
                this.getAllAdmins();
                this.resetForm();
                $('#adminModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editCategory(admin){
            // console.log(admin)
            this.resetForm();
            this.editMode=  true;
            this.admin.id = admin.id;
            this.admin.name = admin.name;
            this.admin.email = admin.email;
            this.admin.password = '';
            this.admin.confirm_password = '';
            $('#adminModal').modal('show')

        },
        deleteCategory(admin){

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

                    this.deleting = admin;
                    axios.post('/api/admin/ ' + admin.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllAdmins();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.admin.name = ''
            this.admin.email = ''
            this.admin.password = ''
            this.admin.confirm_password = ''
        }


    }
}
</script>