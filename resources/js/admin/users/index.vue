<template>
    <div class="sellers">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">

                    <a v-permission="'create users'" class="btn btn-outline-success ms-2 btn-sm float-end" @click="openUserModal"  > <i class="fas fa-plus"></i> Add User</a>

                    <a class="btn btn-outline-primary ms-2  btn-sm float-end"   data-mdb-toggle="collapse" href="#filtersCollapse" role="button" aria-expanded="false" aria-controls="filtersCollapse" > <i class="fas fa-sort-shapes-down-alt"></i> Filter</a>


                    <h5 class="card-title">Manage Sellers</h5>


                </div>
                <!-- /.card-header -->
                <div class="collapse mt-3 container admin-filters" id="filtersCollapse">
                    <div class="row ps-3 pe-3">
                        <div class="offset-md-1 col-md-6 col-lg-6 col-sm-12 col-12 single-filte-item">
                            <input v-model="search.name" class="form-control" placeholder="Name" />
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12 col-12 single-filte-item text-center">
                            <button class="btn btn-sm btn-floating" :class="{'btn-black' : search.sortBy == 'asc'}" @click="sortFilter('asc')" data-mdb-toggle="tooltip" title="Sort Oldest" ><i class="fas fa-arrow-down"></i></button>
                            <button class="btn btn-sm btn-floating" :class="{'btn-black' : search.sortBy == 'desc'}" @click="sortFilter('desc')" data-mdb-toggle="tooltip" title="Sort Newest" ><i class="fas fa-arrow-up"></i></button>
                        </div>

                        <div class="col-md-3 col-lg-3 col-sm-12 col-12 text-center single-filte-item">
                            <button type="button" @click="initiateSearching" class="btn btn-success">Search</button>
                            <button type="button" @click="clearSearch" class="btn btn-outline-danger ms-2">Reset</button>
                        </div>
                    </div>
                </div>


                <div class="card-body position-relative text-center table-wrapper">
                    <loader :small="false" v-if="loading" ></loader>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user , index) in users.data" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{user.name}} </td>
                            <td> {{user.email}} </td>
                            <td> {{user.phone}} </td>
                            <td> {{user.create_date}} </td>
                            <td>
                                <a v-permission="'edit users'" href="javascript:;" @click="editUser(user)"> <i class="fas fa-edit"></i></a>

                                <a v-permission="'delete users'" href="javascript:;" class="text-danger" @click="deleteUser(user)"  :disabled="deleting == user" >
                                    <b-spinner small v-if="deleting == user"></b-spinner>
                                    <i v-else  class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <pagination align="center" v-if="!isSearching" :data="users" @pagination-change-page="getAllUsers"></pagination>
                <pagination align="center" v-if="isSearching" :data="users" @pagination-change-page="searchUsers"></pagination>

                </div>
            </div>
        </div>
    </div>


<div
  class="modal fade"
  id="userModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="userModal">Add User</h5>
        <h5 class="modal-title" v-if="editMode" id="userModal">Edit User</h5>
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
                    <label for="title" class="row float-right col-form-label ">Name:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Name" class="form-control" v-model="user.name" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Email:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="email" id="email" placeholder="Email" class="form-control" v-model="user.email" name="email" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Phone:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="tel" id="phone" placeholder="Phone" class="form-control" v-model="user.phone" name="phone" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Password:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="password" id="password" placeholder="Password" class="form-control" v-model="user.password" name="password" :required="!editMode" >
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button> -->

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postUser" :disabled="loading || !user.email && !user.password" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateUser" :disabled="loading || !user.email && !user.password" type="button" class="btn btn-primary">
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
    mounted(){
        this.getAllUsers();
    },
    data(){
        return{
            users : {},
            deleting: "",
            approving: "",
            loading: false,
            editMode: false,
            isSearching: false,
            user:{
                id: "",
                name: "",
                email: "",
                password: "",
                phone: "",
            },
            search:{
                sortBy: 'desc',
                name: '',
            },
            page: 1,

        }
    },
    methods:{

        refreshListings(){
            if(this.isSearching){
                this.searchUsers(this.page)
            }else{
                this.getAllUsers(this.page);
            }
        },

        initiateSearching(){
            this.isSearching = true
            this.listings = [];
            this.searchUsers();
        },
        searchUsers(page = 1){
            this.page = page
            this.loading = true
            axios.post('/api/search-users?page=' + page , this.search)
            .then( res => {
                this.loading = false
                this.users = res.data.users
            }).catch(err => {
                this.loading = false
            })
        },

        getAllUsers(page = 1){
            this.page = page
            this.loading = true
            axios.post('/api/all-users?page=' + page)
            .then( res => {
                this.loading = false
                this.users = res.data.users
            }).catch(err => {
                this.loading = false

            })
        },
        deleteUser(user){

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
                    this.deleting = user;
                    axios.post('/api/user/ ' + user.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllUsers();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        sortFilter(sort){
            this.search.sortBy = sort
        },
        clearSearch(){
            this.search = {
                sortBy: 'asc',
                title: '',
                user: '',
                status: '',
                active: '',
            }
            const myCollapse = document.getElementById('filtersCollapse')
            const bsCollapse = new mdb.Collapse(myCollapse)
            bsCollapse.hide()

            this.isSearching = false
            this.listings = [];
            this.refreshListings()

        },
        openUserModal(){
            this.editMode = false
            $('#userModal').modal('show')
        },
        postUser(){
            this.loading = true
            axios.post('/api/create-user' , this.user)
            .then( res => {
                this.loading = false
                this.getAllUsers();
                $('#userModal').modal('hide')
            }).catch( err => {
                console.log(err.response)
                this.$toastr.error(err.response.data.message);
                this.loading = false
            })
        },
        editUser(user){

            this.editMode = true
            this.user.id = user.id
            this.user.name = user.name
            this.user.email = user.email
            this.user.phone = user.phone
            this.user.password = ''
            $('#userModal').modal('show')
        },
        updateUser(){
            this.loading = true
            axios.post('/api/update-user/' + this.user.id , this.user)
            .then( res => {
                this.loading = false
                this.getAllUsers();
                $('#userModal').modal('hide')
            }).catch( err => {
                console.log(err.response)
                this.$toastr.error(err.response.data.messsage);
                this.loading = false
            })

        }

    }
}
</script>
