<template>

<!-- sweetalert2
vue-toastr-2 -->
<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:30px" >
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">Manage Pages</h3>
                </div>
                <!-- /.card-header -->
                <div style="padding:30px" class="text-center table-wrapper" >
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th style="width: 190px" >Name</th>
                            <th>Content</th>
                            <th>Actions</th>
                        </tr>

                        <tr v-for="(page , index) in pages" :key="index">
                            <td> {{index + 1}} </td>
                            <td> {{page.name }} </td>
                            <td v-html="page.content ? page.content.substr(0 , 100) : ''" ></td>
                            <td>
                                <a href="javascript:;" @click="editPage(page)"> <i class="fas fa-edit"></i> </a>
                                <a href="javascript:;" class="text-success" @click="viewPageContent(page)"> <i class="fas fa-eye"></i> </a>
                                </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>



<div class="modal fade" id="pagesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Page</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
            <div class="form-group row">
                <div class="col-sm-2">
                <label for="inputEmail1" class="row float-right col-form-label ">Name:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" v-model="page.name" id="inputEmail1" placeholder="Name" name="name" required>
            </div>
          </div>
          
          <div class="form-group row">
                <div class="col-sm-2">
                <label for="inputEmail1" class="row float-right col-form-label ">Content:</label>
            </div>
            <div class="col-sm-8">
                <quill-editor
                    style="height: 100px;margin-bottom: 30px;" 
                    v-model="page.content"
                    >
                </quill-editor>
            </div>
          </div>
        </form>
        
        <div></div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="submit" class="btn btn-success" >
            <loader v-if="loading"></loader>
            <span v-else> <i class="fas fa-plus"></i> Create </span>
        </button> -->

        <m-button title="Update" icon="fas fa-edit" :loading="loading" color="btn-success" min_width="85px" min_heigt="37px" @action-button-clicked="updatePage"  ></m-button>
                
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="viewPagesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">View Page Content</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form>
            <div class="form-group row">
                <div class="col-10 offset-1">
                    {{  current_page.name}}
                </div>
          </div>
          
            <div class="form-group row">
                <div class="col-10 offset-1">
                    <div v-html="current_page.content"></div>
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
import button from '../partials/button.vue'
export default {
  components: { button },
    data(){
        return{
            loading: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            current_page: '',
            pages: [],
            page:{
                id: "",
                name: "",
                content: "",
            }
        }
    },
    mounted(){
        this.getAllPages();
    },
    methods:{

        getAllPages(){
            axios.post('/api/pages/all')
            .then( res => {
                // console.log(res)
                this.pages = res.data.pages;
            }).catch( err => {
                // console.log(err)
            })
        },        
        updatePage()
        {
            if(this.page.name){
                this.loading = true;
                
                axios.post('/api/pages/'+ this.page.id +'/update' , {
                    content: this.page.content
                })
                .then( res => {
                    this.loading = false;
                    this.getAllPages();
                    $('#pagesModal').modal('hide')

                }).catch(err => {
                    console.log(err)
                    this.loading = false;

                })

            }
        },
        editPage(page){
            // console.log(page)
            this.resetForm();
            this.editMode=  true;
            this.page.id = page.id;
            this.page.name = page.name;
            this.page.content = page.content;
            $('#pagesModal').modal('show')
        },

        viewPageContent(page){
            this.current_page = page
            $('#viewPagesModal').modal('show')
        },
            
        resetForm(){
            this.page.name = ''
            this.page.content = ''
        }


    }
}
</script>

<style>
</style>