<template>

<div class="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-12 col-sm-12 col-lg-5">
                <div class="left-text">
                    {{trans._getMessage('Feel free, to get in touch with us.Provide accurate information, so we can contact you')}}.
                    <br>

                    <div class="contact-icons">
                        <a href="#">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                                <div class="contact-item"> {{info.email}} </div>
                            </div>
                        </a>
                        <a href="#" class="mt-3">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                                <div class="contact-item"> {{info.phone}} </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-md-7 col-12 col-sm-12 col-lg-7">
                <div class="submitted-msg" v-if="submitted">
                    <div class="success-msg text-success">
                        {{trans._getMessage('Thanks for your interest')}}.
                        <br>
                        {{trans._getMessage('Our team will be looking to contact you in 24 hours ')}}
                    </div>
                </div>
                <form @submit.prevent="sendQuery" v-if="!submitted">
                    <div class="form-group">
                        <input class="form-control contact-us-input" v-model="query.name" :placeholder="trans._getMessage('Name *')" required />
                    </div>
                    <div class="form-group">
                        <input class="form-control contact-us-input" v-model="query.email" :placeholder="trans._getMessage('Email *')" type="email"  required/>
                    </div>
                    <div class="form-group">
                        <input class="form-control contact-us-input" v-model="query.phone" :placeholder="trans._getMessage('Mobile Number *')" type="tel" required />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control contact-us-input" v-model="query.message" :placeholder="trans._getMessage('Message *')" required ></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 offset-lg-3 col-lg-6 col-sm-12 col-12">
                            <button :disabled="!query.name || !query.email || !query.phone || !query.message" type="submit" class="mb-btn-100"> 
                                <b-spinner v-if="sending" small ></b-spinner>
                                <i class="fas fa-envelope" v-else></i>
                                Send</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

<bottom-nav></bottom-nav>

</div>

</template>

<script>
export default {
    created(){
        this.getPageData();
    },
    data(){
        return{
            info: {
                email: "",
                phone: "",
            },
            page: '',
            loading: false,
            sending: false,
            submitted: false,
            query:{
                name: "",
                email: "",
                phone: "",
                message: "",
            }
        }
    },
    methods:{
        sendQuery(){
            this.sending = true
            axios.post('/api/main/send-query' , this.query  )
            .then( res => {
                this.sending = false
                this.submitted = true
                console.log(res)
                this.query.name = ''
                this.query.email = ''
                this.query.phone = ''
                this.query.message = ''
            }).catch(err => {
                this.sending = false

            })
        },
        getPageData(){
            this.loading = true
            axios.post('/api/page-data' , {
                slug: 'contact-us-details'
            }).then( res => {
                this.loading = false
                if(res.data.page && res.data.page.content){
                    this.info = JSON.parse(res.data.page.content)
                }
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
        },

        // getPageData(){
        //     this.loading = true
        //     axios.post('/api/page-data' , {
        //         slug: 'terms-and-condition',
        //     }).then( res => {
        //         this.loading = false
        //         this.page = res.data.page;
        //     }).catch( err => {
        //         this.loading = false
        //         console.log(err)
        //     })
        // }
    }
}
</script>

<style>
.terms-and-conditions {
    position: relative;
    height: 100vh;

}
</style>