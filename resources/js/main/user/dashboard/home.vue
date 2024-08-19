<template>
  <div class="mz--dashboard dashboard-home">
      <div class="container-fluid mt-4">

      <div class="row">
   

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 column-2nd" :class="{'left-area' : $store.getters.getCurrentLocale && $store.getters.getCurrentLocale == 'ar' , 'right-area' : !$store.getters.getCurrentLocale || $store.getters.getCurrentLocale == 'en' }" >
          <!-- right-area -->
          <div class="seller-stats">
              <div class="smz-box stats-box" :class="{'ml-0' : $store.getters.ltr , 'mr-0' : $store.getters.rtl}">
                <div class="smz-box-title-with-border text-primary">
                  {{trans._getMessage('Total Ads')}}
                </div>

                <div class="stats-number text-primary">
                  {{stats['all']}}
                </div>
              </div>

              <div class="smz-box stats-box">
                <div class="smz-box-title-with-border text-danger">
                  {{trans._getMessage('Pending Ads')}}
                </div>

                <div class="stats-number text-danger">
                  {{stats['pending']}}

                </div>
              </div>

              <div class="smz-box stats-box">
                <div class="smz-box-title-with-border text-success">
                  {{trans._getMessage('Approved Ads')}}
                </div>

                <div class="stats-number text-success">
                  {{stats['approved']}}

                </div>
              </div>
              
          </div>

        </div>
    </div>

      </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      stats:{
        approved: 0,
        draft: 0,
        all: 0,
        pending: 0,
      },
    }
  },
  mounted(){
    this.getSellerStats();
  },
  methods:{
    getSellerStats(){
      axios.post('/api/seller-stats' , {
        user_id : this.$route.query.user_id,
      })
      .then(res => {
        // console.log(res)
        this.stats = res.data.stats;

      }).catch( err => {
        console.log(err)
      })
    }
  }
}
</script>

<style>

</style>