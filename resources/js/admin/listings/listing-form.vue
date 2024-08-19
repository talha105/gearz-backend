<template>
    <div class="ad-form position-relative">
        <div class="row">
            <div class="steps">
                <div class="step step1" :class="{ active: step == 1 }">
                    <span class="icon" @click="changeStep(1)"
                        ><i class="fas fa-list"></i
                    ></span>
                    <div class="bar"></div>
                    <span class="name">Details</span>
                </div>
                <div class="step step2" :class="{ active: step == 2 }">
                    <span class="icon" @click="changeStep(2)"
                        ><i class="fas fa-images"></i
                    ></span>
                    <div class="bar"></div>
                    <span class="name">Images</span>
                </div>
                <div class="step step3" :class="{ active: step == 3 }">
                    <span class="icon" @click="changeStep(3)"
                        ><i class="fas fa-check"></i
                    ></span>
                    <div class="bar"></div>
                    <span class="name mr-1">Finish</span>
                </div>
            </div>

            <!-- @include('layouts.partials.swals') -->

            <div
                v-show="step == 1"
                class="col-md-12 position-relative"
                style="padding: 10px"
            >
                <loader v-if="loadingAd" :small="false"></loader>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Post Ad</h5>
                    </div>
                    <!-- /.card-header -->
                    <div style="padding: 20px">
                        <form @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label"
                                            >Title:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Title"
                                            v-model="ad.title"
                                            required
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-form-label"
                                            >Arabic Title:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Arabic Title"
                                            v-model="ad.ar_title"
                                        />
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="description"
                                            class="col-form-label"
                                            >Description:</label
                                        >
                                        <!-- <textarea class="textarea" name="description" id="description" placeholder="Description" rows="4" ></textarea> -->
                                        <quill-editor
                                            class="w-100"
                                            ref="myQuillEditor"
                                            required
                                            v-model="ad.description"
                                        />
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="ar_description"
                                            class="col-form-label"
                                            >Arabic Description:</label
                                        >
                                        <!-- <textarea class="textarea" name="description" id="description" placeholder="Description" rows="4" ></textarea> -->
                                        <quill-editor
                                            class="w-100"
                                            ref="myQuillEditor"
                                            required
                                            v-model="ad.ar_description"
                                        />
                                    </div>

                                    <div class="row mt-2">
                                        <div
                                            class="col-12 col-sm-12 col-md-6 col-lg-6"
                                        >
                                            <label>Phone Number</label>
                                            <input
                                                required
                                                v-model="ad.phone"
                                                class="form-control"
                                                type="tel"
                                                placeholder="Phone Number"
                                            />
                                        </div>
                                        <div
                                            class="col-12 col-sm-12 col-md-6 col-lg-6"
                                        >
                                            <label>Address</label>
                                            <input
                                                class="form-control"
                                                v-model="ad.address"
                                                placeholder="Location"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                    <Sidebar
                                        :ad="ad"
                                        @city-changed="ad.city = $event"
                                        @seller-changed="sellerChanged"
                                        @genres-changed="ad.genres = $event"
                                        @makes-changed="ad.makes = $event"
                                        @models-changed="ad.models = $event"
                                        @variants-changed="ad.variants = $event"
                                        @categories-changed="ad.categories = $event"
                                        @sub-categories-changed="ad.subCategories = $event"
                                        @sub-sub-categories-changed="ad.subSubCategories = $event"
                                        @start-year="ad.start_year = $event"
                                        @end-year="ad.end_year = $event"
                                        @price-changed="ad.price = $event"
                                    />
                                </div>
                            </div>
                            <hr style="margin-top:23px" />
                            <div class="row">
                                <div class="mt-4">
                                    <div class="col-12">
                                        <button
                                            v-if="current_ad"
                                            type="submit"
                                            class="loading-btn btn btn-primary float-end"
                                        >
                                            <b-spinner
                                                small
                                                v-if="loading"
                                            ></b-spinner>
                                            <i v-else class="fas fa-edit"></i>
                                            Update
                                        </button>

                                        <button
                                            v-else
                                            type="submit"
                                            class="loading-btn btn btn-success float-end"
                                        >
                                            <b-spinner
                                                small
                                                v-if="loading"
                                            ></b-spinner>
                                            <i v-else class="fas fa-plus"></i>
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding: 30px" v-show="step == 2">
                <Images
                    :photos="ad.images"
                    :listing_id="ad.id"
                    @next-step="changeStep(3)"
                    @uploading-status="uploadStatusUpdate"
                ></Images>
            </div>

            <div v-show="step == 3" class="col-md-12" style="padding: 10px">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Finish</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <a
                                    @click="finishProduct"
                                    :disabled="processing"
                                    href="javascript:;"
                                    class="btn btn-success"
                                >
                                    <span v-if="!processing">
                                        <i class="fas fa-rocket"></i> Finish
                                    </span>
                                    <span v-if="processing"
                                        ><loader></loader> Your File is being
                                        uploaded</span
                                    >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.flash-message {
    z-index: 1035;
}
._vue-flash-msg-wrapper ._vue-flash-msg-body__title {
    margin-bottom: 0;
}
._vue-flash-msg-wrapper ._vue-flash-msg-body__text {
    margin-bottom: 0;
}
</style>

<script>
import Images from "./product/images.vue";
import Uploader from "./product/file-upload.vue";
import Sidebar from "./product/sidebar.vue";

export default {
    components: {
        Images,
        Uploader,
        Sidebar
    },
    mounted() {
        if (this.$route.params.listing_id) {
            // console.log(this.$route.params.listing_id)
            this.getCurrentListing();
        }
    },
    props: {
        current_product: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            step: 1,
            current_ad: "",
            loading: false,
            loadingAd: false,
            processing: false,
            ad: {
                is_admin: true,
                user_id: "",
                title: "",
                status: "approved",
                description: "",
                ar_title: "",
                ar_description: "",
                categories: [],
                genres: [],
                subCategories: [],
                subSubCategories: [],
                makes: [],
                models: [],
                variants: [],
                city: "",
                price: "",
                phone: "",
                start_year: "",
                end_year: "",
                address: "",
                active: true,
                images: []
            }
        };
    },

    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill;
        }
    },

    methods: {
        getCurrentListing() {
            this.loadingAd = true;
            let { listing_id } = this.$route.params;
            axios
                .post(`/api/listing/${listing_id}/show`)
                .then(res => {
                    this.loadingAd = false;
                    this.current_ad = res.data.listing;
                    this.ad = { ...res.data.listing, ...res.data.listing.relation_pivots}
                    this.ad.is_admin = true;
                    if (this.ad.user_id) {
                        this.ad.user_id = parseInt(this.ad.user_id);
                    }
                })
                .catch(err => {
                    this.loadingAd = false;
                    console.log(err);
                });
        },
        uploadStatusUpdate($status) {
            console.log($status);
            this.processing = $status;
        },
        changeStep(step) {
            console.log(step);
            if (step > 1) {
                if (this.current_ad) {
                    this.step = step;
                } else {
                    this.$toastr.error("No Ad Details");
                }
            } else {
                this.step = step;
            }
        },

        getListingImages() {
            console.log("Fetch Listing Image");
            axios
                .post(`/api/listing/${this.ad.id}/images`)
                .then(res => {
                    console.log("res", res.data.images);
                    this.ad.images = res.data.images;
                })
                .catch(err => console.log("err", err));
        },
        handleSubmit() {
            if (this.current_ad) {
                this.updateProduct();
            } else {
                this.createProduct();
            }
        },
        createProduct() {
            if (this.isValid()) {
                this.loading = true;
                this.processing = true;

                axios
                    .post("/api/listing/store", this.ad)
                    .then(res => {
                        this.loading = false;
                        this.processing = false;
                        this.ad.id = res.data.listing.id;
                        this.current_ad = res.data.listing;
                        this.getListingImages();
                        this.step = 2;
                        this.$toastr.success("Listing Added Successfully");
                    })
                    .catch(err => {
                        this.loading = false;
                        this.processing = false;
                        console.log(err);
                    });
            }
        },
        updateProduct() {
            if (this.isValid()) {
                this.loading = true;
                this.processing = true;

                axios
                    .post(`/api/listing/${this.ad.id}/update`, this.ad)
                    .then(res => {
                        this.loading = false;
                        this.processing = false;
                        this.step = 2;
                        this.$toastr.success("Listing Updated Successfully");
                    })
                    .catch(err => {
                        this.loading = false;
                        this.processing = false;
                        console.log(err);
                    });
            }
        },
        finishProduct() {
            if (!this.processing) {
                window.location = "/admin/listings";
            }
        },
        isValid() {
            if (!this.ad.title) {
                this.$toastr.error("Title is required");
                return false;
            } else if (!this.ad.categories.length) {
                this.$toastr.error("Select atleast one Category");
                return false;
            } else if (!this.ad.subCategories.length) {
                this.$toastr.error("Select atleast one Sub Category");
                return false;
            } else if (!this.ad.genres.length) {
                this.$toastr.error("Select atleast one Genre");
                return false;
            } else if (!this.ad.subSubCategories.length) {
                this.$toastr.error("Select atleast one Sub Sub Category");
                return false;
            } else if (!this.ad.makes.length) {
                this.$toastr.error("Select atleast on make");
                return false;
            } else if (!this.ad.models.length) {
                this.$toastr.error("Select atleast on model");
                return false;
            }

            return true;
        },
        sellerChanged(seller) {
            this.ad.user_id = seller.id;
            this.ad.phone = seller.phone;
            this.ad.city = seller.seller.city;
            this.ad.address = seller.seller.address;
        }
    }
};
</script>

<style>
.v-select {
    width: 100%;
}

.vs__selected-options {
    min-height: 31px;
    height: auto;
}
.muliple-select .vs__selected-options {
    padding-bottom: 2px;
}

.ql-container {
    height: 177px;
    border-radius: 3px;
}

.check-box-container label {
    margin-right: 8px;
    margin-bottom: 8px;
}
.check-box-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

.ad-form .vs__search {
    padding: 0px 8px !important;
}

.ad-form :not(.muliple-select) .vs__selected {
    margin: 0px 2px 0;
}

.ad-form .muliple-select .vs__selected {
    margin: 5px 2px 0 2px;
}

.ad-form .vs__dropdown-toggle {
    padding: 0 0 1px;
}
.ad-form .delivery-pickup-area {
    margin-bottom: 10px;
    border-bottom: 1px solid #d8d8d8;
}

/* .ad-form .utilities{
    margin-top: 20px;
} */
.utilities .utility-items {
    border-top: 1px solid #d8d8d8;
    padding: 5px 0 0 10px;
    margin-top: 5px;
}
.utilities .utility-item:last-child {
    /* border: none; */
    margin-bottom: 15px;
}
.utilities .utility-item {
    border-bottom: 1px solid #d8d8d8;
    padding-bottom: 5px;
    margin-top: 5px;
}
.utilities .utility-item .utility-item-link {
    color: #515151;
}
</style>
