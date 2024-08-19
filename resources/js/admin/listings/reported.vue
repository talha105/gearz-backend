<template>
    <div class="sellers">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title">Manage Reported Listings</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative text-center">
                    <loader :small="false" v-if="loading" ></loader>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Listing </th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Text</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(report , index) in reports.data" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{report.user ? report.user.name : ""}} </td>
                            <td><a v-if="report.listing" target="_blank" class="text-primary me-2" title="View" :href="'/view/'+report.listing.id+'/listing'"> {{ report.listing.title}} </a> </td>
                            <td> 
                                <span class="badge bg-danger" v-if="report.status == 0" >Pending</span>
                                <span class="badge bg-success" v-if="report.status == 1" >Resolved</span>
                            </td>

                            <td> {{report.reason}} </td>
                            <td> {{report.text ? report.text.substr(0,50) : ""}} </td>
                            <td> {{report.create_date}} </td>
                            <td>                            
                                <a v-if="report.status == 0"  class="text-success me-2" title="Resolve" href="javascript:;" @click="updateReportStatus( 1 , report)"> 
                                <b-spinner small v-if="approving == report"></b-spinner>
                                <i class="fas fa-check" v-else></i></a>

                                <a href="javascript:;" class="text-danger" @click="deleteReport(report)"  :disabled="deleting == report" > 
                                    <b-spinner small v-if="deleting == report"></b-spinner>    
                                    <i v-else  class="fas fa-trash-alt"></i> 
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- <ul>
                    <li v-for="post in laravelData.data" :key="post.id">{{ post.title }}</li>
                </ul> -->
                <pagination align="center" :data="reports" @pagination-change-page="getAllReports"></pagination>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Show Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
            
          
            <!-- <div class="form-group row" v-if="currentReport">

                <div class="col-8 offset-1">{{currentreports.user.name}}</div>
                <div class="col-2">
                    <star-rating 
                        class="single-review"
                        active-color="#1266f1"
                        v-model="currentreports.rating" 
                        :round-start-rating="false"
                        :show-rating="false"
                        :star-size="15"
                        :read-only="true"
                    ></star-rating>
                </div>
                <hr class="mt-2">
                <div class="col-10 offset-1">
                    
                    <div> {{currentreports.text}} </div>
                </div>
            </div> -->
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
        this.getAllReports();
    },
    data(){
        return{
            reports : [],
            deleting: "",
            approving: "",
            drag: false,
            loading: false,
            currentReport:"",
        }
    },
    methods:{
        getAllReports(page = 1){
            this.loading = true
            axios.post('/api/reports/all?page=' + page)
            .then( res => {
                this.loading = false
                this.reports = res.data.reports
            }).catch(err => {
                this.loading = false

            })
        },
        updateReportStatus( status , report){
            this.approving = report
            axios.post('/api/report/update-status' , {
                report_id : report.id,
                status: status
            }).then( res => {
                this.getAllReports()
            }).catch(err => {
            })
        },
        showReview(report){
            this.currentReport = report
            $('#showReviewModal').modal('show');
        },
        deleteReport(report){

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
                    this.deleting = report;
                    axios.post('/api/report/' + report.id + '/delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllReports();
                    }).catch( err => {
                        console.log(err)
                    })
                    }
                })
        },
        sortChange(val){
            console.log(val)
        }
    }
}
</script>
