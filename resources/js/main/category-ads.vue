<template>

<div>
  <div class="category-ads">



    <div class="container-fluid">
      
      
      <div class="bread-crumbs my-3 smt-d-sm-none">
        <b-spinner v-if="loadingCategory" small ></b-spinner>
          <div class="bread-crumbs-item">{{currentGenre ? currentGenre.proper_title : ""}} </div>
          
          <div class="bread-crumbs-item">{{category ? category.proper_title : ""}} 
            <!-- <i class="fas fa-angle-right"></i>  -->
          </div>
          <div class="bread-crumbs-item">{{block ? block.proper_title : ""}} 
            <!-- <i class="fas fa-angle-right"></i>  -->
          </div>
          
          <div class="bread-crumbs-item" v-if="make">
            <i class="fas" :class="{'fa-angle-right' : $store.getters.ltr , 'fa-angle-left' : $store.getters.rtl}" ></i> 
            {{make ? make.proper_title : ""}} 
          </div>
          <div class="bread-crumbs-item" v-if="model">
            <i class="fas" :class="{'fa-angle-right' : $store.getters.ltr , 'fa-angle-left' : $store.getters.rtl}" ></i> 
            {{model ? model.proper_title : ""}} 
          </div>
          <!-- <div class="bread-crumbs-item">Hot Picks </div> -->
      </div>

      <div class="bread-crumbs-sm my-3">
        <b-spinner v-if="loadingCategory" small ></b-spinner>
        
          <div class="bread-crumbs-item">{{currentGenre ? currentGenre.proper_title : ""}} </div>

          <div class="bread-crumbs-item">
            {{category ? category.proper_title : ""}} 
            <!-- <i class="fas fa-angle-right"></i>  -->
            </div>
          <div class="bread-crumbs-item">
            {{block ? block.proper_title : ""}} 
            <!-- <i class="fas fa-angle-right"></i>  -->
            </div>
            
            <div class="bread-crumbs-item" v-if="make">
              <i class="fas" :class="{'fa-angle-right' : $store.getters.ltr , 'fa-angle-left' : $store.getters.rtl}" ></i>
              {{make ? make.proper_title : ""}} 
            </div>
            
            <div class="bread-crumbs-item" v-if="model"> 
            <i class="fas" :class="{'fa-angle-right' : $store.getters.ltr , 'fa-angle-left' : $store.getters.rtl}" ></i>
            {{model ? model.proper_title : ""}} 
            </div>
          <!-- <div class="bread-crumbs-item">Hot Picks </div> -->
      </div>


      <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 left-side-filters left-side-filters-col" :class="{'ads-column' : $store.getters.rtl}">
          <div class="smz-box">
            <div class="smz-box-title">
              {{trans._getMessage('Filters')}}
              <a href="javascript:;" class="reset-btn" :class="{'float-right' : $store.getters.ltr , 'float-left' : $store.getters.rtl}" @click="resetFilters" > {{trans._getMessage('Reset')}} </a>
            </div>
            <div class="smz-box-body">

              <listing-filters :searchLoading="searchLoading" @searched="searchInitiated" :search="search" ></listing-filters>

              <!-- <div class="form-group">
                <div class="input-name">Choose Brand</div>
                <v-select placeholder="Select Brand" :clearable="false" :options="brands"></v-select>
              </div>
              
              
              <div class="form-group">
                <div class="input-name">Price</div>
                <div class="min-max-area">
                  <input class="form-control" placeholder="Min Price" />
                  <input class="form-control" placeholder="Max Price" />
                </div>
              </div>

              <div class="form-group">
                <v-select placeholder="Select Models" :clearable="false" :options="models"></v-select>
              </div>
              
              <div class="form-group">
                <div class="input-name">Mileage (KMs)</div>
                <div class="min-max-area">
                  <input class="form-control" placeholder="Min" />
                  <input class="form-control" placeholder="Max" />
                </div>
              </div>
              
              <div class="form-group">
                <div class="input-name">Keywords</div>
                <input class="form-control" placeholder="Search" />
              </div>
              
              <div class="form-group">
                <button class="search-button"> <i class="fas fa-search"></i> Search Now </button>
              </div> -->
              
            </div>


          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-8" :class="{'ads-column' : $store.getters.ltr}">

          <div class="smz-box top-bar">
            <div class="smz-box-title">{{listings ? listings.total : ''}} {{trans._getMessage('Results Found')}}


            <template class="dropdown">
              <div class="sort-area dropdown-toggle" :class="{'float-right' : $store.getters.ltr , 'float-left' : $store.getters.rtl}" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                {{trans._getMessage('Sort')}} | {{ getCurrentSort() }}
              </div>

              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <button class="dropdown-item sort-item" type="button" @click="sortListing('desc')" >{{trans._getMessage('Newest to Oldest')}}</button>
                <button class="dropdown-item sort-item" type="button" @click="sortListing('asc')" >{{trans._getMessage('Oldest to Newest')}}</button>
                <button class="dropdown-item sort-item" type="button" @click="sortListingByPrice('desc')" >{{trans._getMessage('Price Highest to Lowest')}}</button>
                <button class="dropdown-item sort-item" type="button" @click="sortListingByPrice('asc')" >{{trans._getMessage('Price Lowest to Highest')}}</button>
              </div>
            </template>


            </div>
          </div>


          <div class="filter-btns-area-sm">
            <div class="filters-icon" @click="openFilters">
              <svg _ngcontent-smartarz-client-c139="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path _ngcontent-smartarz-client-c139="" d="M11 9c1.3 0 2.4.8 2.8 2H15c.6 0 1 .4 1 1s-.4 1-1 1h-1.2c-.6 1.6-2.3 2.4-3.8 1.8-1.6-.6-2.4-2.3-1.8-3.8.4-1.2 1.5-2 2.8-2zm-6 2c.6 0 1 .4 1 1s-.3.9-.9 1H1c-.6 0-1-.4-1-1s.3-.9.9-1H5zm6 0c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1zM5 1c1.7 0 3 1.3 3 3S6.7 7 5 7c-1.3 0-2.4-.8-2.8-2H1c-.6 0-1-.4-1-1s.3-.9.9-1h1.3C2.6 1.8 3.7 1 5 1zm10 2c.6 0 1 .4 1 1s-.3.9-.9 1H11c-.6 0-1-.4-1-1s.3-.9.9-1H15zM5 3c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1z" fill="#2b2d2e"></path></svg>
              <span>{{trans._getMessage('Filters')}}</span>
            </div>

            <template class="dropdown">
            <div class="sort-icon dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <svg _ngcontent-smartarz-client-c139="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path _ngcontent-smartarz-client-c139="" d="M2 5h3V2H2v3zm3 4c1.1 0 2 .9 2 2v3c0 1.1-.9 2-2 2H2c-1.1 0-2-.9-2-2v-3c0-1.1.9-2 2-2h3zM11.3.3c.4-.4 1-.4 1.4 0l2 2c.4.4.4 1 0 1.4s-1 .4-1.4 0l-.3-.3V16h-2V3.4l-.3.3c-.4.4-.9.4-1.3.1l-.1-.1c-.4-.4-.4-1 0-1.4l2-2zM2 11v3h3v-3H2zM5 0c1.1 0 2 .9 2 2v3c0 1.1-.9 2-2 2H2C.9 7 0 6.1 0 5V2C0 .9.9 0 2 0h3z" fill="#2b2d2e"></path></svg>
              <span>{{trans._getMessage('Sort')}}</span>
            </div>

              <div class="dropdown-menu" aria-labelledby="dropdownMenu3">
                <button class="dropdown-item sort-item" type="button" @click="sortListing('desc')" >{{trans._getMessage('Newest to Oldest')}}</button>
                <button class="dropdown-item sort-item" type="button" @click="sortListing('asc')" >{{trans._getMessage('Oldest to Newest')}}</button>
                <button class="dropdown-item sort-item" type="button" @click="sortListingByPrice('desc')" >{{trans._getMessage('Price Highest to Lowest')}}</button>
                <button class="dropdown-item sort-item" type="button" @click="sortListingByPrice('asc')" >{{trans._getMessage('Price Lowest to Highest')}}</button>
              </div>
            </template>

          </div>

          <div class="ads-section">
            <loader class="mt-5" :small="false" v-if="loadingListing"></loader>

            <template v-if="listings.data">

              <SingleAd v-for="(listing,index) in listings.data" :listing="listing" :key="index"> </SingleAd>

            <div class="single-ad no-listing-message" v-if="listings.data.length ==0">
                <i class="fas fa-info-circle"></i> {{trans._getMessage("No Relevent Listings Found")}}
            </div>
            <!-- <SingleAd></SingleAd>
            <SingleAd></SingleAd>
            <SingleAd></SingleAd> -->

            <pagination v-if="category" align="center" :data="listings" @pagination-change-page="getCategoryListings"></pagination>
            <pagination v-if="block" align="center" :data="listings" @pagination-change-page="getBlocksListings"></pagination>
            <pagination v-if="currentGenre" align="center" :data="listings" @pagination-change-page="getGenreListings"></pagination>

            </template>
          </div>


            
        </div>
      </div>
    </div>
  </div>




<div class="filter-fixed-sm left-side-filters" v-if="showFilters">

  <div class="filters-header">
    <i class="fas fa-times float-left" @click="closeFilters"></i>
    <span>{{trans._getMessage('Filters')}}</span>
    <a href="javascript:;" @click="resetFilters" class="reset-btn" >{{trans._getMessage('Reset')}}</a>
  </div>
  <div class="sub-category-listing">
    <listing-filters :searchLoading="searchLoading" @searched="searchInitiated" :search="search" ></listing-filters>
  </div>

  <!-- <div class="filter-fixed-sm-body">
  <div class="form-group">
    <div class="input-name">Choose Brand</div>
    <v-select placeholder="Select Brand" :clearable="false" :options="brands"></v-select>
  </div>
  
  
  <div class="form-group">
    <div class="input-name">Price</div>
    <div class="min-max-area">
      <input class="form-control" placeholder="Min Price" />
      <input class="form-control" placeholder="Max Price" />
    </div>
  </div>

  <div class="form-group">
    <v-select placeholder="Select Models" :clearable="false" :options="models"></v-select>
  </div>
  
  <div class="form-group">
    <div class="input-name">Mileage (KMs)</div>
    <div class="min-max-area">
      <input class="form-control" placeholder="Min" />
      <input class="form-control" placeholder="Max" />
    </div>
  </div>
  
  <div class="form-group">
    <div class="input-name">Keywords</div>
    <input class="form-control" placeholder="Search" />
  </div>
  </div>
  
  <div class="search-footer-fixed">
    <button class="search-button"> <i class="fas fa-search"></i> Search Now </button>
  </div> -->

</div>

</div>
</template>



<script>
import SingleAd from './partials/singleAd.vue';

export default{
  components:{
    SingleAd,
  },  
  props:{
    // category:{

    // },
    // make:{

    // },
    // model:{

    // }
  },
  mounted(){
    // console.log(this.$route.params.category_id)
    // console.log(this.$route.params.model_id)
    // console.log(this.$route.params.make_id)
    this.getListingAllCategories()
    this.handleListings()
  },
  data(){
    return{
      models: ['2021' , '2020' , '2019', '2018', '2017', '2016', '2015'],
      brands: ['Audi','Bmw','Ford','Jeep','Hyundai','Honda','Mercedez Benz','Nissan','Toyota',],
      showSubcategoies: false,
      showFilters: false,
      loadingListing: false,
      loadingCategory: false,
      isSearching: false,
      sort_by: 'desc',
      sort_by_price: '',
      currentCategory: '',
      listings: [],
      all_categories: [],
      category:"",
      block:"",
      model:"",
      make:"",
      currentGenre: '',
      searchLoading: false,
      search:{
        search: "",
        category: "",
        model: "",
        make: "",
        // block: "",
        feature: "",
        transmission: "",
        genre: "",
        min_day: "",
        max_day: "",
        min_month: "",
        max_month: "",
        sortBy: "desc",
        sort_by: "desc",
        sort_by_price: "",
      }
    }
  },
  methods:{

    searchInitiated(){
      let result = !Object.values(this.search).every(search_item => search_item == '');
      // console.log(result);
      if(result){
        this.listings = []
        this.searchLoading = true
        axios.post('/api/search-filters' ,  {
          ...this.search,
          user_id : this.$store.getters.isAuthenticated ? this.$store.getters.isAuthenticated.id : ""
        } )
        .then( res => {
          this.listings = res.data.listings
          this.searchLoading = false
          // console.log(res)
          this.closeFilters();
  
        }).catch(err => {
          this.closeFilters();
          this.searchLoading = false
          console.log(err)
        })
      }
    },
    sortListing(sort){
      this.search.sort_by = sort
      this.sort_by = sort
      this.search.sort_by_price = ''
      this.sort_by_price = ''

      this.handleListings();
    },
    sortListingByPrice(sort){
      this.search.sort_by_price = sort
      this.sort_by_price = sort
      this.handleListings();
    },
    handleListings(){

          if(this.isSearching){
              this.searchInitiated()
          }else{
            if(this.$route.params.category_id){
              this.getListingCategories()
              this.getCategoryListings()
            }
            if(this.$route.params.block_id){
              this.getListingBlocks()
              this.getBlocksListings()
            }
            if(this.$route.params.genre){
              this.getGenre()
              this.getGenreListings()
            }
          }
    },
    getListingCategories(){
      this.loadingCategory = true
      axios.post('/api/main/listing-category' , {
        category_id : this.$route.params.category_id,
        model_id : this.$route.params.model_id ? this.$route.params.model_id : "",
        make_id : this.$route.params.make_id ? this.$route.params.make_id : "",
      }).then( res => {

        this.category = res.data.category
        this.model = res.data.model
        this.make = res.data.make
        this.loadingCategory = false
        this.selectFilters()
        
      }).catch(err => {
        this.loadingCategory = false
        
      })
    },
    selectFilters(){
      if(this.category){
        this.all_categories.map(cat => {
          if(cat.id == this.category.id){
            this.search.category = cat
          }
        })
      }

      if(this.search.category){
        this.search.category.makes.map(make => {
          if(make.id == this.make.id){
            this.search.make = make
          }
        })
      }

      if(this.search.make){
        this.search.make.models.map(model => {
          if(model.id == this.model.id){
            this.search.model = model
          }
        })
      }

    },
    getCategoryListings(page = 1){
      this.loadingListing = true
      this.isSearching = false;
      
      axios.post('/api/main/category-listings?page=' + page , {
        category_id : this.$route.params.category_id,
        model_id : this.$route.params.model_id ? this.$route.params.model_id : "",
        make_id : this.$route.params.make_id ? this.$route.params.make_id : "",
        user_id : this.$store.getters.isAuthenticated.id,
        sort_by : this.sort_by,
        sort_by_price: this.sort_by_price,
      })
      .then( res => {
        this.listings = res.data.listing;
        this.loadingListing = false

        window.scrollTo(0, 0);
      }).catch(err => {
        this.loadingListing = false
        console.log(err)
      })
    },
    getListingBlocks(){
      this.isSearching = false;
      this.loadingCategory = true
      axios.post('/api/main/listing-category' , {
        block_id : this.$route.params.block_id,
      }).then( res => {

        this.block = res.data.block
        this.loadingCategory = false

      }).catch(err => {
        this.loadingCategory = false
        
      })
    },
    getListingAllCategories(){
      this.isSearching = false;
      this.loadingCategory = true
      axios.post('/api/category/all-details')
      .then( res => {
        this.all_categories = res.data.categories;
        this.selectFilters()
      }).catch(err => {
        this.loadingCategory = false
      })
    },
    getBlocksListings(page = 1){
      this.loadingListing = true
      
      axios.post('/api/main/category-listings?page=' + page , {
        block_id : this.$route.params.block_id,
        user_id : this.$store.getters.isAuthenticated.id,
        sort_by : this.sort_by,
        sort_by_price: this.sort_by_price,
      })
      .then( res => {
        this.listings = res.data.listing;
        this.loadingListing = false
        window.scrollTo(0, 0);
      }).catch(err => {
        this.loadingListing = false
        console.log(err)
      })
    },


    getGenre(){
      this.isSearching = false;
      this.loadingCategory = true
      axios.post('/api/main/listing-category' , {
        genre_id : this.$route.params.genre,
      }).then( res => {

        this.currentGenre = res.data.genre
        this.search.genre = res.data.genre
        this.loadingCategory = false

      }).catch(err => {
        this.loadingCategory = false
        
      })
    },

    getGenreListings(page = 1){
      
      this.loadingListing = true
      axios.post('/api/main/category-listings?page=' + page , {
        genre : this.$route.params.genre,
        user_id : this.$store.getters.isAuthenticated.id,
        sort_by : this.sort_by,
        sort_by_price: this.sort_by_price,
      })
      .then( res => {
        this.listings = res.data.listing;
        this.loadingListing = false
        window.scrollTo(0, 0);
      }).catch(err => {
        this.loadingListing = false
        console.log(err)
      })
    },

    resetFilters(){
      this.isSearching = false
      this.closeFilters();
      this.handleListings();
      this.search = {
            search: "",
            brand: "",
            model: "",
            category: "",
            block: "",
            min: "",
            max: "",
            transmission: "",
            genre: "",
            feature: "",
            make: "",
            sortBy: "",
          }
    },
    openFilters(){
      this.showFilters = true
      $('body').css('overflow' , 'hidden')
    },

    closeFilters(){
      this.showFilters = false
      $('body').css('overflow' , 'auto')
    },

    openSubCategoriesModal(cat){
      this.currentCategory = cat;
      this.showSubcategoies = true;

      $('body').css('overflow' , 'hidden')
      console.log(cat)
    },

    closeModal(){
        $('body').css('overflow' , 'auto')
        this.currentCategory = '';
        this.showSubcategoies = false;
    },
    getCurrentSort(){
        if(this.sort_by && this.sort_by_price){
          if(this.sort_by_price == 'asc'){
            return this.trans._getMessage('Price Lowest to Highest')
          }else{
            return this.trans._getMessage('Price Highest to Lowest')
            }
        }else{
          if(this.sort_by == 'asc'){
            return this.trans._getMessage('Oldest to Newest')
          }else{
            return this.trans._getMessage('Newest to Oldest')
          }
        }
    }
  }
}

</script>


<style>
.category-ads .vs__dropdown-toggle{
  padding: 1px 0 4px !important;
}

.sort-item:hover{
  background-color: #f6f7fa;
  color: #0e2859;
}
.sort-item.active{
    color: #0e2859;
    background-color: #e1f1ff;
}
.dropdown-menu{
  padding: 0 !important;
}
.sort-item{
    width: 204px;
    height: 40px;
    padding: 10px 20px;
    font-size: 13px;
    cursor: pointer;
    font-weight: 500;
}

@media screen and (max-width:768px) {
  .category-ads .pagination {
      background-color: white;
      border-radius: 0;
      padding: 10px 0;
  }
}
.category-ads .pagination .page-item.active .page-link {
  background-color: #0e2859;
  border-color: #0e2859;
  color: #fff !important;
}
.category-ads .pagination .page-link {
  border-radius: 200px;
  margin-right: 7px;
}
</style>