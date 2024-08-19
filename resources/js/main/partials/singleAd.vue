<template>
  
<div class="single-ad">

      <div class="ad-image-box" :class="{'mr-3' : $store.getters.ltr , 'ml-3' : $store.getters.rtl}" >
        <router-link :to="'/view/'+listing.id+'/listing'">
            <img class="ad-image"  v-if="listing && listing.main_image" :src="'/storage/listings/' + listing.main_image" />
            <img class="ad-image" v-else src="/img/car_no_image.jpg" />

            <!-- <i class="fa fa-heart _mobile_fav_icon"></i> -->

            <div class="image-count" :class="{'left' : $store.getters.ltr , 'right' : $store.getters.rtl}" >
              <i class="fas fa-image"></i> {{listing.images.length}}
            </div>
        </router-link>
          </div>
          <div class="ad-meta-details">

        <router-link :to="'/view/'+listing.id+'/listing'">
          <div class="price-area"> 
            <span class="time-ago" :class="{'float-right' : $store.getters.ltr , 'float-left' : $store.getters.rtl}">{{listing.created_at | formatDifferenceDate}}</span>
            <!-- <span class="price">Starting From AED 499/Day | 2,499/Week | 14,000/Month</span> -->
            <span class="price">{{trans._getMessage('Starting From AED')}} 
              <br class="d-sm-block d-md-none">
              {{$root.numberWithCommas(listing.day_price)}}/ {{trans._getMessage('Day')}}
              <template v-if="listing.week_price">
                | {{$root.numberWithCommas(listing.week_price)}}/ {{trans._getMessage('Week')}}
              </template> 
              <template v-if="listing.month_price">
               | {{$root.numberWithCommas(listing.month_price)}}/ {{trans._getMessage('Month')}}
              </template> 
              </span>
          </div>

          <div class="category-list">
            <div class="category-item">
              <span>{{listing.category ? listing.category.proper_title : ""}}</span>
              <svg _ngcontent-smartarz-client-c122="" height="7" width="7"><circle _ngcontent-smartarz-client-c122="" cx="3" cy="4" r="1.5" stroke="black" stroke-width="3" fill="black"></circle></svg>
            </div>

            <div class="category-item"> {{listing.make ? listing.make.proper_title : ""}} </div>
          </div>

          <div class="ad-title">
            <h2>{{listing.proper_title}} </h2>
          </div>

          <div class="ad-specs">
            <div class="spec-item" :class="{'mr-3' : $store.getters.ltr , 'ml-3' : $store.getters.rtl}" >
              <img src="/img/safety-seat.png"/>
              <span class="spec-name">{{listing.attr.seats}} {{trans._getMessage('Seats')}}</span>
            </div>
            
            <div class="spec-item text-center" :class="{'mr-3' : $store.getters.ltr , 'ml-3' : $store.getters.rtl}" >
              <img src="/img/transmission.svg"/>
              <span class="spec-name">{{trans._getMessage(listing.attr.transmission)}}</span>
            </div>
            
            <div class="spec-item text-center" :class="{'mr-3' : $store.getters.ltr , 'ml-3' : $store.getters.rtl}" >
              <img src="/img/year.svg"/>
              <span class="spec-name">{{listing.attr.model}}</span>
            </div>
            
            <div class="spec-item text-right" :class="{'mr-3' : $store.getters.ltr , 'ml-3' : $store.getters.rtl}" >
                <star-rating 
                  active-color="#0e2859"
                  v-model="listing.average_ratings" 
                  :read-only="true" 
                  :round-start-rating="false"
                  :show-rating="false"
                  :star-size="20" 
                  :rtl="$store.getters.rtl"
              ></star-rating>
            </div>

          </div>

        <div class="ad-location">
          <i class="fas fa-map-marker-alt"></i>
          <span> {{trans._getMessage(listing.city)}} </span>
        </div>
      </router-link>


        <div class="ad-footer">


          <div class="right-area" :class="{'float-right' : $store.getters.ltr , 'float-left' : $store.getters.rtl}">
              <button @click="goToWhatsapp()" v-if="!isNaN(listing.phone)" type="button" class="mb-btn smz-btn-lite" href="javascript:;" ><img class="whatsapp-icon-btn" src="/images/whatsapp.png"/> {{trans._getMessage('Chat')}}</button>
              <button @click="goToLink('tel:'+ listing.phone +'')" class="mb-btn smz-btn-dark" href="javascript:;" >{{trans._getMessage('Call')}}</button>
          </div>


          <div class="left-area">
            <span><i @click="likeListing" class="fas fa-thumbs-up footer-icon cursor-pointer" :class="{'filled' : listing.liked}" ></i> <span class="number">{{listing.total_likes}}</span></span>
            <span class="ml-2"><i class="fal fa-stars footer-icon "></i> <span class="number">{{listing.total_reviews}}</span></span>
          </div>
        </div>

        
      </div>
    </div>
</template>

<script>
export default {
  data(){
    return{
      rating: 4,
    }
  },
  props:{
    listing:{

    }
  },
  
  methods:{

    goToWhatsapp(){

      
      var text = 'Hi I am interested in your ad ' + this.listing.title;
        if(this.listing.make){
          text += ' make ' + this.listing.make.title;
        }
        if(this.listing.model){
          text += ' model ' + this.listing.model.title;
        }
        text += ' from MOTRCOM';
        // text = text.replace(" ", "%");  
        // text = text.replace(/ /g, '%');
        text = encodeURIComponent(text)
        console.log(text)
        console.log(this.listing.phone)
        window.location.href = 'https://wa.me/'+this.listing.phone+'?text='+text;
        // window.location.href = 'https://wa.me/'+this.listing.phone+'?text=I%27m%20interested'
      //   if(this.$store.getters.isAuthenticated){
      // }else{
      //   Swal.fire({
      //     title: this.trans._getMessage('Please login to continue'),
      //       icon: 'info',
      //       showCancelButton: true,
      //       confirmButtonColor: '#3085d6',
      //       cancelButtonColor: '#d33',
      //       cancelButtonText: this.trans._getMessage('Cancel'),
      //       confirmButtonText: this.trans._getMessage('Login Now'),
      //       }).then((result) => {
      //     if (result.isConfirmed) {
      //         this.$router.push('/user-login');
      //         }
      //     })
      // }
    },
    goToLink(link){
      window.location.href = link;
      // if(this.$store.getters.isAuthenticated){
      // }else{
      //     Swal.fire({
      //       title: this.trans._getMessage('Please login to continue'),
      //       icon: 'info',
      //       showCancelButton: true,
      //       confirmButtonColor: '#3085d6',
      //       cancelButtonColor: '#d33',
      //       cancelButtonText: this.trans._getMessage('Cancel'),
      //       confirmButtonText: this.trans._getMessage('Login Now'),
      //       }).then((result) => {
      //     if (result.isConfirmed) {
      //         this.$router.push('/user-login');
      //         }
      //     })

      // }
    },
    toArabicNumeral(en) {
      return ("" + en).replace(/[0-9]/g, function(t) {
          return "٠١٢٣٤٥٦٧٨٩".substr(+t, 1);
      });
    },

    likeListing(){
      if(this.$store.getters.isAuthenticated){

        this.listing.liked = !this.listing.liked;
      
      axios.post('/api/listing/like' , {
        listing_id: this.listing.id,
        user_id: this.$store.getters.isAuthenticated.id
      }).then( res => {
        
        this.listing.total_likes = res.data.likes;

        }).catch( err => {
          console.log(err)
      })
      }else{
          Swal.fire({
            title: this.trans._getMessage('Please login to continue'),
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: this.trans._getMessage('Cancel'),
            confirmButtonText: this.trans._getMessage('Login Now'),
            }).then((result) => {
        if (result.isConfirmed) {
            this.$router.push('/user-login');
            }
        })

      }
    }

  }
}
</script>

<style>
.single-ad .vue-star-rating{
  margin-top: -3px;
}
</style>