<template>
<div class="ad-form position-relative">

    <div class="row" >
        <div class="steps" v-if="$store.getters.hasPermission('create listing')">
            <div class="step step1" :class="{active: step == 1}">
                <span class="icon" @click="changeStep(1)" ><i class="fas fa-list"></i></span>
                <div class="bar"></div>
                <span class="name">Details</span>
            </div>
            <div class="step step2" :class="{active: step == 2}">
                <span class="icon" @click="changeStep(2)"><i class="fas fa-images"></i></span>
                <div class="bar"></div>
                <span class="name">Images</span>
            </div>
            <div class="step step3" :class="{active: step == 3}">
                <span class="icon" @click="changeStep(3)" ><i class="fas fa-check"></i></span>
                <div class="bar"></div>
                <span class="name mr-1">Finish</span>
            </div>
        </div>


        <!-- @include('layouts.partials.swals') -->

        <div v-show="step == 1" class="col-md-12 position-relative" style="padding:10px" >
            <loader v-if="loadingAd" :small="false" ></loader>
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title">Post Ad</h5>
                </div>
                <!-- /.card-header -->
                <div style="padding:20px" v-if="$store.getters.hasPermission('create listing')" >
                    <form @submit.prevent="handleSubmit" >
                        <!-- @include('layouts.partials.form_errors') -->

                        <!-- @csrf -->

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-7 col-lg-7">

                                <div class="form-group">
                                    <label for="name" class="col-form-label ">Title:</label>
                                    <input type="text" class="form-control" id="name" placeholder="Title" v-model="ad.title" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label ">Arabic Title:</label>
                                    <input type="text" class="form-control" id="name" placeholder="Arabic Title" v-model="ad.ar_title" required>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-form-label ">Description:</label>
                                    <!-- <textarea class="textarea" name="description" id="description" placeholder="Description" rows="4" ></textarea> -->
                                    <quill-editor
                                        class="w-100"
                                        ref="myQuillEditor"
                                        required
                                        v-model="ad.description"
                                    />

                                </div>

                                <div class="form-group">
                                    <label for="ar_description" class="col-form-label ">Arabic Description:</label>
                                    <!-- <textarea class="textarea" name="description" id="description" placeholder="Description" rows="4" ></textarea> -->
                                    <quill-editor
                                        class="w-100"
                                        ref="myQuillEditor"
                                        required
                                        v-model="ad.ar_description"
                                    />

                                </div>
                                <div class="row mt-2">

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Phone Number</label>
                                        <input required v-model="ad.phone" class="form-control" type="tel" placeholder="Phone Number" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Address</label>
                                        <input class="form-control" v-model="ad.address" placeholder="Location" />
                                    </div>
                                </div>
                                <hr style="margin-top:23px">
                                <div class="row">
                                    <ul class="nav nav-tabs nav-justified mb-3" id="utility" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a
                                            class="nav-link active"
                                            id="c-u-tabs-1"
                                            data-mdb-toggle="tab"
                                            href="#u-tabs-1"
                                            role="tab"
                                            aria-controls="u-tabs-1"
                                            aria-selected="true"
                                            >Rental Includes</a
                                            >
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a
                                            class="nav-link"
                                            id="c-u-tabs-2"
                                            data-mdb-toggle="tab"
                                            href="#u-tabs-2"
                                            role="tab"
                                            aria-controls="u-tabs-3"
                                            aria-selected="false"
                                            >Requirements</a
                                            >
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a
                                            class="nav-link"
                                            id="c-u-tabs-3"
                                            data-mdb-toggle="tab"
                                            href="#u-tabs-3"
                                            role="tab"
                                            aria-controls="u-tabs-3"
                                            aria-selected="false"
                                            >Extras</a
                                            >
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="ex3-content">
                                        <div class="tab-pane fade show active" id="u-tabs-1" role="tabpanel" aria-labelledby="u-tabs-1" >
                                            <div class="row mt-2">
                                                <label class="col-5">Mileage Limits</label>
                                                <div class="col-7">
                                                    <input placeholder="Mileage Limits" class="form-control" v-model="ad.rental_includes.limit" />
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <label class="col-5">Additional Mileage Charge</label>
                                                <div class="col-7">
                                                    <input placeholder="Additional Mileage Charge" class="form-control" v-model="ad.rental_includes.additional_charges"  />
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <label class="col-5">Insurance</label>
                                                <div class="col-7">
                                                    <input placeholder="Insurance" class="form-control" v-model="ad.rental_includes.insurance" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="u-tabs-2"  role="tabpanel" aria-labelledby="u-tabs-2">
                                            <div class="row mt-2">
                                                <label class="col-5">Minimum Age</label>
                                                <div class="col-7">
                                                    <input placeholder="Minimum Age" class="form-control" v-model="ad.requirements.age"  />
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <label class="col-5">Security Deposit</label>
                                                <div class="col-7">
                                                    <input placeholder="Security Deposit" class="form-control"  v-model="ad.requirements.deposit" />
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <label class="col-5">Accepted in</label>
                                                <div class="col-7">
                                                    <input placeholder="Accepted in" class="form-control"  v-model="ad.requirements.accepted" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="u-tabs-3" role="tabpanel" aria-labelledby="u-tabs-3">
                                            <div class="row mt-2">
                                                <label class="col-5">Additional Driver Insurance</label>
                                                <div class="col-7">
                                                    <input placeholder="Additional Driver Insurance" class="form-control"   v-model="ad.extras.driver_insurance" />
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <label class="col-5">Excess Claim</label>
                                                <div class="col-7">
                                                    <input placeholder="Excess Claim" class="form-control" v-model="ad.extras.excess_claim" />
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <label class="col-5">Salik/Toll Charges</label>
                                                <div class="col-7">
                                                    <input placeholder="Salik/Toll Charges" class="form-control" v-model="ad.extras.toll_charges" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                                <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                    <div class="delivery-pickup-area">
                                        <label class="col-form-label">Delivery & Pickup</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="ad.delivery_options" :value="{ id : 1 , name :  'Branch Pickup' , image :'/img/building.png'}" id="Branch-Pickup" />
                                        <label class="form-check-label me-4" for="Branch-Pickup">
                                            Branch Pickup
                                        </label>
                                    </div>

                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" v-model="ad.delivery_options" :value="{ id : 2 , name :  'Delivery to You' , image :'/img/location.png'}" id="Delivery-to-You" />
                                        <label class="form-check-label me-4" for="Delivery-to-You">
                                            Delivery to You
                                        </label>
                                    </div>

                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" v-model="ad.delivery_options" :value="{ id : 3 , name :  'Airport Delivery' , image :'/img/plane.png'}" id="Airport-Delivery" />
                                        <label class="form-check-label me-4" for="Airport-Delivery">
                                            Airport Delivery
                                        </label>
                                    </div>

                                    <hr>

                                    <div class="">
                                        <label class="col-form-label ">Color:</label>
                                        <v-select v-model="ad.color" placeholder="Select Color" :options="colors" :clearable="false" ></v-select>
                                    </div>

                                    <div class="">
                                        <label class="col-form-label ">City:</label>
                                        <v-select v-model="ad.city" placeholder="Select City" :options="cities" :clearable="false" ></v-select>
                                    </div>

                                    <div class="">
                                        <label class="col-form-label ">Genre:</label>
                                        <v-select v-model="ad.genre" placeholder="Select Genre" :options="genres" label="title" :clearable="false" ></v-select>
                                    </div>
                                    <div class="">
                                        <label class="col-form-label ">Categories:</label>
                                        <v-select @input="categoryChange" v-model="ad.category" placeholder="Select Category" :options="categories" :clearable="false" label="title" ></v-select>
                                    </div>
                                    <div class="">
                                        <label class="col-form-label ">Make:</label>
                                        <v-select v-model="ad.make" @input="makeChanged" :disabled="!ad.category" placeholder="Select Make" :options="ad.category.makes" multiple :clearable="false" label="title" ></v-select>
                                    </div>

                                    <div class="" v-if="ad.category.has_modal">
                                        <label class="col-form-label ">Model:</label>
                                        <v-select v-model="ad.model" multiple :disabled="!ad.make" placeholder="Select Model" :options="ad.make.models" :clearable="false" label="title" ></v-select>
                                    </div>




                                    <!-- Tabs navs -->
                                    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a
                                        class="nav-link active"
                                        id="ex3-tab-1"
                                        data-mdb-toggle="tab"
                                        href="#ex3-tabs-1"
                                        role="tab"
                                        aria-controls="ex3-tabs-1"
                                        aria-selected="true"
                                        >Features</a
                                        >
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a
                                        class="nav-link"
                                        id="ex3-tab-2"
                                        data-mdb-toggle="tab"
                                        href="#ex3-tabs-2"
                                        role="tab"
                                        aria-controls="ex3-tabs-2"
                                        aria-selected="false"
                                        >Overview</a
                                        >
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a
                                        class="nav-link"
                                        id="ex3-tab-3"
                                        data-mdb-toggle="tab"
                                        href="#ex3-tabs-3"
                                        role="tab"
                                        aria-controls="ex3-tabs-3"
                                        aria-selected="false"
                                        >Prices</a
                                        >
                                    </li>
                                    </ul>
                                    <!-- Tabs navs -->

                                    <!-- Tabs content -->
                                    <div class="tab-content" id="ex2-content">
                                    <div
                                        class="tab-pane fade show active"
                                        id="ex3-tabs-1"
                                        role="tabpanel"
                                        aria-labelledby="ex3-tab-1"
                                    >


                                        <div class="check-box-container"  >
                                            <div class="item-pill" :class="{ 'selected' : ad.selected_features.includes(feature.id) }" @click="handleFeatures(feature.id)" v-for="( feature , index) in ad.category.features" :key="index"> {{feature.title}} </div>
                                        </div>

                                        <div v-if="ad.category && ad.category.features.length == 0" class="text-primary text-center" >No Features in Category</div>
                                        <div v-if="!ad.category" class="text-primary text-center" >No Category Selected</div>
                                    </div>
                                    <div
                                        class="tab-pane fade"
                                        id="ex3-tabs-2"
                                        role="tabpanel"
                                        aria-labelledby="ex3-tab-2"
                                    >
                                        <!-- <div class="form-check" v-for="index in 10" :key="index">
                                            <input type="checkbox" class="btn-check" :id="'attr-'+index" autocomplete="off" />
                                            <label class="btn btn-light" :for="'attr-'+index">Checkbox button</label>
                                        </div> -->

                                        <div class="row mt-2">
                                            <label class="col-4">No. of Seats</label>
                                            <div class="col-8">
                                                <input placeholder="Number of Seats" class="form-control" v-model="ad.attr.seats" />
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <label class="col-4">No. of Doors</label>
                                            <div class="col-8">
                                                <input placeholder="Number of Doors" class="form-control" v-model="ad.attr.doors" />
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <label class="col-4">Model Year</label>
                                            <div class="col-8">
                                                <v-select v-model="ad.attr.model" placeholder="Model Year" :options="years" :clearable="false" ></v-select>

                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <label class="col-4">Transmission</label>
                                            <div class="col-8">
                                                <v-select v-model="ad.attr.transmission" placeholder="Model Year" :options="['Automatic' , 'Manual' , 'Tiptronic']" :clearable="false" ></v-select>
                                            </div>
                                        </div>

                                    </div>
                                    <div
                                        class="tab-pane fade"
                                        id="ex3-tabs-3"
                                        role="tabpanel"
                                        aria-labelledby="ex3-tab-3"
                                    >
                                        <div class="row mt-2">
                                            <label class="col-3">Per Day</label>
                                            <div class="col-9">
                                                <input placeholder="Per Day" v-model="ad.day_price" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <label class="col-3">Per Week</label>
                                            <div class="col-9">
                                                <input placeholder="Per Week" v-model="ad.week_price" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <label class="col-3">Per Month</label>
                                            <div class="col-9">
                                                <input placeholder="Per Month" v-model="ad.month_price" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- <div class="form-group mt-2">
                                            <label>Per Months</label>
                                            <input placeholder="Per Months" class="form-control" />
                                        </div>
                                        <div class="form-group mt-2">
                                            <label>Per Year</label>
                                            <input placeholder="Per Year" class="form-control" />
                                        </div> -->
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="ad.active" value="1" id="is-active" />
                                        <label class="form-check-label me-4" for="is-active">
                                            Active
                                        </label>
                                    </div>
                                    </div>
                                    <!-- Tabs content -->


                                </div>

                            </div>

                        <div class="row">
                            <div class="mt-4">
                                <div class="col-12">

                                    <button v-if="current_ad" type="submit" class="loading-btn btn btn-primary float-end">

                                        <b-spinner small v-if="loading"></b-spinner>
                                        <i v-else class="fas fa-edit"></i> Update

                                    </button>

                                    <button v-else type="submit" class="loading-btn btn btn-success float-end">

                                        <b-spinner small v-if="loading"></b-spinner>
                                        <i v-else class="fas fa-plus"></i> Create

                                    </button>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div v-else class="alert alert-danger text-center mt-3"  >You are not Authorized for this page</div>
            </div>

        </div>

            <div class="col-md-12" style="padding:30px"  v-show="step == 2" >

                <Images
                    :photos="ad.images"
                    :listing_id="ad.id"
                    @next-step="changeStep(3)"
                    @uploading-status="uploadStatusUpdate"
                ></Images>
            </div>


        <div v-show="step == 3" class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title">Finish</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <a @click="finishProduct" :disabled="processing" href="javascript:;" class="btn btn-success">
                                <span v-if="!processing"> <i class="fas fa-rocket"></i>   Finish  </span>
                                <span v-if="processing" ><loader></loader> Your File is being uploaded</span>

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
    .flash-message{
        z-index: 1035;
    }
    ._vue-flash-msg-wrapper ._vue-flash-msg-body__title{
        margin-bottom: 0;
    }
    ._vue-flash-msg-wrapper ._vue-flash-msg-body__text{
        margin-bottom: 0;
    }

</style>

<script>
import Images from './product/images.vue'
import Uploader from './product/file-upload.vue'

export default{
    components:{
        Images,
        Uploader
    },
    created(){


        this.getCategories();
        if(this.$route.params.listing_id){
            // console.log(this.$route.params.listing_id)
            this.getCurrentListing();

        }
    },
    computed: {
      editor() {
        return this.$refs.myQuillEditor.quill
      }
    },
    props:{
        current_product:{
            type: Object,
            default: null,
        }
    },
    data(){
        return{
            step: 1,
            current_ad: '',
            loading: false,
            loadingAd: false,
            processing: false,
            categories: [],
            genres: [],
            utilities: [],
            category: '',
            features: [],
            cities:[
                'Abu Dhabi' ,
                'Al Ain' ,
                'Ajman' ,
                'Dubai' ,
                'Fujairah' ,
                'Sharjah' ,
                'Ras Al Khaimah'
            ],

            years: [ '2021' , '2020' , '2019' , '2018'],
            colors: [ 'Red' , 'Blue' , 'Black' , 'White' , 'Maroon' , 'Silver', 'Grey'],
            ad:{
                is_admin: true,
                title:"",
                status:"approved",
                description:"",
                ar_title:"",
                ar_description:"",
                phone:"",
                address:"",
                selected_features:[],
                delivery_options:[],
                images:[],
                category:"",
                make:"",
                color:"",
                _color:"",
                city:"",
                _city:"",
                model:"",
                genre:"",
                active:true,
                day_price:"",
                month_price:"",
                week_price:"",
                rental_includes:{
                    limit: "",
                    additional_charges: "",
                    insurance: "",
                },
                requirements:{
                    age: "",
                    deposit: "",
                    accepted: "",
                },
                extras:{
                    driver_insurance: "",
                    excess_claim: "",
                    toll_charges: "",
                },
                attr:{
                    transmission: "Automatic",
                    _transmission: "Automatic",
                    model: "2021",
                    doors: "",
                    seats: "",
                }
            }
        }
    },
    methods:{

        getCategories(){
            axios.post('/api/category/all-details')
            .then( res => {
                // console.log(res)
                this.categories = res.data.categories
                this.genres = res.data.genres
                this.utilities = res.data.utilities
            }).catch(err => {
                console.log(err)
            })
        },
        getCurrentListing(){
            this.loadingAd = true;
            axios.post('/api/listing/'+ this.$route.params.listing_id +'/show' )
            .then( res => {
                // console.log(res)

                this.loadingAd = false;
                this.current_ad = res.data.listing
                this.ad = res.data.listing

                this.categories.map( cat => {
                    if(cat.id == this.ad.category_id){
                        this.category = cat
                        console.log(cat , 'category')
                    }
                })

                if(!this.ad.delivery_options){
                    this.ad.delivery_options = []
                }
                if(!this.ad.rental_includes){
                    this.ad.rental_includes = {
                            limit: "",
                            additional_charges: "",
                            insurance: "",
                        }
                    }

                if(!this.ad.requirements){
                    this.ad.requirements = {
                        age: "",
                        deposit: "",
                        accepted: "",
                    }
                }

                if(!this.ad.extras){
                    this.ad.extras = {
                        driver_insurance: "",
                        excess_claim: "",
                        toll_charges: "",
                    }
                }

                // this.fillForm()
                // this.categoryChange(res.data.listing.category)
            }).catch(err => {
                this.loadingAd = false;
                console.log(err)
            })
        },
        uploadStatusUpdate($status){
            console.log($status)
            this.processing = $status
        },
        changeStep(step){
            console.log(step)
            if(step > 1){
                if(this.current_ad){
                    this.step = step;
                }else{
                    this.$toastr.error('No Ad Details');
                }
            }else{
                this.step = step;
            }
        },

        handleSubmit(){
            if(this.current_ad){
                this.updateProduct()
            }else{
                this.createProduct();
            }
        },
        createProduct(){

            if(this.isValid()){
                this.loading = true;
                this.processing = true;

                this.ad._city = this.ad.city
                this.ad._color = this.ad.color
                this.ad.attr._transmission = this.ad.attr.transmission

                axios.post('/api/listing/store',this.ad).then( res => {

                    this.loading = false;
                    this.processing = false;
                    this.step = 2
                    this.ad.id = res.data.listing.id
                    this.current_ad = res.data.listing
                    this.$toastr.success('Listing Added Successfully');


                } ).catch( err => {
                    this.loading = false;
                    this.processing = false;
                    console.log(err)
                })
            }
        },
        updateProduct(){
            if(this.isValid()){
                this.loading = true;
                this.processing = true;
                this.ad._city = this.ad.city
                this.ad._color = this.ad.color
                this.ad.attr._transmission = this.ad.attr.transmission

                axios.post('/api/listing/'+ this.ad.id+ '/update' , this.ad ).then( res => {

                    this.loading = false;
                    this.processing = false;
                    this.step = 2
                    this.$toastr.success('Product Updated Successfully');

                } ).catch( err => {
                    this.loading = false;
                    this.processing = false;
                    console.log(err)
                })
            }
        },
        finishProduct(){
            if(!this.processing){

            // axios.post('/api/publish-product' , {
            //         product_id: this.current_ad.id,
            // }).then( res => {
            //     console.log(res)
            //     window.location = '/admin/listings';
            // }).catch( err => {
            //     console.log(err)
            //     this.$toastr.success('Unexpected Error Occured');
            // })
                window.location = '/admin/listings';

            }
        },
        isValid(){
            if(!this.ad.title){
                this.$toastr.error('Title is required');
                return false
            }else if(!this.ad.category){
                this.$toastr.error('Category is required');
                return false
            }else if(!this.ad.genre){
                this.$toastr.error('Genre is required');
                return false
            }else if(!this.ad.make){
                this.$toastr.error('Make is required');
                return false
            }else if(!this.ad.attr.seats){
                this.$toastr.error('Number of Seats is required');
                return false
            }else if(!this.ad.attr.doors){
                this.$toastr.error('Number of Doors is required');
                return false
            }else if(!this.ad.day_price){
                this.$toastr.error('Per Day Price is required');
                return false
            }else if(!this.ad.color){
                this.$toastr.error('Color is required');
                return false
            }

            return true
        },
        fillForm(){
            // this.current_ad
        },
        makeChanged(input){
            this.ad.model = ''
        },
        categoryChange(category){
            // console.log(category.features)
            this.features = category.features
            this.category = category
            this.ad.make = ''
            this.ad.model = ''

        },
        handleFeatures(attr){
            if(this.ad.selected_features.includes(attr)){
                this.ad.selected_features.splice( this.ad.selected_features.indexOf(attr) , 1)
            }else{
                this.ad.selected_features.push(attr)
            }
        },

    }
}
</script>


<style>
.v-select{
    width: 100%;
}
/* .vs__dropdown-toggle{ */
    /* padding: 4px 0 4px !important; */
/* } */
/* .vs__search{
    padding: 4px 8px !important;
    margin: 3px 0 0 !important;
} */

.vs__selected-options{
    height: 31px;
}

.ql-container{
    height: 177px;
    border-radius: 3px;
}


.check-box-container label{
    margin-right: 8px;
    margin-bottom: 8px;
}
.check-box-container{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

.item-pill.selected{
    /* background-color: #f93154; */
    background-color: #26A69A !important;
    /* background-color: #00b74a; */
    color: white !important;
}
.item-pill:hover{
    border-color: #1266f1;
    background-color: #0062ff26;
    color: #1266f1;
}
.item-pill{
    /* color: #f93154; */
    color: #26A69A;
    /* color: #00b74a; */
    /* border: 1px solid #f93154; */
    border: 1px solid #26A69A;
    /* border: 1px solid #00b74a; */
    background-color: #ffffff;
    padding: 1px 14px;
    border-radius: 50px;
    margin-right: 9px;
    cursor: pointer;
    margin-bottom: 9px;
    transition: all .1s ease-in-out;
}
.ad-form .vs__search{
    padding: 0px 8px !important
}
.ad-form .vs__selected{
    margin: 0px 2px 0;
}
.ad-form .vs__dropdown-toggle{
    padding: 0 0 1px;
}
.ad-form .delivery-pickup-area{
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
.utilities .utility-item .utility-item-link{
    color: #515151;
}
</style>
