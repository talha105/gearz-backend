<template>


<div class="variants">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <button v-permission="'create makes'" class="btn btn-primary btn-sm float-end" @click="showVariantModal"> <i class="fas fa-plus"></i> Create</button>
                    <button class="btn btn-outline-dark btn-sm float-end me-2" @click="$router.back()"> <i class="fas fa-arrow-left"></i> Back</button>
                    <h5 class="card-title"> {{model ? model.title : ''}} Year</h5>
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
                            <th>Years</th>
                            <th>Transmission</th>
                            <th>Image</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(variant , index) in variants" :key="index">
                                <td> {{index + 1}} </td>
                                <td> {{variant.title }} </td>
                                <td> {{variant.ar_title }} </td>
                                <td> {{`${variant.start_year}-${variant.end_year}` }} </td>
                                <td> {{ variant.transmissions.map(item => item.title).join(', ') }} </td>
                                <td>
                                    <img v-if="variant.image" :src="'/storage/variants/' + variant.image" class="category-image" />
                                    <img v-else src="/img/no-image-found.jpg" class="category-image" />
                                </td>

                                <td> {{ variant.create_date }} </td>
                                <td>

                                    <a v-permission="'edit makes'" href="javascript:;"  @click="editVariant(variant)" > <i class="fas fa-edit"></i> </a>
                                    <a v-permission="'delete makes'" href="javascript:;" class="text-danger" @click="deleteVariant(variant)"  :disabled="deleting == variant" >
                                        <b-spinner small v-if="deleting == variant"></b-spinner>
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
    id="variantModal"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if="!editMode" >Add Variant</h5>
        <h5 class="modal-title" v-if="editMode" >Edit Variant</h5>

        <button
          type="button"
          class="btn-close"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body px-5">
        <form @submit.prevent="postVariant" >

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <label for="title" class="row float-right col-form-label ">Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Title" class="form-control" v-model="variant.title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <label for="title" class="row float-right col-form-label ">Arabic Title:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="title" placeholder="Arabic Title" class="form-control" v-model="variant.ar_title" name="name" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <label for="title" class="row float-right col-form-label ">Select Transmission:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <Pills
                        :items="transmissions"
                        label="title"
                        v-model="variant.transmission_ids"
                        variant="blue"
                    ></Pills>
                    <!-- <v-select
                        placeholder="Start Transmission"
                        :options="transmissions"
                        :reduce="trans => trans.id"
                        label="title"
                        v-model="variant.transmission_id"
                        :clearable="false"
                    ></v-select> -->
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <label for="title" class="row float-right col-form-label ">Select Year Range:</label>
                </div>

                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <v-select
                        placeholder="Start Year"
                        :options="$root.yearList"
                        v-model="variant.start_year"
                        :clearable="false"
                    ></v-select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <v-select
                        placeholder="End Year"
                        :options="$root.yearList"
                        v-model="variant.end_year"
                        :clearable="false"
                    ></v-select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <label for="inputEmail1" class="row float-right col-form-label ">Image:</label>
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                    <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog" class="upload-category-image" />
                    <button class="btn btn-success btn-sm w-100 mt-2" type="button" @click="selectImageDialog" >Upload</button>
                    <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">Close</button>

        <button v-if="!editMode" @click="postVariant" :disabled="loading || !variant.title || !variant.start_year || !variant.end_year" type="button" class="btn btn-success">
            <b-spinner v-if="loading" small ></b-spinner>
            <i v-else class="fas fa-plus"></i>
        Create </button>

        <button v-if="editMode" @click="updateVariant" :disabled="loading || !variant.title || !variant.start_year || !variant.end_year" type="button" class="btn btn-primary">
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
import Pills from '../partials/pills.vue';
export default {
    data() {
        return {
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: "/img/no-image-found.jpg",
            newImageSrc: "",
            new_image: "",
            deleting: "",
            model: "",
            variants: [],
            transmissions: [],
            variant: {
                title: "",
                ar_title: "",
                start_year: "",
                end_year: "",
                transmission_ids: [],
                image: "",
            }
        };
    },
    mounted() {
        this.getVariant();
        this.getTransmissions();
    },
    methods: {
        getVariant() {
            this.loading_data = true;
            axios.post(`/api/model/${this.$route.params.model_id}/variants`)
                .then(res => {
                console.log(res);
                this.loading_data = false;
                this.variants = res.data.variants;
                this.model = res.data.model;
            }).catch(err => {
                this.loading_data = false;
                console.log(err);
            });
        },
        getTransmissions() {
            this.loading_data = true;
            axios.post(`/api/transmissions/all`)
                .then(res => {
                this.transmissions = res.data.transmissions;
            }).catch(err => {
                this.loading_data = false;
                console.log(err);
            });
        },
        showVariantModal() {
            this.resetForm();
            this.editMode = false;
            $("#variantModal").modal("show");
        },
        imageSelected(event) {
            let file = event.target.files[0];
            if (!file)
                return;
            // console.log(file)
            this.new_image = file;
            let src = URL.createObjectURL(file);
            this.newImageSrc = src;
        },
        selectImageDialog() {
            $("#category_image").click();
        },
        postVariant() {
            if (this.variant.title) {
                let file = this.new_image;
                this.loading = true;
                var fd = new FormData();
                fd.append("title", this.variant.title);
                fd.append("ar_title", this.variant.ar_title);
                fd.append("model_id", this.model.id);
                fd.append("start_year", this.variant.start_year);
                fd.append("end_year", this.variant.end_year);

                this.variant.transmission_ids.forEach((value) => {
                    fd.append("transmission_ids[]", value)
                })
                fd.append("image", file);
                axios.post("/api/variant/store", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    onUploadProgress: function (progressEvent) {
                    }.bind(this),
                })
                    .then(response => {
                    this.loading = false;
                    this.getVariant();
                    this.resetForm();
                    $("#variantModal").modal("hide");
                })
                    .catch(error => {
                    this.loading = false;
                });
            }
            else {
            }
        },
        updateVariant() {
            if (this.variant.title) {
                let file = this.new_image;
                this.loading = true;
                var fd = new FormData();
                fd.append("image", file);
                fd.append("title", this.variant.title);
                fd.append("ar_title", this.variant.ar_title);
                fd.append("start_year", this.variant.start_year);
                fd.append("end_year", this.variant.end_year);
                this.variant.transmission_ids.forEach((value) => {
                    fd.append("transmission_ids[]", value)
                })
                axios.post(`/api/variant/${this.variant.id}/update`, fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    onUploadProgress: function (progressEvent) {
                    }.bind(this),
                })
                    .then(response => {
                    this.loading = false;
                    this.getVariant();
                    this.resetForm();
                    $("#variantModal").modal("hide");
                })
                    .catch(error => {
                    this.loading = false;
                });
            }
        },
        editVariant(variant) {
            this.resetForm();
            this.editMode = true;
            this.variant.id = variant.id;
            this.variant.title = variant.title;
            this.variant.ar_title = variant.ar_title;
            this.variant.start_year = variant.start_year;
            this.variant.end_year = variant.end_year;
            this.variant.transmission_ids = variant.transmissions.map(item => item.id);
            if (variant.image) {
                this.newImageSrc = "/storage/variants/" + variant.image;
            }
            $("#variantModal").modal("show");
        },
        deleteVariant(variant) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleting = variant;
                    axios.post(`/api/variant/${variant.id}/delete`)
                        .then(res => {
                        this.deleting = "";
                        this.getVariant();
                    }).catch(err => {
                        this.deleting = "";
                        console.log(err);
                    });
                }
            });
        },
        resetForm() {
            this.variant.title = "";
            this.variant.ar_title = "";
            this.variant.image = "";
            this.variant.start_year = "";
            this.variant.end_year = "";
            this.variant.transmission_ids = []
            this.newImageSrc = "";
        }
    },
    components: { Pills }
}
</script>
<style>
.variants .vs__dropdown-menu{
    max-height: 200px !important;
}
</style>
