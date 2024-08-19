<template>
    <div class="sellers">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title">Manage Reviews</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative text-center table-wrapper">
                    <loader :small="false" v-if="loading" ></loader>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Status</th>
                            <th>Listing Title</th>
                            <th>Garage</th>
                            <th>Rating</th>
                            <th>Text</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="reviews && reviews.data">
                        <tr v-for="(review , index) in reviews.data" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{review.details.userName}} </td>
                            <td> {{review.details.userEmail}} </td>
                            <td>
                                <span class="badge bg-danger" v-if="review.status == 0" >Pending</span>
                                <span class="badge bg-success" v-if="review.status == 1" >Approved</span>
                            </td>
                            <td> {{review.details.listingTitle}} </td>
                            <td> {{review.details.garageName}} </td>
                            <td>
                                <star-rating
                                    class="single-review"
                                    active-color="#1266f1"
                                    v-model="review.rating"
                                    :round-start-rating="false"
                                    :show-rating="false"
                                    :read-only="true"
                                    :star-size="15"
                                ></star-rating>
                            </td>
                            <td> {{review.text.substr(0,50)}} </td>
                            <td> {{review.create_date}} </td>
                            <td>
                                <a v-permission="'approve reivews'" v-if="review.status == 0"  class="text-success me-2" title="Approve" href="javascript:;" @click="updateReviewStatus( 1 , review)">
                                <b-spinner small v-if="approving == review"></b-spinner>
                                <i class="fas fa-check" v-else></i></a>

                                <a class="text-success me-2" title="Show details" href="javascript:;" @click="showReview(review)">
                                <i class="far fa-eye"></i></a>

                                <a v-permission="'reject reivews'" href="javascript:;" class="text-danger" @click="deleteReview(review)"  :disabled="deleting == review" >
                                    <b-spinner small v-if="deleting == review"></b-spinner>
                                    <i v-else  class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination
                    align="center"
                    :data="reviews"
                    @pagination-change-page="getAllReview"></pagination>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Show Review</h5>
        <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form>


            <div class="form-group row" v-if="currentReview">

                <div class="col-8 offset-1">{{currentReview.details.userName}}</div>
                <div class="col-2">
                    <star-rating
                        class="single-review"
                        active-color="#1266f1"
                        v-model="currentReview.rating"
                        :round-start-rating="false"
                        :show-rating="false"
                        :star-size="15"
                        :read-only="true"
                    ></star-rating>
                </div>
                <hr class="mt-2">
                <div class="col-10 offset-1 text-break">
                    <div class="text-break"> {{currentReview.text}} </div>
                </div>
            </div>
        </form>

        <div></div>
      </div>

    </div>
  </div>
</div>

</div>
</template>

<script>
export default {
    mounted(){
        this.getAllReview();
    },
    data(){
        return{
            reviews : {},
            deleting: "",
            approving: "",
            loading: false,
            currentReview:"",
        }
    },
    methods:{
        getAllReview(page = 1){
            this.loading = true
            axios.post('/api/reviews/all?page=' + page)
            .then( res => {
                this.loading = false
                this.reviews = res.data.reviews
            }).catch(err => {
                this.loading = false

            })
        },
        updateReviewStatus( status , review){
            this.approving = review
            axios.post('/api/review/update-status' , {
                review_id : review.id,
                status: status
            }).then( res => {
                this.getAllReview()
            }).catch(err => {
            })
        },
        showReview(review){
            this.currentReview = review
            $('#showReviewModal').modal('show');
        },
        deleteReview(review){

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
                    this.deleting = review;
                    axios.post('/api/review/ ' + review.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllReview();
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
.single-review{
    justify-content: center;
}
</style>
