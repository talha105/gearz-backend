<template>
    <div class="user-auth">
      <div class="container">
        <div class="row mb-0">
            <div class="col-md-6 offset-md-3 col-sm-12">

                <div class="login-box" v-if="isLogin" >
                    <div class="login-box-heading">
                        <i class="fal fa-user-lock"></i>
                        <!-- <i class="fas fa-user-lock"></i> -->
                        User Login
                    </div>
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <input  name="email" v-model="login_form.email" type="text" class="form-control" required autocomplete="off" >
                        </div>
                        
                        <div class="form-group">
                            <input  name="password" v-model="login_form.password" type="password" class="form-control" required autocomplete="off" >
                        </div>
                        <div class="seller-link">Registered as Seller ? <router-link to="/seller-login" > <i class="fal fa-sign-in-alt"></i>  Login here </router-link></div>

                        <div class="form-group last">
                            <button type="submit" class="btn mb-btn-100">
                                <b-spinner small v-if="loading"></b-spinner>
                                <i v-else class="fal fa-sign-in-alt"></i> 
                                <span class="ml-1"> Login</span>
                            </button>
                        </div>
                    </form>
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
            isLogin: true,
            loading: false,
            passwordMismatch: false,
            login_form:{
                email:'',
                password:'',
            },
            register_form:{
                email:'',
                password:'',
                confirm_password:'',
                phone:'',
                name:'',
            }
        }
    },
    methods:{
        login(){
            this.loading = true;
            axios.post('/api/login' , {
                email : this.login_form.email,
                password : this.login_form.password
            })
            .then( res => {
                this.loading = false
                this.$store.commit('login' , res.data.user);
                this.$router.push('/profile-menu')
                // console.log(res)
            }).catch(err => {
                this.loading = false
                // console.log(err)
                this.$toastr.error(err.response.data.message);

            })
        },
        register(){
            if(this.register_form.password != this.register_form.confirm_password){
                this.passwordMismatch = true
            }else{

            this.loading = true;
            axios.post('/api/user-register' , {
                email : this.register_form.email,
                password : this.register_form.password,
                phone : this.register_form.phone,
                name : this.register_form.name,
            })
            .then( res => {
                this.loading = false
                this.$store.commit('login' , res.data.user);
                this.$router.push('/profile-menu')

                console.log(res)
            }).catch(err => {
                this.loading = false
                console.log(err)
                this.$toastr.error(err.response.data.message);

            })
            }

        }
    }
}
</script>

<style>

</style>