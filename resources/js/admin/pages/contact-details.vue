<template>
<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title">Manage Contact Details</h5>
    </div>
    <div class="card-body position-relative">
        <loader :small="false" v-if="loading"></loader>
        <div class="contact-details">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2 text-right">
                    <label>Email</label>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="form-control" v-model="email" placeholder="Email" />
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2 text-right">
                    <label>Phone</label>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 ">
                    <input class="form-control" v-model="phone" placeholder="Phone" />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-sm-12 text-center">
                    <button type="button" @click="updateContactDetails" class="btn btn-success"><i class="fas fa-edit"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    created(){
        this.getPageData();
    },
    data(){
        return{
            page: "",
            info: "",
            phone: "",
            email: "",
            loading: false,
        }
    },
    methods:{
        getPageData(){
            this.loading = true
            axios.post('/api/page-data' , {
                slug: 'contact-us-details'
            }).then( res => {
                this.loading = false

                if(res.data.page && res.data.page.content){
                    this.info = JSON.parse(res.data.page.content)
                    this.phone = this.info.phone
                    this.email = this.info.email
                }
                this.page = res.data.page;
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
        },
        updateContactDetails(){
            this.loading = true
            axios.post('/api/update-contact-details' , {
                slug: 'contact-us-details',
                phone: this.phone ,
                email: this.email ,
                page_id: this.page.id ,
            }).then( res => {
                this.loading = false
                this.$toastr.success('Contact Updated')
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
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
