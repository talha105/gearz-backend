<template>
    <div class="sellers">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">

                    <a v-permission="'create push notifications'" class="btn btn-outline-success ms-2 btn-sm float-end" @click="openUserModal"  > <i class="fas fa-paper-plane"></i> Create New Notification</a>

                    <!-- <a class="btn btn-outline-primary ms-2  btn-sm float-end"   data-mdb-toggle="collapse" href="#filtersCollapse" role="button" aria-expanded="false" aria-controls="filtersCollapse" > <i class="fas fa-sort-shapes-down-alt"></i> Filter</a> -->


                    <h5 class="card-title">Manage Push Notifications</h5>


                </div>
                <!-- /.card-header -->
                <!-- <div class="collapse mt-3 container admin-filters" id="filtersCollapse">
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
                </div> -->


                <div class="card-body position-relative text-center table-wrapper">
                    <loader :small="false" v-if="loading" ></loader>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Arabic Title</th>
                            <th>Description</th>
                            <th>Arabic Description</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(notification , index) in notifications.data" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{notification.title}} </td>
                            <td> {{notification.ar_title}} </td>
                            <td> {{notification.description}} </td>
                            <td> {{notification.ar_description}} </td>
                            <td> {{notification.create_date}} </td>
                            <td>
                                <a
                                    href="javascript:;"
                                    class="text-success"
                                    @click="resendNotification(notification)"
                                    :disabled="deleting == notification"
                                    >
                                    <b-spinner small v-if="deleting == notification"></b-spinner>
                                    <i v-else  class="fas fa-share-square"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination
                    align="center"
                    :data="notifications"
                    @pagination-change-page="getAllNotifications"
                ></pagination>

                </div>
            </div>
        </div>
    </div>


<div
  class="modal fade"
  id="notificationModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModal">Add New Notification</h5>
        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="createNewNotification" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="notification.title" name="title" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Arabic Title" class="form-control" v-model="notification.ar_title" name="title" required>
                </div>
            </div>


            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label "> Description:</label>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea v-model="notification.description" class="form-control" placeholder="Description" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label "> Arabic Description:</label>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea v-model="notification.ar_description" class="form-control" placeholder="Arabic Description" rows="3"></textarea>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button @click="createNewNotification" :disabled="loading || !notification.title" type="button" class="btn btn-success">
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
export default {
    mounted(){
        this.getAllNotifications();
    },
    data(){
        return{
            notifications : {},
            deleting: "",
            approving: "",
            loading: false,
            editMode: false,
            isSearching: false,
            notification:{
                id: "",
                title: "",
                ar_title: "",
                description: "",
                ar_description: "",
            },
            search:{
                sortBy: 'desc',
                name: '',
            },
            page: 1,

        }
    },
    methods:{
        getAllNotifications(page = 1){
            this.page = page
            this.loading = true
            axios.get('/api/push-notifications?page=' + page)
            .then( res => {
                this.loading = false
                this.notifications = res.data.notifications
            }).catch(err => {
                this.loading = false

            })
        },

        resendNotification(notification){
            Swal.fire({
                title: 'Send the notification again?',
                text: "We will send this notification to the users again",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send!'
                }).then((result) => {

                if (result.isConfirmed) {
                    this.deleting = notification;
                    axios.post('/api/push-notification/resend', {id : notification.id})
                    .then( res => {
                        this.notifications.data.unshift(res.data.notification)
                        this.deleting = ''
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        openUserModal(){
            this.editMode = false
            this.resetForm()
            $('#notificationModal').modal('show')
        },
        createNewNotification(){
            this.loading = true
            axios.post('/api/push-notification/create' , this.notification)
            .then( res => {
                this.loading = false
                this.notifications.data.unshift(res.data.notification)
                $('#notificationModal').modal('hide')
            }).catch( err => {
                console.log(err.response)
                this.$toastr.error(err.response.data.message);
                this.loading = false
            })
        },

        resetForm(){
            this.notification.title = ''
            this.notification.description = ''
        }
    }
}
</script>
