<template>
    <div class="categories">
        <div class="row">
            <div class="col-md-12" style="padding:10px">
                <div class="card ">
                    <div class="card-header">
                        <button
                            v-permission="'create categories'"
                            class="btn btn-primary btn-sm float-end"
                            @click="showCategoryModal"
                        >
                            <i class="fas fa-plus"></i>
                            Create
                        </button>
                        <h5 class="card-title">Manage Categories</h5>
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
                                <tr
                                    v-for="(category, index) in categories"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <router-link
                                            :to="
                                                '/admin/categories/' +
                                                    category.id +
                                                    '/sub-categories'
                                            "
                                            :title="
                                                'Show ' +
                                                    category.title +
                                                    ' Sub Categories'
                                            "
                                        >
                                            {{ category.title }}
                                        </router-link>
                                    </td>
                                    <td>{{ category.ar_title }}</td>
                                    <td>{{ category.description }}</td>
                                    <td>{{ category.ar_description }}</td>
                                    <td>
                                        <img
                                            v-if="category.image"
                                            :src="
                                                '/storage/categories/' +
                                                    category.image
                                            "
                                            class="category-image"
                                        />
                                        <img
                                            v-else
                                            src="/img/no-image-found.jpg"
                                            class="category-image"
                                        />
                                    </td>
                                    <td>{{ category.create_date }}</td>
                                    <td>
                                        <!-- <router-link :to="'/admin/categories/'+ category.id +'/features'"  :title="'Show ' + category.title + ' Features'" class="text-danger" >  <i class="fas fa-tasks"></i> </router-link> -->

                                        <a
                                            v-permission="'edit categories'"
                                            href="javascript:;"
                                            @click="editCategory(category)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a
                                            v-permission="'delete categories'"
                                            href="javascript:;"
                                            class="text-danger"
                                            @click="deleteCategory(category)"
                                            :disabled="deleting == category"
                                        >
                                            <b-spinner
                                                small
                                                v-if="deleting == category"
                                            ></b-spinner>
                                            <i
                                                v-else
                                                class="fas fa-trash-alt"
                                            ></i>
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
                        <h5
                            class="modal-title"
                            v-if="!editMode"
                            id="categoryModal"
                        >
                            Add Category
                        </h5>
                        <h5
                            class="modal-title"
                            v-if="editMode"
                            id="categoryModal"
                        >
                            Edit Category
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-mdb-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body px-5">
                        <form @submit.prevent="postCategory">
                            <div class="form-group row mb-3">
                                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                    <label
                                        for="title"
                                        class="row float-right col-form-label "
                                        >Title:</label
                                    >
                                </div>

                                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                    <input
                                        type="text"
                                        id="title"
                                        placeholder="Title"
                                        class="form-control"
                                        v-model="category.title"
                                        name="name"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                    <label
                                        for="title"
                                        class="row float-right col-form-label "
                                        >Arabic Title:</label
                                    >
                                </div>

                                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                    <input
                                        type="text"
                                        id="ar_title"
                                        placeholder="Aracic Title"
                                        class="form-control"
                                        v-model="category.ar_title"
                                        name="name"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                    <label
                                        for="description"
                                        class="row float-right col-form-label "
                                        >Description:</label
                                    >
                                </div>
                                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                    <textarea
                                        rows="5"
                                        class="form-control"
                                        id="description"
                                        v-model="category.description"
                                        placeholder="Description of category"
                                    ></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                    <label
                                        for="description"
                                        class="row float-right col-form-label "
                                        >Arabic Description:</label
                                    >
                                </div>
                                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                    <textarea
                                        rows="5"
                                        class="form-control"
                                        id="description"
                                        v-model="category.ar_description"
                                        placeholder="Arabic Description of category"
                                    ></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <label
                                        for="inputEmail1"
                                        class="row float-right col-form-label "
                                        >Image:</label
                                    >
                                </div>
                                <div class="col-sm-8 col-md-2 col-lg-2">
                                    <img
                                        :src="
                                            newImageSrc
                                                ? newImageSrc
                                                : imagePlaceholder
                                        "
                                        @click="selectImageDialog"
                                        class="upload-category-image"
                                    />
                                    <button
                                        class="btn btn-success btn-sm w-100 mt-2"
                                        type="button"
                                        @click="selectImageDialog"
                                    >
                                        Upload
                                    </button>
                                    <input
                                        type="file"
                                        @change="imageSelected"
                                        ref="category_image"
                                        id="category_image"
                                        class="d-none"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-dark"
                            data-mdb-dismiss="modal"
                        >
                            Close
                        </button>

                        <button
                            v-if="!editMode"
                            @click="postCategory"
                            :disabled="loading || !category.title"
                            type="button"
                            class="btn btn-success"
                        >
                            <b-spinner v-if="loading" small></b-spinner>
                            <i v-else class="fas fa-plus"></i>
                            Create
                        </button>

                        <button
                            v-if="editMode"
                            @click="updateCategory"
                            :disabled="loading || !category.title"
                            type="button"
                            class="btn btn-primary"
                        >
                            <b-spinner v-if="loading" small></b-spinner>
                            <i v-else class="fas fa-edit"></i>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import button from "../partials/button.vue";
export default {
    components: { button },
    data() {
        return {
            loading: false,
            loading_data: false,
            editMode: false,
            imagePlaceholder: "/img/no-image-found.jpg",
            newImageSrc: "",
            new_image: "",
            deleting: "",
            categories: [],
            category: {
                title: "",
                ar_title: "",
                description: "",
                ar_description: "",
                image: "",
                has_modal: ""
            }
        };
    },
    mounted() {
        this.getAllCategories();
    },
    methods: {
        getAllCategories() {
            this.loading_data = true;
            axios
                .post("/api/category/all")
                .then(res => {
                    console.log(res);
                    this.loading_data = false;
                    this.categories = res.data.categories;
                })
                .catch(err => {
                    this.loading_data = false;
                    console.log(err);
                });
        },

        openSubcatgeories(category) {
            // this.$router.push({ name: "sub-categories", params: {category}} );
            this.$router.push({
                path: "/admin/category/" + category.id + "/sub-categories",
                params: { category }
            });
        },

        openFeatures(category) {
            // admin/category/:cat_id/features
            this.$router.push({
                path: "/admin/category/" + category.id + "/features",
                params: { category }
            });
        },

        showCategoryModal() {
            this.resetForm();
            this.editMode = false;
            $("#categoryModal").modal("show");
        },
        imageSelected(event) {
            let file = event.target.files[0];
            if (!file) return;
            // console.log(file)
            this.new_image = file;
            let src = URL.createObjectURL(file);
            this.newImageSrc = src;
        },

        selectImageDialog() {
            $("#category_image").click();
        },
        postCategory() {
            if (this.category.title) {
                let file = this.new_image;
                this.loading = true;
                var fd = new FormData();
                fd.append("image", file);
                fd.append("title", this.category.title);
                fd.append("ar_title", this.category.ar_title);
                fd.append("description", this.category.description);
                fd.append("ar_description", this.category.ar_description);

                axios
                    .post("/api/category/store", fd, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        },
                        onUploadProgress: function(progressEvent) {}.bind(this)
                    })
                    .then(response => {
                        this.loading = false;
                        this.getAllCategories();
                        this.resetForm();
                        $("#categoryModal").modal("hide");
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            } else {
            }
        },

        updateCategory() {
            if (this.category.title) {
                let file = this.new_image;
                this.loading = true;
                var fd = new FormData();
                fd.append("image", file);
                fd.append("title", this.category.title);
                fd.append("ar_title", this.category.ar_title);
                fd.append("description", this.category.description);
                fd.append("ar_description", this.category.ar_description);
                fd.append("has_modal", this.category.has_modal ? 1 : 0);

                axios
                    .post("/api/category/" + this.category.id + "/update", fd, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        },
                        onUploadProgress: function(progressEvent) {}.bind(this)
                    })
                    .then(response => {
                        this.loading = false;
                        this.getAllCategories();
                        this.resetForm();
                        $("#categoryModal").modal("hide");
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            }
        },
        editCategory(category) {
            console.log(category);
            this.resetForm();
            this.editMode = true;
            this.category.id = category.id;
            this.category.title = category.title;
            this.category.ar_title = category.ar_title;
            this.category.has_modal = category.has_modal;
            this.category.description =
                category.description && category.description != "null"
                    ? category.description
                    : "";
            this.category.ar_description =
                category.ar_description && category.ar_description != "null"
                    ? category.ar_description
                    : "";
            if (category.image) {
                this.newImageSrc = "/storage/categories/" + category.image;
            }
            $("#categoryModal").modal("show");
        },
        deleteCategory(category) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.isConfirmed) {
                    this.deleting = category;
                    axios
                        .post("/api/category/ " + category.id + " /delete")
                        .then(res => {
                            // console.log(res)
                            this.getAllCategories();
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
            });
        },

        resetForm() {
            this.category.title = "";
            this.category.ar_title = "";
            this.category.description = "";
            this.category.ar_description = "";
            this.category.image = "";
            this.category.has_modal = "";
            this.newImageSrc = "";
        }
    }
};
</script>
