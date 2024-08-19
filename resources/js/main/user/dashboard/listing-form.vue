<template>
  <div class="mz--dashboard dashboard-listing-form">
    <div class="container-fluid mt-4">
      <div class="row">


        <div
          class="col-12 col-sm-12 col-md-12 col-lg-12"
          :class="{
            'left-area':
              $store.getters.getCurrentLocale &&
              $store.getters.getCurrentLocale == 'ar',
            'right-area':
              !$store.getters.getCurrentLocale ||
              $store.getters.getCurrentLocale == 'en',
          }"
        >
          <div class="smz-box">
            <div class="smz-box-title-with-border" v-if="current_ad">
              {{ trans._getMessage("Edit Listings") }}
            </div>
            <div class="smz-box-title-with-border" v-else>
              {{ trans._getMessage("Add Listings") }}
            </div>


            <div class="ad-form position-relative">
              <div class="row">
                <div class="steps">
                  <div class="step step1" :class="{ active: step == 1 }">
                    <span class="icon" @click="changeStep(1)"
                      ><i class="fas fa-list"></i
                    ></span>
                    <div class="bar"></div>
                    <span class="name">{{ trans._getMessage("Details") }}</span>
                  </div>
                  <div class="step step2" :class="{ active: step == 2 }">
                    <span class="icon" @click="changeStep(2)"
                      ><i class="fas fa-images"></i
                    ></span>
                    <div class="bar"></div>
                    <span class="name">{{ trans._getMessage("Images") }}</span>
                  </div>
                  <div class="step step3" :class="{ active: step == 3 }">
                    <span class="icon" @click="changeStep(3)"
                      ><i class="fas fa-check"></i
                    ></span>
                    <div class="bar"></div>
                    <span class="name mr-1">{{
                      trans._getMessage("Finish")
                    }}</span>
                  </div>
                </div>

                <!-- @include('layouts.partials.swals') -->

                <div
                  v-show="step == 1"
                  class="col-md-12 position-relative"
                  style="padding: 10px"
                >
                  <loader v-if="loadingAd" :small="false"></loader>
                  <div class="">
                    <!-- /.card-header -->
                    <div>
                      <form @submit.prevent="handleSubmit">
                        <div class="row">
                          <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                            <div class="form-group">
                              <label for="name" class="col-form-label"
                                >{{ trans._getMessage("Title") }}:</label
                              >
                              <input
                                type="text"
                                class="form-control"
                                id="name"
                                :placeholder="trans._getMessage('Title')"
                                v-model="ad.title"
                                required
                              />
                            </div>

                            <div class="form-group">
                              <label for="ar_name" class="col-form-label"
                                >{{ trans._getMessage("Arabic Title") }}:</label
                              >
                              <input
                                type="text"
                                class="form-control"
                                id="ar_name"
                                :placeholder="trans._getMessage('Arabic Title')"
                                v-model="ad.ar_title"
                                required
                              />
                            </div>

                            <div class="form-group">
                              <label for="description" class="col-form-label"
                                >{{ trans._getMessage("Description") }}:</label
                              >
                              <!-- <textarea class="textarea" name="description" id="description" placeholder="Description" rows="4" ></textarea> -->
                              <quill-editor
                                class="w-100"
                                ref="myQuillEditor"
                                required
                                :options="editorOption"
                                v-model="ad.description"
                                :dir="dir"
                              />
                            </div>

                            <div class="form-group">
                              <label for="description" class="col-form-label"
                                >{{
                                  trans._getMessage("Arabic Description")
                                }}:</label
                              >
                              <!-- <textarea class="textarea" name="description" id="description" placeholder="Description" rows="4" ></textarea> -->
                              <quill-editor
                                class="w-100"
                                ref="myQuillEditor"
                                required
                                :dir="dir"
                                :options="editorOption"
                                v-model="ad.ar_description"
                              />
                            </div>
                            <div class="row mt-2">
                              <div class="col-12 col-md-6">
                                <label>{{
                                  trans._getMessage("Phone Number")
                                }}</label>
                                <input
                                  required
                                  v-model="ad.phone"
                                  class="form-control"
                                  type="tel"
                                  :placeholder="
                                    trans._getMessage('Phone Number')
                                  "
                                />
                              </div>
                              <div class="col-12 col-md-6">
                                <label>{{
                                  trans._getMessage("Address")
                                }}</label>
                                <input
                                  class="form-control"
                                  v-model="ad.address"
                                  :placeholder="trans._getMessage('Location')"
                                />
                              </div>
                            </div>
                            <hr />
                          </div>

<!-- User Id By CodingEagle -->
<!-- <input type="hidden" :value="this.$route.query.user_id" name="user_id"/> -->
<!-- User Id By CodingEagle -->

                          <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="">
                              <label class="col-form-label">City:</label>
                              <v-select
                                v-model="ad.city"
                                placeholder="Select City"
                                :options="cities"
                                :clearable="false"
                              ></v-select>
                            </div>

                            <div class="">
                              <label class="col-form-label">Genre:</label>
                              <v-select
                                v-model="ad.genre"
                                placeholder="Select Genre"
                                :options="genres"
                                label="title"
                                :clearable="false"
                              ></v-select>
                            </div>

                            <div class="">
                              <label class="col-form-label">Categories:</label>
                              <v-select
                                @input="categoryChange"
                                v-model="ad.category"
                                placeholder="Select Category"
                                :options="categories"
                                :clearable="false"
                                label="title"
                              ></v-select>
                            </div>

                            <div class="">
                              <label class="col-form-label">Sub Categoy:</label>
                              <v-select
                                @input="subCategoryChange"
                                v-model="ad.sub_category"
                                placeholder="Select Sub Category"
                                :disabled="!ad.category"
                                :options="
                                  ad.category ? ad.category.sub_categories : []
                                "
                                :clearable="false"
                                class="muliple-select"
                                label="title"
                              ></v-select>
                            </div>

                            <div class="">
                              <label class="col-form-label"
                                >Sub Sub Categoy:</label
                              >
                              <!-- <multiselect
                        v-model="ad.sub_sub_categories"
                        :options="ad.sub_category ? ad.sub_category.sub_categories : []"
                        :disabled="!ad.sub_category"
                        track-by="title" label="title"
                        multiple
                    ></multiselect> -->

                              <!-- :options="ad.sub_category ? ad.sub_category.sub_categories : []" -->
                              <v-select
                                multiple
                                v-model="ad.sub_sub_categories"
                                placeholder="Select Sub Sub Category"
                                :options="
                                  ad.sub_category
                                    ? filterSelectedOptions(
                                        ad.sub_category.sub_categories,
                                        ad.sub_sub_categories
                                      )
                                    : []
                                "
                                :disabled="!ad.sub_category"
                                :clearable="false"
                                class="muliple-select"
                                label="title"
                                :closeOnSelect="false"
                              ></v-select>
                            </div>

                            <div class="">
                              <label class="col-form-label">Make:</label>
                              <v-select
                                v-model="ad.makes"
                                @input="makeChanged"
                                placeholder="Select Make"
                                :options="
                                  filterSelectedOptions(makes, ad.makes)
                                "
                                class="muliple-select"
                                :clearable="false"
                                label="title"
                                multiple
                              ></v-select>
                            </div>

                            <div class="">
                              <label class="col-form-label">Model:</label>
                              <v-select
                                class="muliple-select"
                                v-model="ad.models"
                                :disabled="ad.makes.length == 0"
                                placeholder="Select Model"
                                :clearable="false"
                                label="title"
                                multiple
                                :deselectFromDropdown="true"
                                :options="
                                  filterSelectedOptions(
                                    allSelectedModels,
                                    ad.models
                                  )
                                "
                              ></v-select>
                              <!-- :options="allSelectedModels" -->
                              <!-- :options="options.filter(o => selected.indexOf(o) < 0)" -->
                              <!-- :options="ad.makes.length ? ad.make.models : []" -->
                            </div>

                            <div class="">
                              <label class="col-form-label">Years:</label>
                              <div class="d-flex">
                                <v-select
                                  :clearable="false"
                                  class="me-2"
                                  placeholder="Select Year"
                                  v-model="ad.start_year"
                                  :options="yearList"
                                >
                                </v-select>

                                <v-select
                                  :clearable="false"
                                  v-model="ad.end_year"
                                  placeholder="Select Year"
                                  :options="yearList"
                                >
                                </v-select>
                                <!-- v-model="end_year" -->
                              </div>
                            </div>

                            <div class="">
                              <label class="col-form-label"
                                >Pricing Starts from:</label
                              >
                              <input
                                v-model="ad.price"
                                class="form-control"
                                placeholder="Pricing Starts from"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col-12">
                            <button
                              v-if="current_ad"
                              type="submit"
                              class="loading-btn btn btn-primary"
                              :class="{
                                'float-right': $store.getters.ltr,
                                'float-left': $store.getters.rtl,
                              }"
                            >
                              <b-spinner small v-if="loading"></b-spinner>
                              <i v-else class="fas fa-edit"></i>
                              {{ trans._getMessage("Update") }}
                            </button>

                            <button
                              v-else
                              type="submit"
                              class="loading-btn btn btn-success"
                              :class="{
                                'float-right': $store.getters.ltr,
                                'float-left': $store.getters.rtl,
                              }"
                            >
                              <b-spinner small v-if="loading"></b-spinner>
                              <i v-else class="fas fa-plus"></i>
                              {{ trans._getMessage("Create") }}
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="col-md-12" v-show="step == 2">
                  <Images
                    :photos="ad.images"
                    :listing_id="ad.id"
                    @next-step="changeStep(3)"
                    @uploading-status="uploadStatusUpdate"
                  ></Images>
                </div>

                <div v-show="step == 3" class="col-md-12" style="padding: 10px">
                  <div class="mt-5">
                    <div class="row">
                      <div class="col-12 text-center">
                        <button
                          @click="finishProduct"
                          :disabled="processing"
                          href="javascript:;"
                          class="btn btn-success"
                        >
                          <span v-if="!processing">
                            <i class="fas fa-rocket"></i>
                            {{ trans._getMessage("Finish") }}
                          </span>
                          <span v-if="processing"
                            ><loader></loader>
                            {{
                              trans._getMessage("Your File is being uploaded")
                            }}</span
                          >
                        </button>
                      </div>
                    </div>
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

export default {
  components: {
    Images,
    Uploader,
  },
  created() {
    this.getCategories();
    if (this.$route.params.listing_id) {
      // console.log(this.$route.params.listing_id)
      this.getCurrentListing();
    }
    // this.quill.root.setAttribute('data-placeholder', "Your new placeholder");
  },
  computed: {
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
    yearList(){
        let date = new Date();
        let year = date.getFullYear();
        let years = []
        for (let i = year - 20; i <= year + 1; i++) {
            years.push(i);
        }
        return years
    },
    allSelectedModels(){
        let allModels = []
        if(this.ad.makes && this.ad.makes.length){
            this.ad.makes.map( make => {
                allModels = [...allModels , ...make.models]
            } )
        }
        return allModels;
    }

  },
  props: {
    current_product: {
      type: Object,
      default: null,
    },
  },
  updated() {
    if (this.$store.getters.rtl) {
      this.dir = "rtl";
    }
    if (this.$store.getters.ltr) {
      this.dir = "ltr";
    }
  },
  data() {
    return {
      editorOption: {
        placeholder: this.trans._getMessage("Insert text here"),
      },
      step: 1,
      cities: [
        this.trans._getMessage("Abu Dhabi"),
        this.trans._getMessage("Al Ain"),
        this.trans._getMessage("Ajman"),
        this.trans._getMessage("Dubai"),
        this.trans._getMessage("Fujairah"),
        this.trans._getMessage("Sharjah"),
        this.trans._getMessage("Ras Al Khaimah"),
      ],
      colors: [
        this.trans._getMessage("Red"),
        this.trans._getMessage("Blue"),
        this.trans._getMessage("Black"),
        this.trans._getMessage("White"),
        this.trans._getMessage("Maroon"),
        this.trans._getMessage("Silver"),
        this.trans._getMessage("Grey"),
      ],
      dir: "ltr",
      current_ad: "",
      loading: false,
      loadingAd: false,
      processing: false,
      categories: [],
      category: "",
      makes: [],
      transmissions: [
        this.trans._getMessage("Automatic"),
        this.trans._getMessage("Manual"),
        this.trans._getMessage("Tiptronic"),
      ],
      genres: [],
      ad: {
        // user_id: this.$store.getters.isAuthenticated.id,
        user_id: this.$route.query.user_id,
        title: "",
        description: "",
        ar_title: "",
        ar_description: "",
        category: "",
        sub_category: "",
        sub_sub_categories: [],
        makes: [],
        models: [],
        city: "",
        _city: "",
        genre: "",
        price: "",
        phone: "",
        start_year: "",
        end_year: "",
        address: "",
        active: true,
        images: [],
      },
    };
  },
  methods: {
    filterSelectedOptions(array , items){
        if(array && array.length){
            if(items && items.length){
                let selectedIds = items.map(item => item.id);
                return array.filter(item => !selectedIds.includes(item.id))
            }
            return array;
        }
        return []
    },

    getCategories() {
      axios
        .post("/api/category/all-details")
        .then((res) => {
          // console.log(res)
          this.categories = res.data.categories;
          this.makes = res.data.makes;
          this.genres = res.data.genres;
          this.utilities = res.data.utilities;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getCurrentListing() {
      this.loadingAd = true;
      axios
        .post("/api/listing/" + this.$route.params.listing_id + "/show")
        .then((res) => {
          // console.log(res)

          this.loadingAd = false;
          this.current_ad = res.data.listing;
          this.ad = res.data.listing;
          // console.log(res.data.listing.attr.transmission)
          this.ad.attr.transmission = this.trans._getMessage(
            res.data.listing.attr.transmission
          );
          // this.ad.attr.transmission = this.trans._getMessage(res.data.listing.attr._transmission)

          this.ad.city = this.trans._getMessage(res.data.listing.city);
          this.ad.color = this.trans._getMessage(res.data.listing.color);

          // console.log(this.trans._getMessage(this.ad.attr._transmission) , this.trans._getMessage(res.data.listing.city) )

          this.categories.map((cat) => {
            if (cat.id == this.ad.category_id) {
              this.category = cat;
              console.log(cat, "category");
            }
          });

          if (!this.ad.delivery_options) {
            this.ad.delivery_options = [];
          }

          if (!this.ad.rental_includes) {
            this.ad.rental_includes = {
              limit: "",
              additional_charges: "",
              insurance: "",
            };
          }

          if (!this.ad.requirements) {
            this.ad.requirements = {
              age: "",
              deposit: "",
              accepted: "",
            };
          }

          if (!this.ad.extras) {
            this.ad.extras = {
              driver_insurance: "",
              excess_claim: "",
              toll_charges: "",
            };
          }

          // this.fillForm()
          // this.categoryChange(res.data.listing.category)
        })
        .catch((err) => {
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
          this.$toastr.error(this.trans._getMessage("No Ad Details"));
        }
      } else {
        this.step = step;
      }
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

        this.ad._city = this.trans._getMessage(
          this.ad.city,
          this.$store.getters.getCurrentLocale
        );

        // this.ad._city = this.trans._getMessage(this.ad.city , 'ar');
        axios
          .post("/api/listing/store", this.ad)
          .then((res) => {
            this.loading = false;
            this.processing = false;
            this.step = 2;
            this.ad.id = res.data.listing.id;
            this.current_ad = res.data.listing;
            this.$toastr.success(
              this.trans._getMessage("Listing Added Successfully")
            );
          })
          .catch((err) => {
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
        // this.ad.city = this.trans._getMessage(this.ad.city , 'en');

        this.ad._city = this.trans._getMessage(
          this.ad.city,
          this.$store.getters.getCurrentLocale
        );

        this.ad._color = this.trans._getMessage(
          this.ad.color,
          this.$store.getters.getCurrentLocale
        );

        this.ad.attr._transmission = this.trans._getMessage(
          this.ad.attr.transmission,
          this.$store.getters.getCurrentLocale
        );

        axios
          .post("/api/listing/" + this.ad.id + "/update", this.ad)
          .then((res) => {
            this.loading = false;
            this.processing = false;
            this.step = 2;
            this.$toastr.success(
              this.trans._getMessage("Product Updated Successfully")
            );
          })
          .catch((err) => {
            this.loading = false;
            this.processing = false;
            console.log(err);
          });
      }
    },
    finishProduct() {
      if (!this.processing) {
        // axios.post('/api/publish-product' , {
        //         product_id: this.current_ad.id,
        // }).then( res => {
        //     console.log(res)
        //     window.location = '/admin/listings';
        // }).catch( err => {
        //     console.log(err)
        //     this.$toastr.success('Unexpected Error Occured');
        // })
        this.$router.push("/seller/my-listings");
        // window.location = '/my-listings';
      }
    },
    subCategoryChange(subCategory) {
        this.ad.sub_sub_categories = [];
    },

    isValid() {
      if (!this.ad.title) {
        this.$toastr.error("Title is required");
        return false;
      } else if (!this.ad.category) {
        this.$toastr.error("Category is required");
        return false;
      } else if (!this.ad.sub_category) {
        this.$toastr.error("Sub Category is required");
        return false;
      } else if (!this.ad.genre) {
        this.$toastr.error("Genre is required");
        return false;
      } else if (!this.ad.sub_sub_categories.length) {
        this.$toastr.error("Select atleast one Sub Sub Category");
        return false;
      }
      //  else if (!this.ad.makes.length) {
      //   this.$toastr.error("Select atleast on make");
      //   return false;
      // } else if (!this.ad.models.length) {
      //   this.$toastr.error("Select atleast on model");
      //   return false;
      // }

      return true;
    },
    fillForm() {
      // this.current_ad
    },
    makeChanged(input) {
      this.ad.model = "";
    },
    categoryChange(category) {
      // console.log(category.features)
      this.features = category.features;
      this.category = category;
      this.ad.make = "";
      this.ad.model = "";
    },
    handleFeatures(attr) {
      if (this.ad.selected_features.includes(attr)) {
        this.ad.selected_features.splice(
          this.ad.selected_features.indexOf(attr),
          1
        );
      } else {
        this.ad.selected_features.push(attr);
      }
    },
    cityChanged(city) {
      console.log(city, this.trans._getMessage(city, "ar"));
    },
    transmissionChanged(transmission) {
      console.log(transmission, this.trans._getMessage(transmission, "ar"));
    },
  },
};
</script>


<style>
.v-select {
  width: 100%;
}
/* .vs__dropdown-toggle{ */
/* padding: 4px 0 4px !important; */
/* } */
/* .vs__search{
    padding: 4px 8px !important;
    margin: 3px 0 0 !important;
} */

.vs__selected-options {
  height: 31px;
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

.item-pill.selected {
  /* background-color: #f93154; */
  background-color: #26a69a !important;
  /* background-color: #00b74a; */
  color: white !important;
}

.item-pill:hover {
  border-color: #1266f1;
  background-color: #0062ff26;
  color: #1266f1;
}

/* .item-pill:hover{
    background-color: #26A69A;
    color: white;
} */
.item-pill {
  /* color: #f93154; */
  color: #26a69a;
  /* color: #00b74a; */
  /* border: 1px solid #f93154; */
  border: 1px solid #26a69a;
  /* border: 1px solid #00b74a; */
  background-color: #ffffff;
  padding: 1px 14px;
  border-radius: 50px;
  margin-right: 9px;
  cursor: pointer;
  margin-bottom: 9px;
  transition: all 0.1s ease-in-out;
}

.dashboard-listing-form .ad-form .vs__search {
  padding: 0px 8px !important;
}
.dashboard-listing-form .ad-form .vs__selected {
  margin: 0px 2px 0;
}
.dashboard-listing-form .ad-form .vs__dropdown-toggle {
  padding: 0 0 1px !important;
}
</style>
