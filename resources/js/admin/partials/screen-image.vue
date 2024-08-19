<template>
    <div class=" position-relative">
        <loader :small="false" v-if="loading"></loader>
        <div class="scree-image-container">
                <img
                    :src="newImageSrc ? newImageSrc : currentLogo"
                    @click="selectImageDialog"
                    class="screen-image"
                    :class="{'vertical':vertical}"
                />

                <div class="d-flex justify-content-center align-center">
                    <button class="btn btn-success w-100 mt-2 me-1" type="button" @click="selectImageDialog" >Upload</button>
                    <button :disabled="!new_image" class="btn btn-primary w-100 mt-2 ms-1" type="button" @click="updateLogo" >Save</button>
                </div>

                <input type="file" @change="imageSelected" ref="category_image" :id="inputID" class="d-none" />
        </div>
    </div>
</template>

<script>
export default {
    props:{
        slug: {
            type: String,
            default: ''
        },
        vertical:{
            type: Boolean,
            default: false
        },
        contentKey:{
            type: String,
            default: 'content'
        }
    },
    computed:{
        inputID(){
            return `${this.slug}-${Math.random().toString(36).substring(2)}`
        }
    },
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
            console.log('this.id', this.inputID, $(`#${this.inputID}`))
            $(`#${this.inputID}`).click()
        },
        getPageData(){
            this.loading = true
            axios.get(`/api/mobile/${this.slug}`).then( res => {
                this.loading = false
                if(res.data.page[this.contentKey]){
                    this.currentLogo = '/storage/pages/' + res.data.page[this.contentKey];

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
            fd.append('contentKey', this.contentKey)

            axios.post(`/api/mobile/${this.slug}`, fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function(progressEvent) {
                }.bind(this),
            })
            .then(response => {
                this.$toastr.success('Image updated successfully');
                this.loading = false;
            })
            .catch(error => {
                this.loading = false
                this.$toastr.error(error.response.data.message);
            })

        },

    }
}
</script>
<style>

.admin .screen-image.vertical{
    height: 500px !important;
}
.admin .screen-image{
    width: 100%;
    height: 250px;
    cursor: pointer;
    border-radius: 3px;
    object-fit: contain;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
}
@media screen and (max-width:768px) {
    .admin .screen-image{
        width: 100%;
        height: 170px;
        cursor: pointer;
        border-radius: 3px;
        object-fit: cover;
    }
}

</style>
