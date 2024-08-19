<template>

<div class="mz--dashboard dashboard-listings">
      <div class="container-fluid mt-4">

      <div class="row">
       

        <div class="col-12 col-sm-12 col-md-12 col-lg-12" :class="{'left-area' : $store.getters.getCurrentLocale && $store.getters.getCurrentLocale == 'ar' , 'right-area' : !$store.getters.getCurrentLocale || $store.getters.getCurrentLocale == 'en' }" >
          <div class="smz-box">
            <div class="smz-box-title">{{trans._getMessage('My Listings')}}</div>

        <div class="row">
                <div class="col-md-12" style="padding:10px" >
                    <div class="position-relative ">
                        <!-- /.card-header -->
                        <loader :small="false" v-if="loading"></loader>
                        <div class="table-wrapper">
                        <table class="table table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans._getMessage('Title')}}</th>
                                    <th>{{trans._getMessage('Price')}}</th>
                                    <th>{{trans._getMessage('Status')}}</th>
                                    <th>{{trans._getMessage('Create Date')}}</th>
                                    <th>{{trans._getMessage('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(listing , index) in listings" :key="index">
                                    <td> {{index + 1}} </td>
                                    <td> {{listing.proper_title}} </td>
                                    <td> {{listing.price}} </td>
                                    <td>
                                        <!-- <span class="badge badge-danger" v-if="listing.status == 'pending'" >{{trans._getMessage('Pending')}}</span>
                                        <span class="badge badge-success" v-if="listing.status == 'approved'" >{{trans._getMessage('Approved')}}</span>
                                        <span class="badge badge-warning" v-if="listing.status == 'draft'">{{trans._getMessage('Draft')}}</span> -->

                                        <span class="badge badge-danger" v-if="listing.status == 'pending'" >{{trans._getMessage('Pending')}}</span>

                                        <span class="badge bg-warning" v-if="listing.status == 'rejected'">{{trans._getMessage('Rejected')}}</span>

                                        <span class="badge badge-danger" v-if="listing.status == 'draft'">{{trans._getMessage('Draft')}}</span>

                                        <span class="badge badge-danger" v-if="listing.status == 'approved' && listing.active == 0" >{{trans._getMessage('Inactive')}}</span>

                                        <span class="badge badge-success" v-if="listing.status == 'approved' && listing.active == 1" >{{trans._getMessage('Active')}}</span>

                                    </td>
                                    <td> {{listing.create_date}} </td>
                                    <td> <router-link :to="'/seller/edit-listing/'+listing.id"> <i class="fas fa-edit"></i> </router-link>

                                        <a href="javascript:;" class="text-danger" @click="deleteListing(listing)"  :disabled="deleting == listing" >
                                            <b-spinner small v-if="deleting == listing"></b-spinner>
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
          </div>
          </div>
      </div>

      </div>
  </div>

</template>

<script>
export default {
    mounted(){
        this.getAllListings();
    },
    data(){
        return{
            listings : [],
            deleting: "",
            loading: false,
        }
    },
    methods:{
        getAllListings(){
            this.loading = true
            axios.post('/api/seller-listings/'+this.$route.query.user_id)
            .then( res => {
                this.loading = false
                this.listings = res.data.listings
            }).catch(err => {

                this.loading = false
            })
        },
        deleteListing(listing){

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

                    this.deleting = listing;
                    axios.post('/api/listing/ ' + listing.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllListings();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },
    }
}
</script>

<style>
.dashboard-listings .table{
  min-width: max-content;
}
.dashboard-listings .table-wrapper{
  overflow: auto;
}

</style>
