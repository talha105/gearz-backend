<template>
  <div class="dashboard-left-panel">

        <div class="user-logo-box">
            <!-- <img src="/img/logo-icon.png" class="user-logo" /> -->

            <img :src="'/storage/sellers/' + $store.getters.isAuthenticated.seller.logo" v-if="$store.getters.isAuthenticated && $store.getters.isAuthenticated.seller.logo" class="user-logo" />

            <img v-else src="/images/profile-placeholder.jpg" class="user-logo" />
            


        </div>
      <!-- <img :src="$store.getters.isAuthenticated.seller.logo"  /> -->

        <div class="user-name"> {{$store.getters.isAuthenticated.name}} </div>


        <div class="menu-list">
            <router-link  to="/seller/home" class="menu-item">
                <i class="fas fa-stream" :class="{'mr-2' : $store.getters.ltr , 'ml-2' : $store.getters.rtl}" ></i> {{trans._getMessage('Listings')}}
            </router-link>
            <router-link  to="/seller/post-listing" class="menu-item">
                <i class="fas fa-layer-plus" :class="{'mr-2' : $store.getters.ltr , 'ml-2' : $store.getters.rtl}" ></i> {{trans._getMessage('Add Listing')}}
            </router-link>
            <router-link to="/seller/my-listings"  class="menu-item">
                <i class="fas fa-paste" :class="{'mr-2' : $store.getters.ltr , 'ml-2' : $store.getters.rtl}" ></i> {{trans._getMessage('My Listings')}}
            </router-link>
            <router-link to="/seller/profile"  class="menu-item">
                <i class="fas fa-user-cog" :class="{'mr-2' : $store.getters.ltr , 'ml-2' : $store.getters.rtl}" ></i> {{trans._getMessage('My Profile')}}
            </router-link>
            <a @click="logout" href="javascript:;"  class="menu-item no-border">
                <i class="fas fa-sign-out" :class="{'mr-2' : $store.getters.ltr , 'ml-2' : $store.getters.rtl}" ></i> {{trans._getMessage('Logout')}}
            </a>
        </div>
  </div>
</template>

<script>
export default {
    methods:{
        logout(){
            this.$store.commit('logout');
            this.$router.push('/')
        }
    }
}
</script>

<style>

</style>