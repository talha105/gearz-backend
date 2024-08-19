<template>
<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title">Change Password</h5>
    </div>
    <div class="card-body position-relative">
        <loader :small="false" v-if="loading"></loader>
        <div class="contact-details">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 text-right">
                    <label>Password</label>
                </div>
                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                    <input type="password" aria-placeholder="Password" class="form-control" v-model="password" placeholder="Password" />
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 text-right">
                    <label>Confirm Password</label>
                </div>
                <div class="col-12 col-sm-12 col-md-7 col-lg-7 ">
                    <input type="password" aria-placeholder="Confirm Password" class="form-control" v-model="confirm_password" placeholder="Confirm Password" />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-sm-12 text-center">
                    <button type="button" @click="updatePassword" class="btn btn-success"><i class="fas fa-lock"></i> Update </button>
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
            page: "",
            info: "",
            password: "",
            confirm_password: "",
            loading: false,
        }
    },
    methods:{
        updatePassword(){
            if(this.password  ==  this.confirm_password){
                this.loading = true
                axios.post('/api/update-admin-password' , {
                    password: this.password ,
                }).then( res => {
                    this.loading = false
                    this.$toastr.success('Password Updated')
                }).catch( err => {
                    this.loading = false
                    console.log(err)
                })
            }else{
                this.$toastr.error('Password does not match')
            }
        }
    }
}
</script>

<style>
.contact-details{
    padding: 35px 200px;
}
@media screen and (max-width:768px) {
    .contact-details{
        padding: 0;
    }
}
</style>
