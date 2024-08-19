<template>
    <div class="queries">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title">Manage Queries</h5>
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
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(query , index) in queries.data" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{query.name}} </td>
                            <td> {{query.email}} </td>
                            <td>
                                <span class="badge bg-danger" v-if="query.is_resolved == 0" >Pending</span>
                                <span class="badge bg-success" v-if="query.is_resolved == 1" >Resolved</span>
                            </td>
                            <td> {{query.create_date}} </td>
                            <td>
                                <a v-permission="'resolve query'" v-if="query.is_resolved == 0"  class="text-success me-2" title="Approve" href="javascript:;" @click="updateQueryStatus( 1 , query)">
                                <b-spinner small v-if="approving == query"></b-spinner>
                                <i class="fas fa-check" v-else></i></a>

                                <a class="text-success me-2" title="Approve" href="javascript:;" @click="showQuery(query)">
                                <i class="far fa-eye"></i></a>

                                <a query href="javascript:;" class="text-danger" @click="deleteQuery(query)"  :disabled="deleting == query" >
                                    <b-spinner small v-if="deleting == query"></b-spinner>
                                    <i v-else  class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- <ul>
                    <li v-for="post in laravelData.data" :key="post.id">{{ post.title }}</li>
                </ul> -->
                <pagination align="center" :data="queries" @pagination-change-page="getAllQueries"></pagination>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showQueryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showQueryModalCenterTitle">Show Query</h5>
        <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form>


            <div class="form-group row" v-if="currentQuery">

                <div class="col-6">{{currentQuery.name}}</div>
                <div class="col-6 text-end">
                    {{ currentQuery.create_date }}
                </div>
                <hr class="mt-2">
                <div class="col-12">

                    <div> {{currentQuery.message}} </div>
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
        this.getAllQueries();
    },
    data(){
        return{
            queries : [],
            deleting: "",
            approving: "",
            loading: false,
            currentQuery:"",
        }
    },
    methods:{
        getAllQueries(page = 1){
            this.loading = true
            axios.post('/api/get/all-queries?page=' + page)
            .then( res => {
                this.loading = false
                this.queries = res.data.queries
            }).catch(err => {
                this.loading = false

            })
        },
        updateQueryStatus( status , query){
            this.approving = query
            axios.post('/api/query/update-status' , {
                query_id : query.id,
                status: status
            }).then( res => {
                this.getAllQueries()
            }).catch(err => {
            })
        },
        showQuery(query){
            this.currentQuery = query
            $('#showQueryModal').modal('show');
        },
        deleteQuery(query){

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
                    this.deleting = query;
                    axios.post('/api/query/ ' + query.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.getAllQueries();
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
</style>

