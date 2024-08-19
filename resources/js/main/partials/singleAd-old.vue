<template>
  
<div class="single-ad">

          <div class="ad-image-box">
        <router-link to="view-ad">
            <img class="ad-image" src="/images/fj-car.jpg" />

            <i class="fa fa-heart _mobile_fav_icon"></i>

            <div class="image-count">
              <i class="fas fa-image"></i> 3
            </div>
        </router-link>
          </div>
          <div class="ad-meta-details">

        <router-link to="view-ad">
          <div class="price-area"> 
            <span class="time-ago">a minute ago</span>
            <!-- <span class="price">Starting From AED 499/Day | 2,499/Week | 14,000/Month</span> -->
            <span class="price">Starting From AED 
              <br class="d-sm-block d-md-none">
              499/ Day | 2,499/ Week | 14,000/ Month</span>
          </div>

          <div class="category-list">
            <div class="category-item">
              <span>Vehicals</span>
              <svg _ngcontent-smartarz-client-c122="" height="7" width="7"><circle _ngcontent-smartarz-client-c122="" cx="3" cy="4" r="1.5" stroke="black" stroke-width="3" fill="black"></circle></svg>
            </div>

            <div class="category-item"> Toyota </div>
          </div>

          <div class="ad-title">
            <h2>Toyota FJ Cruiser VXR 4.0L </h2>
          </div>

          <div class="ad-specs">
            <div class="spec-item">
              <img src="/img/safety-seat.png"/>
              <span class="spec-name">4 Seats</span>
            </div>
            
            <div class="spec-item text-center">
              <img src="/img/transmission.svg"/>
              <span class="spec-name">Automatic</span>
            </div>
            
            <div class="spec-item text-center">
              <img src="/img/year.svg"/>
              <span class="spec-name">2019</span>
            </div>
            
            <!-- <div class="spec-item text-right">
              <svg _ngcontent-smartarz-client-c158="" width="23" height="20" viewBox="0 0 78 77" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c158="" d="M71.156 64.5941V17.8601C71.156 14.5768 68.4859 11.9067 65.2027 11.9067H61.333V14.8834C61.333 16.528 60.0009 17.8601 58.3563 17.8601C56.7117 17.8601 55.3796 16.528 55.3796 14.8834V11.9067H41.8357V14.8834C41.8357 16.528 40.5036 17.8601 38.859 17.8601C37.2144 17.8601 35.8823 16.528 35.8823 14.8834V11.9067H22.4872V14.8834C22.4872 16.528 21.1552 17.8601 19.5105 17.8601C17.8659 17.8601 16.5338 16.528 16.5338 14.8834V11.9067H12.813C9.52971 11.9067 6.85962 14.5768 6.85962 17.8601V64.2964C6.85962 67.5797 9.52971 70.2498 12.813 70.2498H65.2027C68.4859 70.2498 71.156 67.5797 71.156 64.2964C71.156 62.6518 72.4881 61.3197 74.1327 61.3197C75.7773 61.3197 77.1094 62.6518 77.1094 64.2964C77.1094 70.8615 71.7677 76.2031 65.2027 76.2031H12.813C6.24791 76.2031 0.90625 70.8615 0.90625 64.2964V17.8601C0.90625 11.295 6.24791 5.95337 12.813 5.95337H16.5338V2.97669C16.5338 1.33207 17.8659 0 19.5105 0C21.1552 0 22.4872 1.33207 22.4872 2.97669V5.95337H35.8823V2.97669C35.8823 1.33207 37.2144 0 38.859 0C40.5036 0 41.8357 1.33207 41.8357 2.97669V5.95337H55.3796V2.97669C55.3796 1.33207 56.7117 0 58.3563 0C60.0009 0 61.333 1.33207 61.333 2.97669V5.95337H65.2027C71.7677 5.95337 77.1094 11.295 77.1094 17.8601V64.5941C77.1094 66.2387 75.7773 67.5708 74.1327 67.5708C72.4881 67.5708 71.156 66.2387 71.156 64.5941ZM22.4872 31.2552C22.4872 29.6106 21.1552 28.2785 19.5105 28.2785C17.8659 28.2785 16.5338 29.6106 16.5338 31.2552C16.5338 32.8998 17.8659 34.2319 19.5105 34.2319C21.1552 34.2319 22.4872 32.8998 22.4872 31.2552ZM48.3844 31.2552C48.3844 29.6106 47.0523 28.2785 45.4077 28.2785C43.7631 28.2785 42.431 29.6106 42.431 31.2552C42.431 32.8998 43.7631 34.2319 45.4077 34.2319C47.0523 34.2319 48.3844 32.8998 48.3844 31.2552ZM61.333 31.2552C61.333 29.6106 60.0009 28.2785 58.3563 28.2785C56.7117 28.2785 55.3796 29.6106 55.3796 31.2552C55.3796 32.8998 56.7117 34.2319 58.3563 34.2319C60.0009 34.2319 61.333 32.8998 61.333 31.2552ZM22.4872 44.2038C22.4872 42.5592 21.1552 41.2271 19.5105 41.2271C17.8659 41.2271 16.5338 42.5592 16.5338 44.2038C16.5338 45.8484 17.8659 47.1805 19.5105 47.1805C21.1552 47.1805 22.4872 45.8484 22.4872 44.2038ZM19.5105 54.1757C17.8659 54.1757 16.5338 55.5077 16.5338 57.1524C16.5338 58.797 17.8659 60.129 19.5105 60.129C21.1552 60.129 22.4872 58.797 22.4872 57.1524C22.4872 55.5077 21.1552 54.1757 19.5105 54.1757ZM35.4358 31.2552C35.4358 29.6106 34.1037 28.2785 32.4591 28.2785C30.8145 28.2785 29.4824 29.6106 29.4824 31.2552C29.4824 32.8998 30.8145 34.2319 32.4591 34.2319C34.1037 34.2319 35.4358 32.8998 35.4358 31.2552ZM35.4358 44.2038C35.4358 42.5592 34.1037 41.2271 32.4591 41.2271C30.8145 41.2271 29.4824 42.5592 29.4824 44.2038C29.4824 45.8484 30.8145 47.1805 32.4591 47.1805C34.1037 47.1805 35.4358 45.8484 35.4358 44.2038ZM32.4591 54.1757C30.8145 54.1757 29.4824 55.5077 29.4824 57.1524C29.4824 58.797 30.8145 60.129 32.4591 60.129C34.1037 60.129 35.4358 58.797 35.4358 57.1524C35.4358 55.5077 34.1037 54.1757 32.4591 54.1757ZM42.431 47.1805C42.431 43.8972 45.1011 41.2271 48.3844 41.2271H55.3796C58.6629 41.2271 61.333 43.8972 61.333 47.1805V54.1757C61.333 57.459 58.6629 60.129 55.3796 60.129H48.3844C45.1011 60.129 42.431 57.459 42.431 54.1757V47.1805ZM48.3844 54.1757H55.3796C55.3826 54.1757 55.3826 54.1757 55.3826 54.1757L55.3796 47.1805H48.3844V54.1757Z" fill="#0e2859"></path></svg>

              <svg _ngcontent-smartarz-client-c131="" width="23" height="20" viewBox="0 0 80 81" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c131="" d="M79.8241 14.5329V0.44519H65.7364V5.14109H14.0877V0.44519H0V14.5329H4.6959V66.1836H0V80.2693H14.0877V75.5734H65.7385V80.2693H79.8241V66.1816H75.1282V14.5329H79.8241ZM70.4323 5.14109H75.1282V9.83699H70.4323V5.14109ZM4.6959 5.14109H9.3918V9.83699H4.6959V5.14109ZM9.3918 75.5734H4.6959V70.8775H9.3918V75.5734ZM75.1282 75.5734H70.4323V70.8775H75.1282V75.5734ZM70.4323 66.1816H65.7364V70.8775H14.0877V66.1816H9.3918V14.5329H14.0877V9.83699H65.7385V14.5329H70.4344V66.1816H70.4323Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c131="" d="M19.9854 37.0432L36.5842 20.4443L39.904 23.7641L23.3051 40.3629L19.9854 37.0432Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c131="" d="M39.9033 56.9657L56.5022 40.3668L59.8219 43.6866L43.2231 60.2854L39.9033 56.9657Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c131="" d="M24.9639 51.9842L51.522 25.426L54.8418 28.7458L28.2836 55.3039L24.9639 51.9842Z" fill="#0e2859"></path></svg>
              <span class="spec-name"> 2006 </span>
            </div> -->

            <div class="spec-item text-right">
                <star-rating 
                  active-color="#0e2859"
                  v-model="rating" 
                  :read-only="true" 
                  :round-start-rating="false"
                  :show-rating="false"
                  :star-size="20" 
              ></star-rating>
            </div>

          </div>

        <div class="ad-location">
          <i class="fas fa-map-marker-alt"></i>
          <span> Dubailand, Dubai </span>
        </div>
      </router-link>


        <div class="ad-footer">


          <div class="right-area">
              <button @click="goToLink('https://wa.me/+971552095949?text=I%27m%20interested')" type="button" class="mb-btn smz-btn-lite" href="javascript:;" ><img class="whatsapp-icon-btn" src="/images/whatsapp.png"/> Chat</button>
              <button @click="goToLink('tel:+971552095949')" class="mb-btn smz-btn-dark" href="javascript:;" >Call</button>
          </div>


          <div class="left-area">
            <span><i class="fas fa-thumbs-up footer-icon"></i> <span class="number">0</span></span>
            <span class="ml-2"><i class="fas fa-comment footer-icon "></i> <span class="number">0</span></span>
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
  methods:{
    goToLink(link){
      window.location.href = link;
    },

  }
}
</script>

<style>
.single-ad .vue-star-rating{
  margin-top: -3px;
}
</style>