<template>


<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create categories'" class="btn btn-primary btn-sm float-end" @click="showCategoryModal"> <i class="fas fa-plus"></i> Create</button>
                    <button class="btn btn-outline-dark btn-sm float-end me-2" @click="$router.back()"> <i class="fas fa-arrow-left"></i> Back</button>
                    <h5 class="card-title"> {{subCategory ? subCategory.title : ''}} Sub Categories</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative table-wrapper">
                    <loader v-if="loading_data" :small="false"></loader>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Arabic Title</th>
                            <th style="width: 200px">Description</th>
                            <th style="width: 200px">Arabic Description</th>
                            <th>Image</th>
                            <th style="width: 115px">Create Date</th>
                            <th style="width: 100px">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(subSubCategory , index) in sub_categories" :key="index">
                                <td> {{index + 1}} </td>
                                <td> {{subSubCategory.title }} </td>
                                <td> {{subSubCategory.ar_title }} </td>
                                <td> {{subSubCategory.description }} </td>
                                <td> {{subSubCategory.ar_description }} </td>
                                <td>
                                    <img v-if="subSubCategory.image" :src="'/storage/sub-categories/' + subSubCategory.image" class="category-image" />
                                    <img v-else src="/img/no-image-found.jpg" class="category-image" />
                                </td>
                                <td> {{ subSubCategory.create_date }} </td>
                                <td>

                                    <a v-permission="'edit categories'" href="javascript:;"  @click="editCategory(subSubCategory)" > <i class="fas fa-edit"></i> </a>
                                    <a v-permission="'delete categories'" href="javascript:;" class="text-danger" @click="deleteCategory(subSubCategory)"  :disabled="deleting == subSubCategory" >
                                        <b-spinner small v-if="deleting == subSubCategory"></b-spinner>
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
  id="categoryModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" id="categoryModal">Add Sub Category</h5>
        <h5 class="modal-title" v-if="editMode" id="categoryModal">Edit Sub Category</h5>

        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postCategory" >

            <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="sub_category.title" name="name" required>
                </div>
            </div>


            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="ar_title" placeholder="Aracic Title" class="form-control" v-model="sub_category.ar_title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="description" class="row float-right col-form-label ">Description:</label>
                    </div>
                <div class="col-sm-8">
                    <textarea rows="5" class="form-control" id="description" v-model="sub_category.description" placeholder="Description of category"></textarea>
                </div>
          </div>

          <div class="form-group row mb-3">
                <div class="col-sm-2">
                    <label for="description" class="row float-right col-form-label ">Arabic Description:</label>
                    </div>
                <div class="col-sm-8">
                    <textarea rows="5" class="form-control" id="description" v-model="sub_category.ar_description" placeholder="Arabic Description of category"></textarea>
                </div>
          </div>

          <div class="form-group row">
                <div class="col-sm-2">
                <label for="inputEmail1" class="row float-right col-form-label ">Image:</label>
            </div>
            <div class="col-2">
                <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog" class="upload-category-image" />
                <button class="btn btn-success btn-sm w-100 mt-2" type="button" @click="selectImageDialog" >Upload</button>
                <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button> -->

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postCategory" :disabled="loading || !sub_category.title" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateCategory" :disabled="loading || !sub_category.title" type="button" class="btn btn-primary">
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
    props:{
        // category:{

        // }
    },
    data(){
        return{
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: '/img/no-image-found.jpg',
            newImageSrc: '',
            new_image: '',
            deleting: '',
            subCategory: '',
            sub_categories: [],
            sub_category:{
                title: "",
                ar_title: "",
                description: "",
                ar_description: "",
                image: "",
            }
        }
    },
    mounted(){
        // if(!this.category){
        //     this.$router.back();
        // }
        this.getSubCategories();
    },
    methods:{

        getSubCategories(){
            this.loading_data = true
            axios.post(`/api/sub-category/${this.$route.params.sub_id}/sub-sub-categories`)
            .then( res => {
                console.log(res)
                this.loading_data = false
                this.sub_categories = res.data.sub_categories;
                this.subCategory = res.data.sub_category;
            }).catch( err => {
                this.loading_data = false
                console.log(err)
            })
        },
        showCategoryModal(){
            this.resetForm();
            this.editMode=  false;
            $('#categoryModal').modal('show')
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
        postCategory()
        {
            if(this.sub_category.title){

            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.sub_category.title)
            fd.append('ar_title', this.sub_category.ar_title)
            fd.append('category_id', this.$route.params.cat_id)
            fd.append('sub_category_id', this.subCategory.id)
            fd.append('description', this.sub_category.description)
            fd.append('ar_description', this.sub_category.ar_description)

            axios.post('/api/sub-sub-category/store', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getSubCategories();
                this.resetForm();
                $('#categoryModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })

            }else{

            }
        },

        updateCategory()
        {
            if(this.sub_category.title){


            let file = this.new_image;
            this.loading = true;
            var fd = new FormData();
            fd.append('image', file)
            fd.append('title', this.sub_category.title)
            fd.append('description', this.sub_category.description)
            fd.append('ar_title', this.sub_category.ar_title)
            fd.append('ar_description', this.sub_category.ar_description)

            axios.post('/api/sub-sub-category/'+ this.sub_category.id +'/update', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
                this.getSubCategories();
                this.resetForm();
                $('#categoryModal').modal('hide')
            })
            .catch(error => {
                this.loading = false
            })
            }
        },
        editCategory(sub_category){
            console.log(sub_category)
            this.resetForm();
            this.editMode=  true;
            this.sub_category.id = sub_category.id;
            this.sub_category.title = sub_category.title;
            this.sub_category.ar_title = sub_category.ar_title;
            this.sub_category.description = sub_category.description;
            this.sub_category.ar_description = sub_category.ar_description;
            if(sub_category.image){
                this.newImageSrc = '/storage/sub-categories/' + sub_category.image
            }
            $('#categoryModal').modal('show')

        },
        deleteCategory(sub_category){

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

                    this.deleting = sub_category;
                    axios.post('/api/sub-category/ ' + sub_category.id + ' /delete')
                    .then( res => {
                        // console.log(res)
                        this.deleting = ''
                        this.getSubCategories();
                    }).catch( err => {

                        this.deleting = ''
                        console.log(err)
                    })
                    }
                })
        },

        resetForm(){
            this.sub_category.title = ''
            this.sub_category.ar_title = ''
            this.sub_category.description = ''
            this.sub_category.ar_description = ''
            this.sub_category.image = ''
            this.newImageSrc = ''
        }


    }
}
</script>
