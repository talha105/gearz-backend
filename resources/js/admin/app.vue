<template>
<div>
    <!-- <div class="alert alert-danger text-center mt-3" v-if="current_admin && current_admin.is_admin && !$store.getters.isAuthorized" >You are not Authorized for this page</div> -->
    <!-- {{current_admin_permissions}} -->
    <router-view></router-view>
</div>

</template>

<script>

import axios from 'axios';

export default {
    props:{
        current_admin:{

        },
        current_admin_permissions:{

        },
        token:{
            type: String,
            default: ""
        }
    },
    mounted(){
        // console.log(this.$store.getters.isAuthorized);
        // console.log(this.current_admin)
        if(this.current_admin){
            this.$store.commit('setCurrentAdmin' , this.current_admin );
        }
        if(this.current_admin_permissions){
            this.$store.commit('setCurrentAdminPermissions' , this.current_admin_permissions );
        }
        if(this.current_admin_permissions){
            axios.defaults.headers.Authorization = `Bearer ${this.token}`
        }
    }
}
</script>

<style>

</style>
