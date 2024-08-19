<template>

<div>

    <router-view :key="$route.path" ></router-view>

</div>
</template>

<script>
export default {
    props:{
        locale:{
    
        },
    },
    mounted(){
        if(this.$store.getters.isAuthenticated){
            this.checkCurrentUser();
        }

        console.log(this.locale)
        if(!this.$route.path == '/'){
            this.getAllBanners()
        }
        if(this.locale){
            this.$store.commit('localeUpdate' , this.locale )
        }else{
            this.$store.commit('localeUpdate' , 'en' )
        }

        // if(this.$store.getters.isAuthenticated){
        //     var diff = this.$options.filters.diffInHours(this.$store.getters.isAuthenticated.last_login) ;
        //     console.log(diff)
        //     if(diff > 24){
        //         // this.$store.commit('logout')
        //     }
        // }
    },
    methods:{
        getAllBanners(){
            axios.post('/api/banner/all')
            .then( res => {
                this.$store.commit('setBanners' , res.data.banners)
            }).catch( err => {
                console.log(err)
            })
        },

        checkCurrentUser(){
            
            axios.post('/api/check-current-user', {
                user_id : this.$store.getters.isAuthenticated.id,
                last_login : this.$store.getters.isAuthenticated.last_login
            })
            .then( res => {
                console.log(res)
            }).catch( err => {
                this.$store.commit('logout');
                this.$router.push('/')
                // console.log(err.response)
                // console.log(err)
            })

        }

    }
}
</script>

<style>

</style>