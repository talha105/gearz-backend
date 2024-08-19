<template>

<div>


<div class="home">



  <div class="slider-container-smz">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <loader :small="false" v-if="loadingBanner"></loader>
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" :data-slide-to="index" :class="{'active' : index == 0}" v-for="(banner,index)  in $store.getters.getBanners" :key="index"  ></li>

        <li data-target="#carouselExampleIndicators" data-slide-to="0" v-if="!loadingBanner && $store.getters.getBanners.length == 0"  ></li>
      </ol>
      <div class="carousel-inner">
        <!-- <div class="carousel-item active">
          <img class="d-block w-100 slide-item" src="/images/cars.gif" alt="Third slide">
        </div>
        
        <div class="carousel-item">
          <img class="d-block w-100 slide-item" src="/images/mo1.gif" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100 slide-item" src="/images/ca.gif" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100 slide-item" src="/images/ka.gif" alt="4th slide">
        </div> -->

        <div class="carousel-item" :class="{'active' : index == 0}" v-for="(banner,index)  in $store.getters.getBanners" :key="index"  >
          <img class="d-block w-100 slide-item" :src="'/storage/banners/'+banner.name" :alt="'slide-' + index">
        </div>
        
        <div class="carousel-item active" v-if="loadingBanner && $store.getters.getBanners.length == 0"  >
          <img class="d-block w-100 slide-item" src="/img/sports-car-1374425_1920.jpg" alt="First slide">
        </div>
        <!-- <div class="carousel-item">
        </div><div class="carousel-item">
          <img class="d-block w-100 slide-item" src="/img/sports-car-1374425_1920.jpg" alt="First slide">
        </div>
          <img class="d-block w-100 slide-item" src="/img/sports-car-1374425_1920.jpg" alt="First slide">
        <div class="carousel-item">
          <img class="d-block w-100 slide-item" src="/img/car-1890494_1920.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100 slide-item" src="/img/city-1283801_1920.jpg" alt="First slide">
        </div> -->


      </div>
    </div>
  </div>



<div class="-container">


  <div class="categories">

        <div class="category-item-box" v-for="(category,index) in mainCategories" :key="index">
          <div class="category-item" @click="openSubCategoriesModal(category)" >
            <img class="category-item-image" :src="'/storage/categories/'+category.image" />
            <div class="category-item-name">{{category.proper_title}}</div>
          </div>
        </div>

        <!-- <div class="category-item-box">
          <div class="category-item" @click="openSubCategoriesModal(0)" >
            <img class="category-item-image" src="/images/car.png" />
            <div class="category-item-name">Vehicles</div>
          </div>
        </div>
        
        <div class="category-item-box">
          <div class="category-item" @click="$router.push('category-ads')" >
            <img class="category-item-image" src="/images/atv.png" />
            <div class="category-item-name">ATV’s</div>
          </div>
        </div>
        
        <div class="category-item-box">
          <div class="category-item" @click="$router.push('category-ads')" >
            <img class="category-item-image" src="/images/boat.png" />
            <div class="category-item-name">Boats</div>
          </div>
        </div>
        
        <div class="category-item-box">
          <div class="category-item" @click="$router.push('category-ads')" >
            <img class="category-item-image" src="/images/dumper-truck.png" />
            <div class="category-item-name">Heavy Vehicles</div>
          </div>
        </div> -->

     
  </div>




<div class="top--ads">
  
<loader :small="false" v-if="loadingListings"></loader>

<div  v-for="block in blocks" :key="block.id">
  <template v-if="block.all_listings.length">
  <div class="section-heading">
    <span>{{block.proper_title}}</span> 
    <a href="javascript:;" @click="gotoCategoryBlock(block)" class="smz-round-btn">{{trans._getMessage('See All')}}</a>
  </div>

  <div class="product-section">
    <div :id="'block-listings-'+block.id"  class="splide home--splide">
      <div class="splide__track">
          <ul class="splide__list">
              <li class="splide__slide" v-for="(listing , index) in block.all_listings" :key="index">
                  <item-card :listing="listing" ></item-card>
              </li>
          </ul>
      </div>
    </div>
  </div>
  </template>
</div>



<!-- <div class="product-section">
    <div id="featured-slider" class="splide home--splide">
      <div class="splide__track">
          <ul class="splide__list">
              <li class="splide__slide" v-for="index in 6" :key="index">
                  <item-card ></item-card>
              </li>
          </ul>
      </div>
    </div>
</div> -->


  <!-- <div class="section-heading">
    <span>Hot Picks</span> 
    <a href="#" class="smz-round-btn">See All</a>
  </div> -->

  <!-- <div class="product-section">
    <div id="top-ads-slider" class="splide home--splide">
      <div class="splide__track">
          <ul class="splide__list">
              <li class="splide__slide" v-for="index in 6" :key="index">
                  <item-card ></item-card>
              </li>
          </ul>
      </div>
    </div>
</div> -->

  <!-- <div class="section-heading">
    <span>Hot Picks</span> 
    <a href="#" class="smz-round-btn">See All</a>
  </div> -->

  <!-- <div class="product-section" >
    <ul class="" id="responsive">
        <li class="" v-for="index in 20" :key="index">
            <item-card class="half-card" ></item-card>
        </li>
    </ul>
  </div> -->



  </div>


  
      <!-- col-xs-6 col-sm-6 col-md-4 col-lg-3 -->
  <!-- <div class="section-heading">
    <span>Property Sales</span> 
    <a href="#" class="smz-round-btn">See All</a>
  </div> -->

  <!-- <div class="product-section">
    <div class="row">
      <div class="col-6">
        <item-card></item-card>
      </div>
    <div class="col-6">
        <item-card></item-card>
      </div>
    <div class="col-6">
        <item-card></item-card>
      </div>
      
      <div class="col-6">
        <item-card></item-card>
      </div>
    </div>
  </div> -->





</div>

</div>














<div class="sub-category-modal" v-if="showSubcategoies">

  <div class="sub-category-modal-main">
    <div class="_modal-close-btn" :class="{'left' : $store.getters.rtl , 'right' : $store.getters.ltr}" @click="closeModal" >
        <svg _ngcontent-smartarz-client-c151="" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15.125 15.125"><path _ngcontent-smartarz-client-c151="" id="_2089733" data-name="2089733" d="M15.125,1.782,13.342,0,7.562,5.78,1.782,0,0,1.782l5.78,5.78L0,13.342l1.782,1.782,5.78-5.78,5.78,5.78,1.782-1.782-5.78-5.78Z" fill="#fff"></path></svg>
     </div>

        
        <div class="smz-modal-title"  v-if="step > 1">
        <i class="fas fa-arrow-left choose-brand-step" @click="step = 1"></i>
        {{currentMake.proper_title}}</div>
        
        <div class="smz-modal-title" v-else>{{currentCategory.proper_title}}</div>

      <div class="sub-category-listing">
      <!-- v-if="currentCategory.id == 0" -->
        <template >
          <template v-if="step == 1">
            <div class="sub-category-item" @click="chooseMake()"> {{trans._getMessage('All Makes')}} <i class="fas choose-brand-step" :class="{'float-right fa-angle-right' : $store.getters.ltr , 'float-left fa-angle-left' : $store.getters.rtl}"></i> </div>

            <div class="sub-category-item" @click="chooseMake(make)"  v-for="(make , index) in currentCategory.makes" :key="index" > {{make.proper_title}} <i class="fas choose-brand-step" :class="{'float-right fa-angle-right' : $store.getters.ltr , 'float-left fa-angle-left' : $store.getters.rtl}"></i> </div>
          </template>

          <template v-if="step == 2">
            <router-link to="/category-ads" @click.native="chooseModel()"  >
            <div class="sub-category-item"> {{trans._getMessage('All Models')}} <i class="fas choose-brand-step" :class="{'float-right fa-angle-right' : $store.getters.ltr , 'float-left fa-angle-left' : $store.getters.rtl}"></i> </div>
        </router-link>
        
        <router-link to="/category-ads" @click.native="chooseModel(model)" v-for="(model , index) in currentMake.models" :key="index" >
            <div class="sub-category-item"> {{ model.proper_title }} <i class="fas choose-brand-step" :class="{'float-right fa-angle-right' : $store.getters.ltr , 'float-left fa-angle-left' : $store.getters.rtl}"></i> </div>
        </router-link>
          </template>
        </template>

        <!-- <template v-else>
          <router-link to="/category-ads" @click.native="closeModal" v-for="(subcat , index) in subcategories[currentCategory.id].sort()" :key="index" >
              <div class="sub-category-item"> {{subcat}} <i class="fas fa-angle-right"></i> </div>
          </router-link>
        </template> -->

      </div>
  </div>
</div>




<bottom-nav :openGenre="openGenre" ></bottom-nav>

</div>
</template>



<script>

export default{
  data(){
    return{
      showSubcategoies: false,
      loadingListings: false,
      openGenre: false,
      loadingBanner: false,
      currentCategory: '',
      slider: '',
      currentBrand: '',
      currentModel: '',
      currentMake: '',
      blocks: [],
      listings: [],
      banners: [],
      mainCategories:[
        {id: 0 , name: 'Vehicles'},
        {id: 1 , name: 'ATV’s'},
        {id: 2 , name: 'Boats'},
        {id: 3 , name: 'Heavy Vehicles'},
      ],
      subcategories:[
        ['Audi','Bmw','Ford','Jeep','Hyundai','Honda','Mercedez Benz','Nissan','Toyota',],
        ['ATV’s1','ATV’s2','ATV’s3','ATV’s4'],
        ['Boats1','Boats2','Boats3','Boats4'],
        ['Heavy Vehicles1','Heavy Vehicles2','Heavy Vehicles3','Heavy Vehicles4'],
      ],
      step : 1,
      attributes:[
        {'Audi' : [ 'A1','A3','A4','A5','S4','S6'],
        'Bmw' : [ '1 Series','3 Series','5 Series','7 Series'],
        'Ford' : [ 'Focus','Fiesta','Eco Sport','Mustang'],
        'Jeep' : [ 'Cherokee','Commander','Wrangler'] ,
        'Hyundai' : [ 'Accent','Getz','Sonata'] ,
        'Honda' : [ 'Civic','City','BR-V' , 'HR-V' , 'Airwave' , 'Accord'] ,
        'Mercedez Benz' : [ 'A Class','C Class','E Class' , 'S Class','G Class'] ,
        'Nissan' : [ '350Z','370Z','Altima' , 'Armada','Pathfinder' , 'Patrol Safari'] ,
        'Toyota' : [ 'FJ Cruiser','Fortuner','Rav 4' , 'Corolla','Camary' , 'Tundra' , 'Yaris'] ,
        },
        { 'ATV’s' : [ 'Atv Model 1' , 'Atv Model 2' , 'Atv Model 3']  },
        { 'Boats' : [ 'Boat Model 1' , 'Boat Model 2' , 'Boat Model 3']  },
        { 'Heavy Vehicles' : [ 'Heavy Vehical Model 1' , 'Heavy Vehical  Model 2' , 'Heavy Vehical  Model 3']  },
      ],
      // attributes:{
      //   'Audi' : [ 'A1','A3','A4','A5','S4','S6'],
      //   'Bmw' : [ '1 Series','3 Series','5 Series','7 Series'],
      //   'Ford' : [ 'Focus','Fiesta','Eco Sport','Mustang'],
      //   'Jeep' : [ 'Cherokee','Commander','Wrangler'] ,
      //   'Hyundai' : [ 'Accent','Getz','Sonata'] ,
      //   'Honda' : [ 'Civic','City','BR-V' , 'HR-V' , 'Airwave' , 'Accord'] ,
      //   'Mercedez Benz' : [ 'A Class','C Class','E Class' , 'S Class','G Class'] ,
      //   'Nissan' : [ '350Z','370Z','Altima' , 'Armada','Pathfinder' , 'Patrol Safari'] ,
      //   'Toyota' : [ 'FJ Cruiser','Fortuner','Rav 4' , 'Corolla','Camary' , 'Tundra' , 'Yaris'] ,
      // }
    }
  },
  updated(){
    if(this.blocks.length){
      this.blocks.forEach(block => {
        if(!block.initialized && block.all_listings.length){
          this.initializeSplider('block-listings-' + block.id)
          block.initialized = true;
        }
      })
    }
  },
  created(){
    this.getAllBanners();
    this.getCatgories();
    // this.getAllListings();
    this.getBlocks();

  },
  mounted(){
    this.$router.afterEach((to, from) => {
      // console.log(to, from , from.name == 'search-listings')
      if(from.name == 'search-listings'){
        this.$store.commit('setGenreStatus' , true)
          // this.$root.$refs.bottom_navbar.openGenreModal();
      }
    })

  },
  methods:{
      getAllBanners(){

        if(this.$store.getters.getBanners.length == 0){
          this.loadingBanner = true
          axios.post('/api/banner/all')
          .then( res => {
            this.banners = res.data.banners
            this.$store.commit('setBanners' , res.data.banners)
            this.loadingBanner = false
          }).catch( err => {
            this.loadingBanner = false
              console.log(err)
          })
        }
      },

      getBlocks(){
        this.loadingListings = true
        axios.post('/api/main/display-blocks/get')
        .then( res => {
            // console.log(res)
            this.loadingListings = false
            this.blocks = res.data.blocks;
        }).catch( err => {
            this.loadingListings = false
            console.log(err)
        })
    },

    openSubCategoriesModal(cat){
      this.currentCategory = '';
      this.currentCategory = cat;
      if(cat.makes.length){
        this.showSubcategoies = true;
        this.step = 1;
        this.currentBrand = '';
        $('body').css('overflow' , 'hidden')
      }else{
        this.closeModal();
        this.$router.push('/category/'+ this.currentCategory.id +'/listings' , cat)
      }
    },

    getCatgories(){
      axios.post('/api/category/all-details')
      .then( res => {
          this.mainCategories = res.data.categories;
      }).catch( err => {
        console.log(err)
      })
    },
    getAllListings(){
      this.loadingListings = true
      axios.post('/api/get-all-listings')
      .then( res => {
          this.listings = res.data.listings;
          this.initializeSliders();
          this.loadingListings = false
      }).catch( err => {
        console.log(err)
        this.loadingListings = false
      })
    },

    closeModal(){
        $('body').css('overflow' , 'auto')
        // this.currentCategory = '';
        this.showSubcategoies = false;
        
    },

    chooseMake(make){
      console.log(make)

      if(make){
      if(make.models && make.models.length && this.currentCategory.has_modal == 1){
        this.step = 2;
        this.currentMake = make;
      }else{
        this.closeModal();
        console.log('chooseMake')
        // this.$router.push({ name: 'ads-listings', params: {
        //   category_id:this.currentCategory.id , 
        //   // category:this.currentCategory,
        //   make_id:this.currentMake.id,
        //   // make

        //   }})
        this.$router.push('/category/'+ this.currentCategory.id +'/listings/'+ make.id)
        // this.$router.push('/category/'+ this.currentCategory.id +'/listings' , { 
        //   category: this.currentCategory ,
        //   make: this.currentMake ,
        //   })
      }
      }else{
        this.closeModal();
        this.$router.push('/category/'+ this.currentCategory.id +'/listings')
      }
    },
    chooseModel(model){

      if(model){

        this.closeModal();
        this.currentModel = model;
        // this.$router.push('/category/'+ this.currentCategory.id +'/listings' , cat)
        this.$router.push('/category/'+ this.currentCategory.id +'/listings/'+ this.currentMake.id +'/'+model.id)
      }else{
        this.closeModal();
        this.$router.push('/category/'+ this.currentCategory.id +'/listings/'+ this.currentMake.id)

      }

        // this.$router.push({ name: 'ads-listings', params: {
        //   category_id:this.currentCategory.id , 
        //   model_id:this.currentModel.id,
        //   make_id:this.currentMake.id,
        //   // category:this.currentCategory,
        //   // make:this.currentMake,
        //   // model,
        // }})


    },
    chooseBrand(brand){
      console.log(brand)
      this.step = 2;
      this.currentBrand = brand;
      // console.log(this.attributes[this.currentCategory.id][this.currentBrand])
      // console.log( this.attributes[brand])
    },
    //     goToLink(link){
    //     window.location.href = link;
    // },
    gotoCategoryBlock(block){
        this.$router.push('/categories/'+ block.id +'/listings')

    },
    initializeSplider(name){
          // console.log( name , document.getElementById(name))

          new Splide( '#'+name, {
              // type       : 'slide',
              type   : 'loop',
              direction :  this.$store.getters.rtl ? 'rtl' : 'ltr' ,
              heightRatio: 0.5,
              pagination : false,
              cover      : true,
              // height     : '100%',
              height     : 'auto',
              arrows     : false,
              // autoplay   : true,
              perPage  : 2,
              gap    : '5px',
                padding: {
                  right: this.$store.getters.rtl ? '0' : '35px',
                  left : this.$store.getters.rtl ? '35px' : '0',
                },


          } ).mount();

    },
    initializeSliders(){
            // document.addEventListener( 'DOMContentLoaded', function () {

        $(document).ready( () =>  {
            
          //   new Splide( '#featured-slider', {
          //       type       : 'slide',
          //       // type   : 'loop',
          //       heightRatio: 0.5,
          //       pagination : false,
          //       cover      : true,
          //       height     : 'auto',
          //       arrows     : false,
          //       // autoplay   : true,
          //       perPage  : 2,
          //       gap    : '5px',
          //       	padding: {
          //           right: '35px',
          //           // left : '5px',
          //         },


          //   } ).mount();
          
          // new Splide( '#top-ads-slider', {
          //       // type       : 'slide',
          //       type   : 'loop',
          //       heightRatio: 0.5,
          //       pagination : false,
          //       cover      : true,
          //       height     : 'auto',
          //       arrows     : false,
          //       // autoplay   : true,
          //       perPage  : 2,
          //       gap    : '5px',
          //       padding: {
          //         right: '35px',
          //       },

          //       // breakpoints : {
          //       //     '550': {
          //       //         height    : 'auto',
          //       //     }
          //       // },

          //   } ).mount();


          new Splide( '.listing-sliders', {
                // type       : 'slide',
                type   : 'loop',
                direction :  this.$store.getters.rtl ? 'rtl' : 'ltr' ,
                heightRatio: 0.5,
                pagination : false,
                cover      : true,
                height     : 'auto',
                arrows     : false,
                // autoplay   : true,
                perPage  : 2,
                gap    : '5px',
                padding: {
                  right: '35px',
                },

                // breakpoints : {
                //     '550': {
                //         height    : 'auto',
                //     }
                // },

            } ).mount();

            this.slider = $('#responsive');
            this.slider.lightSlider({
                item:0,
                loop: false,
                //slideMove:2,
                easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
                speed:600,
                controls: false,
                slideMargin: 5,
                pager: false,
                autoWidth:true,
                enableTouch:true,
                enableDrag:true,
                //touchDrag: true,
                });  
            

          // setTimeout( () => {
          //   $('.product-section').css('margin' , '-5px');
          // } , 1000 )
            
        } );
        
    },

  }
}

</script>


<style>

/* .splide__slide { */
  /* margin-top: 10px; */
/* } */
/* .home--splide{
  padding: 5px;
} */

.top--ads{
  min-height: 300px;
  position: relative;
}
.product-section .vue-star-rating{
  justify-content: center;
}
.product-section{
  margin: 0px;
  position: relative;
  /* margin: -5px; */
  /* margin: 10px; */
}
.home--splide li{
  padding: 4px !important;
}
/* .splide, .splide__slide{ */
  /* margin: -10px; */
/* } */

.choose-brand-step{
  font-size: 15px;
  margin-right: 5px;
  color: #0e2859;
  cursor: pointer;
}

.carousel-indicators li.active{
  background-color: #0e2859;
}
.carousel-indicators li{
  background-color: #cccccc;
}

.half-card{
  width: 170px !important;
}

.lSSlideOuter .lightSlider, .lSSlideOuter .lSPager{
  padding-left: 5px !important;
}

.splide.is-active .splide__list{
  text-align: inherit !important;
}
.carousel-inner{
  min-height: 250px;
}
</style>