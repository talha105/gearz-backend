<template>
<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title">Profile</h5>
    </div>
    <div class="card-body position-relative">
        <loader :small="false" v-if="loading"></loader>
        <div class="contact-details">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 text-right">
                    <label>Name</label>
                </div>
                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                    <input type="text" class="form-control" required v-model="name" placeholder="Name" />
                </div>
            </div>

            <div class="row mt-3">
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
                    <button type="button" @click="updatePassword" class="btn btn-success"><i class="fas fa-save"></i> Update </button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    mounted(){
        this.name = this.$store.getters.getCurrentAdmin.name;
        this.id = this.$store.getters.getCurrentAdmin.id;
    },
    data(){
        return{
            page: "",
            info: "",
            password: "",
            name: "",
            confirm_password: "",
            loading: false,
        }
    },
    methods:{
        updatePassword(){
            if( this.password && (this.password  ==  this.confirm_password) || !this.password){
                this.loading = true
                axios.post('/api/update-admin-profile' , {
                    password: this.password ,
                    name: this.name ,
                    id: this.id ,
                }).then( res => {
                    this.loading = false
                    this.password = ''
                    this.confirm_password = ''
                    this.$toastr.success('Profile Updated')
            this.$store.commit('setCurrentAdmin' , res.data.user );
                }).catch( err => {
                    this.loading = false
                    console.log(err)
                    this.$toastr.error('Profile update failed')
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
