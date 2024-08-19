<template>
      <div class="row dashboard-listing-index">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">


                    <a class="btn btn-primary btn-sm float-end " href="javascript:;" @click="$router.push('/admin/create-listing')" > <i class="fas fa-plus"></i> Create</a>
                    <h5 class="card-title">{{block.title}} Listings</h5>
                </div>
                <!-- /.card-header -->

                

                <div class="card-body position-relative text-center table-wrapper">
                <loader :small="false" v-if="loading"></loader>
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Posted By</th>
                            <th>Category</th>
                            <th>City</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(listing , index) in listings.data" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{listing.title}} </td>
                            <td> {{listing.user ? listing.user.name : 'Admin'}} </td>
                            <td> {{listing.category ? listing.category.title : ''}} </td>
                            <td> {{listing.city}} </td>
                            <td> {{listing.day_price + '/Per Day'}} </td>
                            <td>
                                <span class="badge bg-danger" v-if="listing.status == 'pending'" >Pending</span>
                                <span class="badge bg-warning" v-if="listing.status == 'draft'">Draft</span>

                                <span class="badge bg-danger" v-if="listing.status == 'approved' && listing.active == 0" >Inactive</span>

                                <span class="badge bg-success" v-if="listing.status == 'approved' && listing.active == 1" >Active</span>
                            </td>
                            <td>
                                <img class="ad-image"  v-if="listing && listing.main_image" :src="'/storage/listings/' + listing.main_image"  />
                                <img class="ad-image" v-else src="/img/car_no_image.jpg" />
                            </td>
                            <td> {{listing.create_date}} </td>

                            
                            <td>
                                <a @click="openBlocksModal(listing)" class="text-success me-2" title="Edit Blocks" href="javascript:;" > <i class="fas fa-ballot-check"></i> </a> 

                                <a target="_blank" class="text-primary me-2" title="View" :href="'/view/'+listing.id+'/listing'"> <i class="fas fa-eye"></i> </a> 
                                
                                <a v-if="listing.status == 'pending' || listing.status == 'draft' "  class="text-success me-2" title="Approve" href="javascript:;" @click="updateListingStatus('approved' , listing)"> 
                                <b-spinner small v-if="approving == listing"></b-spinner>
                                <i class="fas fa-check" v-else></i></a>

                                <a v-if="listing.status == 'approved'"  class="text-warning me-2" title="Draft" href="javascript:;" @click="updateListingStatus('draft' , listing)"> 


                                <b-spinner small v-if="approving == listing"></b-spinner>
                                <i class="fas fa-times" v-else></i></a>
                                
                                 <router-link :to="'/admin/edit-listing/'+listing.id" class="me-2"> <i class="fas fa-edit"></i> </router-link>

                            
                            
                                <a href="javascript:;" class="text-danger" @click="deleteListing(listing)"  :disabled="deleting == listing" > 
                                    <b-spinner small v-if="deleting == listing"></b-spinner>    
                                    <i v-else  class="fas fa-trash-alt"></i> 
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <pagination align="center" v-if="!isSearching" :data="listings" @pagination-change-page="getAllListings"></pagination>
                <pagination align="center" v-if="isSearching" :data="listings" @pagination-change-page="searchListings"></pagination>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockModal">Listing Blocks</h5>

                <button
                type="button"
                class="btn-close"
                data-mdb-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body px-5">
                <form @submit.prevent="updateListingBlocks" >

                    <div class="form-group row">
                        <div class="col-12" v-for="block in blocks" :key="block.id">
                            <div class="form-check mt-2">
                                <input class="form-check-input" :value="block.id" type="checkbox" v-model="current_listing.block_ids" :id="'block-'+block.id" />
                                <label class="form-check-label me-4" :for="'block-'+block.id">
                                    {{block.title}}
                                </label>
                                </div>
                            </div>
                        </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>
                <button @click="updateListingBlocks" :disabled="updating" type="button" class="btn btn-primary"> 
                    <b-spinner v-if="updating" small ></b-spinner>
                    <i v-else class="fas fa-edit"></i> 
                Update </button>
            </div>
            </div>
        </div>
        </div>


    </div>
</template>

<script>
import button from '../partials/button.vue';
export default {
  components: { button },
    mounted(){
        this.getAllListings();
        this.getAllCategories();
        this.getBlocks();
    },
    data(){
        return{
            page : 1,
            listings : {},
            block : {},
            blocks : [],
            categories : [],
            current_listing: "",
            deleting: "",
            approving: "",
            updating: false,
            loading: false,
            isSearching: false,
            search:{
                sortBy: 'asc',
                title: '',
                user: '',
                status: '',
                active: '',
                city: '',
                category: '',
                block: '',
            }
        }
    },
    methods:{

        refreshListings(){
            if(this.isSearching){
                this.searchListings(this.page)
            }else{
                this.getAllListings(this.page);
            }
        },
        getAllListings(page = 1){
            this.page = page
            this.loading = true
            axios.post('/api/listings?page=' + page)
            .then( res => {
                this.loading = false
                this.listings = res.data.listings
            }).catch(err => {
                this.loading = false

            })
        },
        initiateSearching(){
            this.isSearching = true
            this.listings = [];
            this.searchListings();
        },
        searchListings(page = 1){
            this.page = page
            this.loading = true
            axios.post('/api/search-listings?page=' + page , this.search)
            .then( res => {
                this.loading = false
                this.listings = res.data.listings
            }).catch(err => {
                this.loading = false
            })
        },
        getBlocks(){
            this.loading_data = true
            axios.post('/api/display-blocks/get')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.blocks = res.data.blocks;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        getAllCategories(){
            this.loading_data = true
            axios.post('/api/category/all')
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.categories = res.data.categories;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        updateListingBlocks(){
            this.updating = true
            axios.post('/api/listing-block-update' , {
                listing_id: this.current_listing.id,
                block_ids: this.current_listing.block_ids,
            })
            .then( res => {
                console.log(res)
                this.updating = false
                this.refreshListings();
                $('#blockModal').modal('hide')

            }).catch( err => {
                this.updating = false
                console.log(err)
            })

        },
        openBlocksModal(listing){
            this.current_listing = listing
            $('#blockModal').modal('show')

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
                        this.refreshListings();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },

        updateListingStatus(status , listing){
            console.log(status , listing)
            this.approving = listing

            axios.post('/api/update-listing-status' , {
                listing_id : listing.id,
                status,
            }).then(res => {
                this.refreshListings();
            }).catch(err => {
                this.$toastr.error(err.response.data.message);
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
                city: '',
                category: '',
                block: '',
            }

            const myCollapse = document.getElementById('filtersCollapse')
            const bsCollapse = new mdb.Collapse(myCollapse)
            bsCollapse.hide()

            this.isSearching = false
            this.listings = [];
            this.refreshListings()

        }
    }
}
</script>

<style>
.dashboard-listing-index .ad-image{
    width: 100px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
}
</style>