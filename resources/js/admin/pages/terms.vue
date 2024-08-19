<template>
<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title">Manage Contact Details</h5>
    </div>
    <div class="card-body position-relative">
        <loader :small="false" v-if="loading"></loader>
        <div class="contact-details">
            
            
            <div class="row mt-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label>English Terms and Conditions</label>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                    <quill-editor
                        class="w-100"
                        ref="myQuillEditor"
                        required
                        v-model="content"
                    />
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label>Arabic Terms and Conditions</label>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                    <quill-editor
                        class="w-100"
                        ref="myQuillEditor"
                        v-model="ar_content"
                    />
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-12  text-center">
                    <button type="button" @click="updateContactDetails" class="btn btn-success"><i class="fas fa-edit"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill
        }
    },

    created(){
        this.getPageData();
    },
    data(){
        return{
            content: "",
            ar_content: "",
            page: "",
            loading: false,
        }
    },
    methods:{
        getPageData(){
            this.loading = true
            axios.post('/api/page-data' , {
                slug: 'terms-and-condition'
            }).then( res => {
                this.loading = false

                if(res.data.page){
                    this.page = res.data.page;
                    this.content = res.data.page.content;
                    this.ar_content = res.data.page.ar_content;
                }
                this.page = res.data.page;
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
        },
        updateContactDetails(){
            this.loading = true
            axios.post('/api/update-terms-details' , {
                page_id: this.page.id,
                content: this.content ,
                ar_content: this.ar_content ,
            }).then( res => {
                this.loading = false
                this.$toastr.success('Terms Updated')
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
        }
    }
}
</script>
