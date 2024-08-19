<template>


<div class="categories">

      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <!-- <button class="btn btn-primary btn-sm float-end" @click="showPermissionModal">
                        <i class="fas fa-plus"></i>
                        Permission
                    </button> -->
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
                            <th style="width: 500px; max-width: 100%;">Permissions</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(role , index) in roles" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{role.name}} </td>
                            <td>
                                <Pills
                                    :items="role.permissions"
                                    label="name"
                                    v-model="role.permissions"
                                    variant="blue"
                                    readonly
                                ></Pills>
                            </td>
                            <td> {{ role.create_date }} </td>
                            <td>


                                <a href="javascript:;"  @click="editRole(role)" > <i class="fas fa-edit"></i> </a>


                                <a href="javascript:;" class="text-danger" @click="deleteRole(role)"  :disabled="deleting == role" >
                                    <b-spinner small v-if="deleting == role"></b-spinner>
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
  id="roleModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode">Add Role</h5>
        <h5 class="modal-title" v-if="editMode">Edit Role</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="createRole" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="Name" class="row float-right col-form-label ">Name:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="Name" placeholder="Name" class="form-control" v-model="role.name" name="name" required>
                </div>
            </div>
            <hr>

            <div class="mb-2">Permissions</div>
            <!-- <Pills
                :items="permissions"
                label="name"
                v-model="role.permissions"
                variant="blue"
            ></Pills> -->
            <div class="row">
                <!--  -->
                <div class="col-12 col-md-6 col-lg-6" v-for="(group, index) in groups" :key="index" >
                <hr  />
                    <label class="mb-2 font-weight-bold text-capitalize"> {{index}} </label>
                    <a href="javascript:;" @click="selectGroup(group)" > <i class="fa-check-circle fas float-end cursor-pointer text-success"></i></a>

                    <div class="ms-4">
                        <div class="form-check mb-2" :key="index" v-for="(permission,index) in groups[index]" >
                            <input  v-model="role.permissions" class="form-check-input" type="checkbox" :value="permission.id" :id="`permission-${permission.id}`" />
                            <label class="form-check-label me-4 text-capitalize" :for="`permission-${permission.id}`">
                                {{permission.name}}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="createRole" :disabled="loading || !role.name" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateRole" :disabled="loading || !role.name" type="button" class="btn btn-primary">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-edit"></i>
        Update </button>


      </div>
    </div>
  </div>
</div>

<div
  class="modal fade"
  id="permissionModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="permissionModal">Add Permission</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="createPermission" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="Name" class="row float-right col-form-label ">Name:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="Name" placeholder="Name" class="form-control" v-model="permission.name" name="name" required>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button @click="createPermission" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

      </div>
    </div>
  </div>
</div>



</div>
</template>

<script>
import Pills from '../partials/pills.vue'
export default {
  components: { Pills },
    data(){
        return{
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            roles: [],
            permissions: [],
            groups: [],
            permission:{
                name: ""
            },
            role:{
                name: "",
                permissions: [],
            }
        }
    },
    mounted(){
        this.getAllRoles()
        this.getAllPermissions()
    },
    methods:{

        getAllRoles(){
            this.loading_data = true
            axios.post('/api/roles/all')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.roles = res.data.roles;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        getAllPermissions(){
            axios.post('/api/permissions/all')
            .then( res => {
                // console.log(res)
                this.permissions = res.data.permissions;
                this.groups = res.data.permissions_grouped;
            }).catch( err => {
            })
        },
        selectGroup(group) {
            let perms = group.map( per => per.id)
            console.log('perms', perms)
            perms.map( item => {
                if(!this.role.permissions.includes(item)) {
                    this.role.permissions.push(item)
                }
            })
            console.log('group', group)
        },
        showRoleModal(){
            this.resetForm();
            this.editMode=  false;
            $('#roleModal').modal('show')
        },
        showPermissionModal(){
            $('#permissionModal').modal('show')
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

        createPermission(){
            axios.post('/api/permission/store' , {
                permission: this.permission.name,
            }).then( res => {
                this.getAllPermissions()
                $('#permissionModal').modal('hide')
            }).catch(err => {

            })
        },
        createRole()
        {
            if(this.role.name){
                this.loading = true;

                axios.post('/api/role/store', this.role)
                .then(response => {
                    this.loading = false;
                    this.getAllRoles();
                    this.resetForm();
                    $('#roleModal').modal('hide')
                })
                .catch(error => {
                    this.loading = false
                    console.log('err.response', error.response)
                    if(error.response.status == 422){
                        this.$toastr.error(error.response.data.message)
                    }else{
                        this.$toastr.error('Something went wrong')
                    }
                })
            }else{
                this.$toastr.error('Name is required')
            }
        },

        updateRole()
        {
            if(this.role.name){
                this.loading = true;
                axios.post(`/api/role/${this.role.id}/update`, this.role )
                .then(response => {
                    this.loading = false;
                    this.getAllRoles();
                    this.resetForm();
                    $('#roleModal').modal('hide')
                })
                .catch(error => {
                    this.loading = false
                })
            }
        },
        editRole(role){
            this.resetForm();
            this.editMode=  true;
            this.role.id = role.id;
            this.role.name = role.name;
            this.role.permissions = role.permission_ids;
            $('#roleModal').modal('show')

        },
        deleteRole(role){

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

                    this.deleting = role;
                    axios.post(`/api/role/${role.id}/delete`)
                    .then( res => {
                        this.getAllRoles();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.role.name = ''
            this.role.permissions = []
        }


    }
}
</script>

<style>

</style>

