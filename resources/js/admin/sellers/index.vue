<template>
  <div class="sellers">
    <div class="row">
      <div class="col-md-12" style="padding: 10px">
        <div class="card">
          <div class="card-header">
            <a
              class="btn btn-outline-success ms-2 btn-sm float-end"
              @click="openUserModal"
            >
              <i class="fas fa-plus"></i> Add Seller</a
            >

            <a
              class="btn btn-outline-primary ms-2 btn-sm float-end"
              data-mdb-toggle="collapse"
              href="#filtersCollapse"
              role="button"
              aria-expanded="false"
              aria-controls="filtersCollapse"
            >
              <i class="fas fa-sort-shapes-down-alt"></i>
              Filter</a
            >

            <h5 class="card-title">Manage Sellers</h5>
          </div>
          <!-- /.card-header -->
          <div
            class="collapse mt-3 container admin-filters"
            id="filtersCollapse"
          >
            <div class="row ps-3 pe-3">
              <div class="col-md-3 col-lg-3 col-sm-12 col-12 single-filte-item">
                <input
                  v-model="search.garage_name"
                  class="form-control"
                  placeholder="User Name"
                />
              </div>
              <div class="col-md-3 col-lg-3 col-sm-12 col-12 single-filte-item">
                <v-select
                  v-model="search.city"
                  placeholder="Select City"
                  :options="cities"
                ></v-select>
              </div>

              <div class="col-md-3 col-lg-3 col-sm-12 col-12 single-filte-item">
                <v-select
                  v-model="search.status"
                  placeholder="Select Status"
                  :options="['approved', 'pending', 'rejected']"
                ></v-select>
              </div>

              <div
                class="
                  col-md-3 col-lg-3 col-sm-12 col-12
                  text-center
                  single-filte-item
                "
              >
                <button
                  class="btn btn-sm btn-floating"
                  :class="{
                    'btn-black': search.sortBy == 'Asc',
                  }"
                  @click="sortFilter('Asc')"
                  data-mdb-toggle="tooltip"
                  title="Sort Oldest"
                >
                  <i class="fas fa-arrow-down"></i>
                </button>
                <button
                  class="btn btn-sm btn-floating"
                  :class="{
                    'btn-black': search.sortBy == 'Desc',
                  }"
                  @click="sortFilter('Desc')"
                  data-mdb-toggle="tooltip"
                  title="Sort Newest"
                >
                  <i class="fas fa-arrow-up"></i>
                </button>

                <button
                  type="button"
                  @click="initiateSearching"
                  class="btn btn-success btn-sm ms-2"
                >
                  <i class="fas fa-search"></i>
                </button>
                <button
                  type="button"
                  @click="clearSearch"
                  class="btn btn-outline-danger btn-sm ms-2"
                >
                  <i class="fas fa-times-circle"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body position-relative text-center">
            <loader v-if="loading"></loader>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Garage Name</th>
                  <th>Email</th>
                  <th>City</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Create Date</th>
                  <th>Files</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody v-if="sellers.data">
                <tr v-for="(user, index) in sellers.data" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ user.seller.garage_name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.seller.city }}</td>
                  <td>
                    <img
                      :src="'/storage/sellers/' + user.seller.logo"
                      v-if="user.seller.logo"
                      class="seller-logo"
                    />
                    <img
                      v-else
                      src="/images/profile-placeholder.jpg"
                      class="seller-logo"
                    />
                  </td>

                  <td>
                    <span
                      class="badge bg-danger"
                      v-if="user.status == 'pending'"
                      >Pending</span
                    >
                    <span
                      class="badge bg-success"
                      v-if="user.status == 'approved'"
                      >Approved</span
                    >
                    <span
                      class="badge bg-warning"
                      v-if="user.status == 'rejected'"
                      >Rejected</span
                    >
                  </td>
                  <td>{{ user.create_date }}</td>

                  <td>
                    <div class="dropdown">
                      <button
                        class="btn btn-sm btn-primary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-mdb-toggle="dropdown"
                        aria-expanded="false"
                        :disabled="
                          !user.seller.docs ||
                          (user.seller.docs && user.seller.docs.length == 0)
                        "
                      >
                        Documents ({{
                          user.seller.docs ? user.seller.docs.length : 0
                        }})
                      </button>
                      <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton"
                        v-if="user.seller.docs && user.seller.docs.length > 0"
                      >
                        <li>
                          <a
                            class="dropdown-item"
                            :href="'/api/download-seller-file/' + file"
                            v-for="(file, index) in user.seller.docs"
                            :key="index"
                            >{{ file }}</a
                          >
                        </li>
                      </ul>
                    </div>
                  </td>

                  <td>


                    <a
                      v-if="user.seller.about"
                      class="text-warning me-2"
                      title="View About"
                      href="javascript:;"
                      @click="viewAboutSeller(user)"
                    >
                      <i class="fas fa-eye"></i
                    ></a>

                    <template v-permission="'approve sellers'">
                      <a v-if="user.status == 'pending' || user.status == 'rejected'"  class="text-success me-2" title="Approve" href="javascript:;" @click="updateSellerStatus( 'approved' , 1 , user)">
                            <b-spinner small v-if="approving == user"></b-spinner>
                            <i class="fas fa-check" v-else></i>
                        </a>
                    </template>

                    <template v-permission="'reject sellers'">
                      <a
                        v-if="user.status == 'pending' || user.status == 'approved'"
                        class="text-danger me-2"
                        title="Reject"
                        href="javascript:;"
                        @click="updateSellerStatus('rejected', 0, user)"
                      >
                        <b-spinner small v-if="rejecting == user"></b-spinner>
                        <i class="fas fa-times" v-else></i>
                      </a>
                    </template>
                    <a
                      v-permission="'edit sellers'"
                      class="text-primary me-2"
                      title="View About"
                      href="javascript:;"
                      @click="editSeller(user)"
                    >
                      <i class="fas fa-edit"></i
                    ></a>

                    <a
                      v-permission="'delete sellers'"
                      href="javascript:;"
                      class="text-danger"
                      @click="deleteSeller(user)"
                      :disabled="deleting == user"
                    >
                      <b-spinner small v-if="deleting == user"></b-spinner>
                      <i v-else class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>

            <pagination
              align="center"
              :data="sellers"
              @pagination-change-page="getAllSellers"
            ></pagination>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="showReviewModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">
              View Seller
            </h5>
            <button
              type="button"
              class="close"
              data-mdb-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row" v-if="currentSeller">
                <div class="col-12 pb-4">
                  <div>{{ currentSeller.seller.about }}</div>
                </div>
                <hr/>
                <div class="col-12 pb-4">
                  <div>{{ currentSeller.seller.ar_about }}</div>
                </div>
              </div>
            </form>

            <div></div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="userModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-if="!editMode" id="userModal">
              Add Seller
            </h5>
            <h5 class="modal-title" v-if="editMode" id="userModal">
              Edit Seller
            </h5>
            <button
              type="button"
              class="btn-close"
              data-mdb-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body px-5">
            <form @submit.prevent="postGenre">

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >Garage Name:</label
                  >
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <input
                    type="text"
                    id="title"
                    placeholder="Garage Name"
                    class="form-control"
                    v-model="seller.garage_name"
                    name="name"
                    required
                  />
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >Arabic Garage Name:</label
                  >
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <input
                    type="text"
                    id="title"
                    placeholder="Arabic Garage Name"
                    class="form-control"
                    v-model="seller.ar_garage_name"
                    name="name"
                    required
                  />
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >Email:</label
                  >
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <input
                    type="email"
                    id="email"
                    placeholder="Email"
                    class="form-control"
                    v-model="seller.email"
                    :disabled="editMode"
                    name="email"
                    required
                  />
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >City:</label
                  >
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <v-select
                    v-model="seller.city"
                    placeholder="Select City"
                    :options="cities"
                  >
                  </v-select>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >About Business:</label
                  >
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <textarea
                    v-model="seller.about"
                    class="form-control"
                    placeholder="About Business"
                    rows="3"
                  ></textarea>
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >About Business Arabic:</label
                  >
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <textarea
                    v-model="seller.ar_about"
                    class="form-control"
                    placeholder="About Business Arabic"
                    rows="3"
                  ></textarea>
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >Phone:</label
                  >
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <input
                    type="tel"
                    id="phone"
                    placeholder="Phone"
                    class="form-control"
                    v-model="seller.phone"
                    name="phone"
                    required
                  />
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >Address:</label
                  >
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <input
                    type="text"
                    placeholder="Address (Google Map Link)"
                    class="form-control"
                    v-model="seller.address"
                  />
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                  <label for="title" class="row float-right col-form-label"
                    >Password:</label
                  >
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <input
                    type="password"
                    id="password"
                    placeholder="Password"
                    class="form-control"
                    v-model="seller.password"
                    name="password"
                    :required="!editMode"
                  />
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-12 col-md-2 col-lg-2">
                  <label
                    for="inputEmail1"
                    class="row float-right col-form-label"
                    >Image:</label
                  >
                </div>
                <div class="col-sm-12 col-12 col-md-2 col-lg-2">
                  <img
                    :src="newImageSrc ? newImageSrc : imagePlaceholder"
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

              <hr />
              <div class="form-group row mb-3">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 border-end">
                  <div
                    class="
                      align-items-center
                      flex-column
                      h-100
                      justify-content-center
                      nav nav-tabs
                      text-center
                    "
                    id="v-tabs-tab"
                    role="tablist"
                    aria-orientation="vertical"
                  >
                    <a
                      v-for="(tab, index) in tabs"
                      :key="index"
                      :class="{ active: tab.active }"
                      class="nav-link"
                      :id="`modal-tab-${index}`"
                      data-mdb-toggle="tab"
                      :href="`#modal-tabs-${index}`"
                      role="tab"
                      :aria-controls="`modal-tab-${index}`"
                      aria-selected="true"
                      @click="tab.active = true"
                      >{{ tab.text }} ({{ seller[tab.items].length }})
                    </a>
                  </div>
                  <!-- Tabs navs -->
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                  <!-- Tabs content -->
                  <div class="tab-content h-100" id="v-tabs-tabContent">
                    <!-- show active -->
                    <div
                      :class="{
                        'show active': tab.active,
                      }"
                      class="tab-pane fade h-100"
                      :id="`modal-tabs-${index}`"
                      role="tabpanel"
                      :aria-labelledby="`modal-tab-${index}`"
                      v-for="(tab, index) in tabs"
                      :key="index"
                    >
                      <Pills
                        :items="callData(tab.items)"
                        :label="tab.label"
                        selectAll
                        :variant="tab.variant"
                        v-model="seller[tab.items]"
                      ></Pills>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-mdb-dismiss="modal">
              Close
            </button>

            <button
              v-if="!editMode"
              @click="postUser"
              :disabled="loading || (!seller.email && !seller.password)"
              type="button"
              class="btn btn-success"
            >
              <b-spinner v-if="loading" small></b-spinner>
              <i v-else class="fas fa-plus"></i>
              Create
            </button>

            <button
              v-if="editMode"
              @click="updateUser"
              :disabled="loading || (!seller.email && !seller.password)"
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
import Pills from "../partials/pills.vue";

export default {
  components: { Pills },
  mounted() {
    this.getAllSellers();
    this.getCategories();
  },
  data() {
    return {
      sellers: {},
      deleting: "",
      approving: "",
      rejecting: "",
      currentSeller: "",
      loading: false,
      editMode: false,
      imagePlaceholder: "/img/no-image-found.jpg",
      newImageSrc: "",
      new_image: "",
      page: 1,
      categories: [],
      makes: [],
      genres: [],
      utilities: [],
      tabs: [
        {
          text: "Brands",
          active: true,
          items: "makes",
          variant: "orange",
        },
        {
          text: "Categories",
          active: false,
          items: "categories",
        },
        {
          text: "Sub Categories",
          active: false,
          items: "subCategories",
          label: "formattedTitle",
          variant: "green",
        },
        {
          text: "Sub Categories",
          active: false,
          items: "subSubCategories",
          variant: "blue",
        },
      ],
      seller: {
        id: "",
        user_id: "",
        garage_name: "",
        ar_garage_name: "",
        email: "",
        phone: "",
        address: "",
        city: "",
        about: "",
        ar_about: "",
        address: "",
        categories: [],
        makes: [],
        subCategories: [],
        subSubCategories: [],
      },
      cities: [
        "Abu Dhabi",
        "Al Ain",
        "Ajman",
        "Dubai",
        "Fujairah",
        "Sharjah",
        "Ras Al Khaimah",
      ],
      isSearching: false,
      search: {
        sortBy: "desc",
        garage_name: "",
        status: "",
        city: "",
      },
    };
  },
  computed: {
    subCategories() {
      let subCategories = [];
      if (this.categories && this.categories.length) {
        this.categories.map((cat) => {
          return (
            this.seller.categories.includes(cat.id) &&
            subCategories.push(...cat.sub_categories)
          );
        });
      }
      return subCategories;
    },
    subSubCategories() {
      let subSubCategories = [];
      if (this.subCategories && this.subCategories.length) {
        this.subCategories.map(
          (subCat) =>
            this.seller.subCategories.includes(subCat.id) &&
            subSubCategories.push(...subCat.sub_categories)
        );
      }
      return subSubCategories;
    },
  },
  watch:{
    subCategories(){
        let subCategoryIds = this.subCategories.map( item => item.id )
        this.seller.subCategories = this.seller.subCategories.filter(item => subCategoryIds.includes(item))
    },
    subSubCategories(){
        let subSubCategoryIds = this.subSubCategories.map( item => item.id )
        this.seller.subSubCategories = this.seller.subSubCategories.filter(item => subSubCategoryIds.includes(item))
    },
  },
  methods: {
    callData(property) {
      return this[property];
    },
    initiateSearching() {
      this.isSearching = true;
      this.sellers = {};
      this.getAllSellers(1);
    },
    searchSellers(page = 1) {
      this.page = page;
      this.loading = true;
      axios
        .post("/api/search-sellers?page=" + page, this.search)
        .then((res) => {
          this.loading = false;
          this.sellers = res.data.sellers;
        })
        .catch((err) => {
          this.loading = false;
        });
    },
    getAllSellers(page = 1) {
      this.loading = true;
      axios
        .post(`/api/get-sellers?page=${page}`, this.search)
        .then((res) => {
          this.loading = false;
          this.sellers = {
            ...res.data.sellers,
            data:res.data.sellers.data.map(it=>{
              if(!it?.seller?.garage_name || !it?.seller?.city){
                return {
                  ...it,
                  seller:{
                    ...it?.seller,
                    garage_name:it?.seller?.garage_name?it?.seller?.garage_name:"",
                    city:it?.seller?.city?it?.seller?.city:"",
                    docs:it?.seller?.docs?.split(",")
                  }
                }
              }
              return {
                ...it,
                seller:{
                  ...it?.seller,
                  docs:it?.seller?.docs?.split(",")
                }
              }
            })
          };
        })
        .catch((err) => {
          this.loading = false;
        });
    },
    getCategories() {
      axios
        .post("/api/category/all-details")
        .then((res) => {
          let categories = res.data.categories;
          this.categories = categories.map((cat) => {
            cat.sub_categories = cat.sub_categories.map((subCat) => {
              subCat.formattedTitle = `${subCat.title} (${cat.title})`;
              return subCat;
            });
            return cat;
          });
          this.makes = res.data.makes;
          this.genres = res.data.genres;
          this.utilities = res.data.utilities;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    deleteSeller(user) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleting = user;
          axios
            .post(`/api/seller/${user.id}/delete`)
            .then((res) => {
              this.getAllSellers();
            })
            .catch((err) => {
              console.log(err);
            });
        }
      });
    },
    updateSellerStatus(status, approved, user) {
      if (approved == 1) {
        this.approving = user;
      } else {
        this.rejecting = user;
      }
      axios
        .post("/api/update-seller-status", {
          user_id: user.id,
          status,
          approved,
        })
        .then((res) => {
          this.getAllSellers();
        })
        .catch((err) => {
          this.$toastr.error(err.response.data.message);
        });
    },
    sortFilter(sort) {
      this.search.sortBy = sort;
    },
    clearSearch() {
      this.search = {
        sortBy: "desc",
        garage_name: "",
        status: "",
        city: "",
      };
      const myCollapse = document.getElementById("filtersCollapse");
      const bsCollapse = new mdb.Collapse(myCollapse);
      bsCollapse.hide();
      this.isSearching = false;
      this.sellers = {};
      this.getAllSellers();
    },
    viewAboutSeller(user) {
      this.currentSeller = user;
      $("#showReviewModal").modal("show");
    },
    openUserModal() {
      this.clearForm();
      this.editMode = false;
      $("#userModal").modal("show");
    },
    postUser() {
      this.loading = true;
      // let seller = new FormData()
      // var file = this.new_image;
      var fd = new FormData();
      fd.append("email", this.seller.email);
      fd.append("password", this.seller.password);
      fd.append("phone", this.seller.phone);
      fd.append("city", this.seller.city);
      fd.append("garage_name", this.seller.garage_name);
      fd.append("ar_garage_name", this.seller.ar_garage_name);
      fd.append("about", this.seller.about);
      fd.append("ar_about", this.seller.ar_about);
      fd.append("image", this.new_image);
      fd.append("address", this.seller.address ?? '');
      fd.append("categories", this.seller.categories);
      fd.append("subCategories", this.seller.subCategories);
      fd.append("subSubCategories", this.seller.subSubCategories);
      fd.append("makes", this.seller.makes);
      axios
        .post("/api/create-seller", fd)
        .then((res) => {
          this.loading = false;
          this.getAllSellers();
          $("#userModal").modal("hide");
        })
        .catch((err) => {
          console.log(err.response);
          this.$toastr.error(err.response.data.message);
          this.loading = false;
        });
    },
    clearForm() {
      this.seller.id = "";
      this.seller.user_id = "";
      this.seller.garage_name = "";
      this.seller.ar_garage_name = "";
      this.seller.email = "";
      this.seller.phone = "";
      this.seller.city = "";
      this.seller.about = "";
      this.seller.ar_about = "";
      this.seller.password = "";
      this.seller.categories = [];
      this.seller.subCategories = [];
      this.seller.subSubCategories = [];
      this.seller.makes = [];
      this.newImageSrc = "";
      this.new_image = "";
    },
    editSeller(user) {
      console.log(user);
      this.editMode = true;
      this.seller.id = user.id;
      this.seller.user_id = user.id;
      this.seller.garage_name = user.seller.garage_name;
      this.seller.ar_garage_name = user.seller.ar_garage_name;
      this.seller.email = user.email;
      this.seller.phone = user.phone;
      this.seller.city = user.seller.city;
      this.seller.about = user.seller.about;
      this.seller.ar_about = user.seller.ar_about;
      this.seller.address = user.seller.address ?? '';
      this.seller.makes = user.pivots.makes;
      this.seller.categories = user.pivots.categories;
      this.seller.subCategories = user.pivots.subCategories;
      this.seller.subSubCategories = user.pivots.subSubCategories;
      this.seller.password = "";
      if (user.seller && user.seller.logo) {
        this.newImageSrc = "/storage/sellers/" + user.seller.logo;
      }
      $("#userModal").modal("show");
    },
    updateUser() {
      this.loading = true;
      var fd = new FormData();
      fd.append("user_id", this.seller.user_id);
      // fd.append('email', this.seller.email)
      fd.append("password", this.seller.password);
      fd.append("phone", this.seller.phone);
      fd.append("city", this.seller.city);
      fd.append("garage_name", this.seller.garage_name);
      fd.append("ar_garage_name", this.seller.ar_garage_name);
      fd.append("about", this.seller.about);
      fd.append("ar_about", this.seller.ar_about);
      fd.append("image", this.new_image);
      fd.append("address", this.seller.address ?? '');
      fd.append("categories", this.seller.categories);
      fd.append("subCategories", this.seller.subCategories);
      fd.append("subSubCategories", this.seller.subSubCategories);
      fd.append("makes", this.seller.makes);

      axios
        .post("/api/seller-update", fd)
        .then((res) => {
          this.loading = false;
          this.getAllSellers();
          $("#userModal").modal("hide");
        })
        .catch((err) => {
          console.log(err.response);
          this.$toastr.error(err.response.data.messsage);
          this.loading = false;
        });
    },
    selectImageDialog() {
      $("#category_image").click();
    },
    imageSelected(event) {
      let file = event.target.files[0];
      if (!file) return;
      // console.log(file)
      this.new_image = file;
      let src = URL.createObjectURL(file);
      this.newImageSrc = src;
    },
    categoryChange(category) {
      this.category = category;
      this.ad.sub_category = "";
      this.ad.sub_sub_categories = [];
    },
    subCategoryChange(subCategory) {
      this.ad.sub_sub_categories = [];
    },
    filterSelectedOptions(array, items) {
      if (array && array.length) {
        if (items && items.length) {
          let selectedIds = items.map((item) => item.id);
          return array.filter((item) => !selectedIds.includes(item.id));
        }
        return array;
      }
      return [];
    },
  },
};
</script>

<style>
.sellers .seller-logo {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 200%;
}
</style>
