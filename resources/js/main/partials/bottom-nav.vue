<template>

<div class="bottom-nav">

      <div class="sub-category-modal" v-if="showGenre">
        <div class="sub-category-modal-main">
          <div class="_modal-close-btn" :class="{'left' : $store.getters.rtl , 'right' : $store.getters.ltr}" @click="closeModal" >
              <svg _ngcontent-smartarz-client-c151="" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15.125 15.125"><path _ngcontent-smartarz-client-c151="" id="_2089733" data-name="2089733" d="M15.125,1.782,13.342,0,7.562,5.78,1.782,0,0,1.782l5.78,5.78L0,13.342l1.782,1.782,5.78-5.78,5.78,5.78,1.782-1.782-5.78-5.78Z" fill="#fff"></path></svg>
          </div>
              
              
              <div class="smz-modal-title">{{trans._getMessage('Select Genre')}}</div>

            <div class="sub-category-listing">
              <loader :small="false" v-if="loadingGenres" ></loader>
            <!-- v-if="currentCategory.id == 0" -->
                  <div class="sub-category-item" @click="chooseGenra({id: 'all' , proper_title: trans._getMessage('All Genres') })"> 
                    <img src="/img/no-genree-car.png" class="genre-image" /> 
                    {{trans._getMessage('All Genres')}} <i class="fas choose-brand-step" :class="{'float-right fa-angle-right' : $store.getters.ltr , 'float-left fa-angle-left' : $store.getters.rtl}"></i>
                  </div>

                  <div class="sub-category-item" @click="chooseGenra(genre)"  v-for="(genre , index) in genres" :key="index" > 
                    <img v-if="genre.image" :src="'/storage/genres/'+ genre.image" class="genre-image" /> 
                    <img v-else src="/images/no-genre-image.png" class="genre-image" /> 
                    {{genre.proper_title}} <i class="fas choose-brand-step" :class="{'float-right fa-angle-right' : $store.getters.ltr , 'float-left fa-angle-left' : $store.getters.rtl}"></i>
                     </div>
              
            </div>
        </div>
      </div>


    <div class="bottom-navbar">
      <div class="single-item active">
        <router-link class="menu-item" to="/">
          <svg _ngcontent-smartarz-client-c59="" width="20" height="26" viewBox="0 1 511 511.999" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c59="" d="m498.699219 222.695312c-.015625-.011718-.027344-.027343-.039063-.039062l-208.855468-208.847656c-8.902344-8.90625-20.738282-13.808594-33.328126-13.808594-12.589843 0-24.425781 4.902344-33.332031 13.808594l-208.746093 208.742187c-.070313.070313-.144532.144531-.210938.214844-18.28125 18.386719-18.25 48.21875.089844 66.558594 8.378906 8.382812 19.441406 13.234375 31.273437 13.746093.484375.046876.96875.070313 1.457031.070313h8.320313v153.695313c0 30.417968 24.75 55.164062 55.167969 55.164062h81.710937c8.285157 0 15-6.71875 15-15v-120.5c0-13.878906 11.292969-25.167969 25.171875-25.167969h48.195313c13.878906 0 25.167969 11.289063 25.167969 25.167969v120.5c0 8.28125 6.714843 15 15 15h81.710937c30.421875 0 55.167969-24.746094 55.167969-55.164062v-153.695313h7.71875c12.585937 0 24.421875-4.902344 33.332031-13.8125 18.359375-18.367187 18.367187-48.253906.027344-66.632813zm-21.242188 45.421876c-3.238281 3.238281-7.542969 5.023437-12.117187 5.023437h-22.71875c-8.285156 0-15 6.714844-15 15v168.695313c0 13.875-11.289063 25.164062-25.167969 25.164062h-66.710937v-105.5c0-30.417969-24.746094-55.167969-55.167969-55.167969h-48.195313c-30.421875 0-55.171875 24.75-55.171875 55.167969v105.5h-66.710937c-13.875 0-25.167969-11.289062-25.167969-25.164062v-168.695313c0-8.285156-6.714844-15-15-15h-22.328125c-.234375-.015625-.464844-.027344-.703125-.03125-4.46875-.078125-8.660156-1.851563-11.800781-4.996094-6.679688-6.679687-6.679688-17.550781 0-24.234375.003906 0 .003906-.003906.007812-.007812l.011719-.011719 208.847656-208.839844c3.234375-3.238281 7.535157-5.019531 12.113281-5.019531 4.574219 0 8.875 1.78125 12.113282 5.019531l208.800781 208.796875c.03125.03125.066406.0625.097656.09375 6.644531 6.691406 6.632813 17.539063-.03125 24.207032zm0 0"></path></svg>
          <div class="single-item-name">{{trans._getMessage('Home') }}</div>
          <!-- <div class="single-item-name">{{trans.get('__JSON__.Our Products')}}</div> -->
          <!-- <div class="single-item-name">Home</div> -->
        </router-link>
      </div>
      <div class="single-item" @click="openGenreModal">
          <i class="fa fa-search search-icon"></i>
          <div class="single-item-name">{{trans._getMessage('Search') }}</div>

          <!-- <svg _ngcontent-smartarz-client-c59="" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="add-new"><path _ngcontent-smartarz-client-c59="" d="M12.5 0C5.60722 0 0 5.60722 0 12.5C0 19.3928 5.60722 25 12.5 25C19.3928 25 25 19.3928 25 12.5C25 5.60722 19.3928 0 12.5 0ZM17.9688 13.5416H13.5416V17.9688C13.5416 18.5438 13.0751 19.0104 12.5 19.0104C11.9249 19.0104 11.4584 18.5438 11.4584 17.9688V13.5416H7.03125C6.45618 13.5416 5.98965 13.0751 5.98965 12.5C5.98965 11.9249 6.45618 11.4584 7.03125 11.4584H11.4584V7.03125C11.4584 6.45618 11.9249 5.98965 12.5 5.98965C13.0751 5.98965 13.5416 6.45618 13.5416 7.03125V11.4584H17.9688C18.5438 11.4584 19.0104 11.9249 19.0104 12.5C19.0104 13.0751 18.5438 13.5416 17.9688 13.5416Z" fill="#0e2859"></path></svg> -->
      </div>
      
      
      <div class="single-item">
        <router-link class="menu-item" to="/profile-menu">
          <svg _ngcontent-smartarz-client-c59="" width="22" height="26" viewBox="-42 0 512 512.001" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c59="" d="m210.351562 246.632812c33.882813 0 63.21875-12.152343 87.195313-36.128906 23.96875-23.972656 36.125-53.304687 36.125-87.191406 0-33.875-12.152344-63.210938-36.128906-87.191406-23.976563-23.96875-53.3125-36.121094-87.191407-36.121094-33.886718 0-63.21875 12.152344-87.191406 36.125s-36.128906 53.308594-36.128906 87.1875c0 33.886719 12.15625 63.222656 36.128906 87.195312 23.980469 23.96875 53.316406 36.125 87.191406 36.125zm-65.972656-189.292968c18.394532-18.394532 39.972656-27.335938 65.972656-27.335938 25.996094 0 47.578126 8.941406 65.976563 27.335938 18.394531 18.398437 27.339844 39.980468 27.339844 65.972656 0 26-8.945313 47.578125-27.339844 65.976562-18.398437 18.398438-39.980469 27.339844-65.976563 27.339844-25.992187 0-47.570312-8.945312-65.972656-27.339844-18.398437-18.394531-27.34375-39.976562-27.34375-65.976562 0-25.992188 8.945313-47.574219 27.34375-65.972656zm0 0"></path><path _ngcontent-smartarz-client-c59="" d="m426.128906 393.703125c-.691406-9.976563-2.089844-20.859375-4.148437-32.351563-2.078125-11.578124-4.753907-22.523437-7.957031-32.527343-3.3125-10.339844-7.808594-20.550781-13.375-30.335938-5.769532-10.15625-12.550782-19-20.160157-26.277343-7.957031-7.613282-17.699219-13.734376-28.964843-18.199219-11.226563-4.441407-23.667969-6.691407-36.976563-6.691407-5.226563 0-10.28125 2.144532-20.042969 8.5-6.007812 3.917969-13.035156 8.449219-20.878906 13.460938-6.707031 4.273438-15.792969 8.277344-27.015625 11.902344-10.949219 3.542968-22.066406 5.339844-33.042969 5.339844-10.96875 0-22.085937-1.796876-33.042968-5.339844-11.210938-3.621094-20.300782-7.625-26.996094-11.898438-7.769532-4.964844-14.800782-9.496094-20.898438-13.46875-9.753906-6.355468-14.808594-8.5-20.035156-8.5-13.3125 0-25.75 2.253906-36.972656 6.699219-11.257813 4.457031-21.003906 10.578125-28.96875 18.199219-7.609375 7.28125-14.390625 16.121094-20.15625 26.273437-5.558594 9.785157-10.058594 19.992188-13.371094 30.339844-3.199219 10.003906-5.875 20.945313-7.953125 32.523437-2.0625 11.476563-3.457031 22.363282-4.148437 32.363282-.679688 9.777344-1.023438 19.953125-1.023438 30.234375 0 26.726562 8.496094 48.363281 25.25 64.320312 16.546875 15.746094 38.4375 23.730469 65.066406 23.730469h246.53125c26.621094 0 48.511719-7.984375 65.0625-23.730469 16.757813-15.945312 25.253906-37.589843 25.253906-64.324219-.003906-10.316406-.351562-20.492187-1.035156-30.242187zm-44.90625 72.828125c-10.933594 10.40625-25.449218 15.464844-44.378906 15.464844h-246.527344c-18.933594 0-33.449218-5.058594-44.378906-15.460938-10.722656-10.207031-15.933594-24.140625-15.933594-42.585937 0-9.59375.316406-19.066407.949219-28.160157.617187-8.921874 1.878906-18.722656 3.75-29.136718 1.847656-10.285156 4.199219-19.9375 6.996094-28.675782 2.683593-8.378906 6.34375-16.675781 10.882812-24.667968 4.332031-7.617188 9.316407-14.152344 14.816407-19.417969 5.144531-4.925781 11.628906-8.957031 19.269531-11.980469 7.066406-2.796875 15.007812-4.328125 23.628906-4.558594 1.050781.558594 2.921875 1.625 5.953125 3.601563 6.167969 4.019531 13.277344 8.605469 21.136719 13.625 8.859375 5.648437 20.273437 10.75 33.910156 15.152344 13.941406 4.507812 28.160156 6.796875 42.273437 6.796875 14.113282 0 28.335938-2.289063 42.269532-6.792969 13.648437-4.410156 25.058594-9.507813 33.929687-15.164063 8.042969-5.140624 14.953125-9.59375 21.121094-13.617187 3.03125-1.972656 4.902344-3.042969 5.953125-3.601563 8.625.230469 16.566406 1.761719 23.636719 4.558594 7.636719 3.023438 14.121093 7.058594 19.265625 11.980469 5.5 5.261719 10.484375 11.796875 14.816406 19.421875 4.542969 7.988281 8.207031 16.289062 10.886719 24.660156 2.800781 8.75 5.15625 18.398438 7 28.675782 1.867187 10.433593 3.132812 20.238281 3.75 29.144531v.007812c.636719 9.058594.957031 18.527344.960937 28.148438-.003906 18.449219-5.214844 32.378906-15.9375 42.582031zm0 0"></path></svg>
          <div class="single-item-name">{{trans._getMessage('Profile') }}</div>
        </router-link>
      </div>
      
      
      <div class="single-item" >
          

        <router-link to="/more" class="menu-item"  >
        <i class="fas fa-ellipsis-h-alt ellipse"></i>
          <!-- <img src="/images/ellipsis-circle.png" width="35" /> -->
          <div class="single-item-name" style="margin-top: -8px;">{{trans._getMessage('More') }}</div>
        </router-link>
      </div>
      
      <!-- <div class="single-item dropup more-dropdown" >
          <div class="dropdown-menu" :class="{'text-right' : $store.getters.rtl}" >
            <router-link to="/contact-us" class="dropdown-item"> <i :class="{'mr-2' : $store.getters.ltr, 'ml-2' : $store.getters.rtl}" class="fas fa-headphones-alt"></i> {{trans._getMessage('Contact us')}}</router-link>
            <router-link to="/terms-and-condition" class="dropdown-item" > <i :class="{'mr-2' : $store.getters.ltr, 'ml-2' : $store.getters.rtl}" class="fal fa-question-circle"></i> {{trans._getMessage('Terms And Conditions')}} </router-link>
            <a href="/change-language/en"  class="dropdown-item" v-if="$store.getters.rtl">> <i :class="{'mr-2' : $store.getters.ltr, 'ml-2' : $store.getters.rtl}" class="fas fa-language"></i> English</a>
            <a href="/change-language/ar"  class="dropdown-item" v-if="$store.getters.ltr"> <i :class="{'mr-2' : $store.getters.ltr, 'ml-2' : $store.getters.rtl}" class="fas fa-language"></i> العربية</a>
          </div>

        <a class="menu-item" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
          <img src="/images/ellipsis-white.png" width="35" />
          <div class="single-item-name" style="margin-top: -8px;">{{trans._getMessage('More') }}</div>
        </a>
      </div> -->
  </div>
</div>

</template>

<script>
export default {
  created(){

    this.$root.$refs.bottom_navbar = this
    this.getGenres();
    // console.log(this.trans._getMessage('Our Products') , 'LANG TEST')
  },
  mounted(){
    if(this.$router.history.current.path == '/' && this.$store.getters.getGenreStatus){
        this.openGenreModal();
        // console.log('openGenreModal')
        this.$store.commit('setGenreStatus' , false)
    }
  },
  data(){
    return{
        showGenre: false,
        loadingGenres: false,
        genres : []
    }
  },
  watch:{
    // openGenre(){
    //   if(this.openGenre){
    //     this.openGenreModal();
    //   }
    // }
  },
  props:{
    openGenre:{

    }
  },
  methods:{
    getGenres(){
      this.loadingGenres = true
      axios.post('/api/category/all-details')
      .then( res => {
        this.genres = res.data.genres;
        this.loadingGenres = false
      }).catch( err => {
        this.loadingGenres = false
        console.log(err)
      })
    },
    

    chooseGenra(genre){
      console.log(genre)
      this.closeModal();
      this.$router.push('/search-listings/'+ genre.id );
    },
    openGenreModal(){
      this.showGenre = true;
      $('body').css('overflow' , 'hidden')
    },
    closeModal(){
        $('body').css('overflow' , 'auto')
        this.showGenre = false;
    },

  }
}
</script>

<style>
/* .bottom-nav .sub-category-listing{
  padding: 0 30px 30px 0 !important;
} */
.bottom-nav .genre-image{
  width: 35px;
  height: 35px;
  margin: 0 10px;
}

.bottom-nav .sub-category-listing{
  min-height: 300px;
}

.more-dropdown .dropdown-item i{
  color: #0088ff;
}
.more-dropdown .dropdown-item{
  padding: 7px 15px;
  border-bottom: 1px solid #e4e4e4;
}
.more-dropdown{
  color: black !important;
}
</style>