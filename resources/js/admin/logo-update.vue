<template>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title">Update Logo</h5>
    </div>
    <div class="card-body position-relative">
        <loader :small="false" v-if="loading"></loader>
        <div class="contact-details logo-box">
            <div class="form-group row">
            <div class="col-sm-12 col-12 col-md-4 col-lg-4 text-center offset-md-4">
                <img :src="newImageSrc ? newImageSrc : currentLogo" @click="selectImageDialog" class="upload-category-image" />
                <button class="btn btn-success w-100 mt-2" type="button" @click="selectImageDialog" >Upload</button>
                
                <button :disabled="!new_image" class="btn btn-primary w-100 mt-2" type="button" @click="updateLogo" >Save</button>

                <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
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
            imagePlaceholder: '/images/GEARZ.png',
            currentLogo: '/images/GEARZ.png',
            new_image: '',
            newImageSrc: '',
            loading: false,
        }
    },
    created(){
        this.getPageData();
    },
    methods:{
        imageSelected(event){
            let file = event.target.files[0]
            if(!file) return;
            // console.log(file)
            this.new_image = file
            let src = URL.createObjectURL(file)
            this.newImageSrc = src
        },

        selectImageDialog(){
            $('#category_image').click()
        },
        getPageData(){
            this.loading = true
            axios.post('/api/page-data' , {
                slug: 'logo',
            }).then( res => {
                this.loading = false
                if(res.data.page.content){
                    this.currentLogo = '/images/' + res.data.page.content;

                    this.new_image = ''
                    this.newImageSrc = ''
                }
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
        },
        updateLogo()
        {            
            let file = this.new_image;
            this.loading = true;

            var fd = new FormData();
            fd.append('image', file)
            fd.append('slug', 'logo')

            axios.post('/api/update-logo', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.loading = false;
            })
            .catch(error => {
                this.loading = false
            })

        },

    }
}
</script>

<style>
.logo-box .upload-category-image{
    height: 200px !important;
    object-fit: contain !important;
}
</style>