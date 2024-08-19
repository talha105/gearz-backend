<template>
  <div class="login-page">
      <div class="container">
        <div class="row mb-0">
            <div class="col-12">
                <div class="login-area">
                    <div class="mt-tabs">
                        <div class="mt-tab  first" v-if="$store.getters.ltr" :class="{'active' : isLogin }"  @click="isLogin = true" >{{trans._getMessage('Login')}}</div>
                        <div class="mt-tab second" v-if="$store.getters.ltr" :class="{'active' : !isLogin }" @click="isLogin = false" >{{trans._getMessage('Register')}}</div>
                        <div class="mt-tab  third" v-if="$store.getters.rtl" :class="{'active' : isLogin }"  @click="isLogin = true" >{{trans._getMessage('Login')}}</div>
                        <div class="mt-tab forth" v-if="$store.getters.rtl" :class="{'active' : !isLogin }" @click="isLogin = false" >{{trans._getMessage('Register')}}</div>
                    </div>
                
                    <div class="login-box" v-if="isLogin" >
                        <div class="login-box-heading">
                            <i class="fal fa-user-lock"></i>
                            <!-- <i class="fas fa-user-lock"></i> -->
                            {{trans._getMessage('User Login')}}
                        </div>
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <input  name="email" v-model="login_form.email" type="text" class="mb-form-control" required :placeholder="trans._getMessage('Email')" autocomplete="off" >
                            </div>
                            
                            <div class="form-group">
                                <input  name="password" v-model="login_form.password" type="password" class="mb-form-control" required :placeholder="trans._getMessage('Password')" autocomplete="off" >
                            </div>
                            <div class="seller-link"><router-link to="/seller-login" > <i class="fal fa-sign-in-alt"></i>  {{trans._getMessage('Login as A Seller')}} </router-link></div>

                            <div class="form-group last">
                                <button type="submit" class="btn mb-btn-100">
                                    <b-spinner small v-if="loading"></b-spinner>
                                    <i v-else class="fal fa-sign-in-alt"></i> 
                                    <span class="ml-1"> {{trans._getMessage('Login')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
            
            <div class="login-box" v-if="!isLogin" >

                <div class="login-box-heading">
                    <i class="fal fa-user-plus"></i>
                    {{trans._getMessage('User Signup')}}
                </div>

                <form @submit.prevent="register" >
                    <div class="form-group">
                        <input  required v-model="register_form.name" name="text"  type="text" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Name')">
                    </div>

                    <div class="form-group">
                        <input  name="text" required v-model="register_form.phone" type="tel" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Phone')">
                    </div>
                    
                    <div class="form-group">
                        <input  name="email" required v-model="register_form.email" type="text" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Email')">
                    </div>
                    
                    <div class="form-group">
                        <input  name="password" required v-model="register_form.password" type="password" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Password')" >
                    </div>

                    <div class="form-group">
                        <input  name="password" required v-model="register_form.confirm_password" type="password" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Confirm Password')" >
                    </div>
                    <div class="form-group">
                        <div class="text-danger" v-if="passwordMismatch">{{trans._getMessage('Password Not Matched')}}</div>
                    </div>

                    <div class="seller-link"><router-link to="/seller-login" > <i class="fal fa-sign-in-alt"></i>  {{trans._getMessage('Login as A Seller')}} </router-link></div>

                    <div class="form-group last">
                        <button type="submit" class="btn mb-btn-100">
                            <b-spinner small v-if="loading"></b-spinner>
                            <i v-else class="fas fa-plus"></i> 
                            <span class="ml-1"> {{trans._getMessage('Regsiter')}}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<bottom-nav></bottom-nav>

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
                this.$router.back();
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
                this.$router.back();

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
.login-box-heading{
    color: #0e2859;
    font-size: 25px;
    text-align: center;
    margin-bottom: 20px;
}
.wrapper{
    margin-bottom: 0 !important;
}
.login-page .seller-link{
    margin-bottom: 15px;
    color: #0e2859;
    font-size: 16px;
    float: right;
    font-weight: bold;
    }
.login-page .last{
    margin-bottom: -5px;
}

.login-page{
    background-color: #fafafa;
    min-height: 100vh;
    height: 100%;
    padding-bottom: 100px;
}
.login-box{
    background-color: white;
    padding: 20px;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
    border-radius: 2px;
    margin-top: 50px;
    min-height: 230px;
}
/* .login-page button{
    float: right;
    background-color: #0e2859 !important;  
} */
.login input{
    padding: 10px 15px;
    border: 1px solid #cecece;
    border-radius: 5px;
    width: 100%;
}

input.valid:not([type]), input.valid:not([type]):focus, input.valid[type=text]:not(.browser-default), input.valid[type=text]:not(.browser-default):focus, input.valid[type=password]:not(.browser-default), input.valid[type=password]:not(.browser-default):focus, input.valid[type=email]:not(.browser-default), input.valid[type=email]:not(.browser-default):focus, input.valid[type=url]:not(.browser-default), input.valid[type=url]:not(.browser-default):focus, input.valid[type=time]:not(.browser-default), input.valid[type=time]:not(.browser-default):focus, input.valid[type=date]:not(.browser-default), input.valid[type=date]:not(.browser-default):focus, input.valid[type=datetime]:not(.browser-default), input.valid[type=datetime]:not(.browser-default):focus, input.valid[type=datetime-local]:not(.browser-default), input.valid[type=datetime-local]:not(.browser-default):focus, input.valid[type=tel]:not(.browser-default), input.valid[type=tel]:not(.browser-default):focus, input.valid[type=number]:not(.browser-default), input.valid[type=number]:not(.browser-default):focus, input.valid[type=search]:not(.browser-default), input.valid[type=search]:not(.browser-default):focus, textarea.materialize-textarea.valid, textarea.materialize-textarea.valid:focus, .select-wrapper.valid>input.select-dropdown{
    border-color: #0e2859;
}
/* label focus color */
.login-page .form-group input[type=text]:focus + label {
    color: #0e2859;
}
/* label underline focus color */
.login-page .form-group input[type=text]:focus {
    border-bottom: 1px solid #0e2859;
    box-shadow: 0 1px 0 0 #0e2859;
}

/* label focus color */
.login-page .form-group input:focus + label {
    color: #0e2859 !important;
}
/* label underline focus color */
.login-page .row .form-group input:focus {
    border-bottom: 1px solid #0e2859 !important;
    box-shadow: 0 1px 0 0 #0e2859 !important
}

.mt-tabs .mt-tab.first{
    border-radius: 50px 0 0 50px;
}
.mt-tabs .mt-tab.second{
    border-radius: 0 50px 50px 0;
}
.mt-tabs .mt-tab.active{
    background-color: #0e2859;
    color: white;
}
.mt-tabs .mt-tab:hover{
    background-color: #0e28591f;
    color: #0e2859;
}
.mt-tabs .mt-tab{
    color: #0e2859;
    background-color: #ffffff;
    border: 1px solid #0e2859;
    width: 49%;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-size: 20px;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 10%);
}
.mt-tabs{
    width: 100%;
    margin-top: 20vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
     
</style>