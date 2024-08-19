
<template>
    <div class="row">
        <div class="col-md-12">
            <div class="addEventForm mt-5">

                    <div class="images-container" :class="{'justify-content-center' : files.length == 0}">
                        <div class="image-box" v-for="(image, index) in files" :key="index">
                            <img :src="image.url">
                            <div class="image-overlay">
                                
                                <span v-if="image.status == 'uploading'" class="image-center-button uploading">{{image.progress}}% <loader class="ml-2"></loader> </span>

                                <span @click="deleteImg(image)" v-if="image.status == 'success'" class="image-center-button delete"> <i class="fas fa-trash-alt"></i> </span>
                                
                                <span v-if="image.status == 'deleting'" class="image-center-button deleting"> <loader></loader> </span>
                                
                                <span v-if="image.status == 'failed'" @click="reUplaodImage(index , image)" class="image-center-button failed"> <i class="fas fa-history"></i> </span>

                                </div>
                        </div>
                        <div>
                            <div @click="inputFile()" class="dropzone-small image-box"  @drop.prevent="filesDropped" @dragover.prevent  @dragenter="isDragging = true" @dragleave="isDragging = false" @mouseleave="isDragging = false" :class="{'is-dragging': isDragging , 'center-dropzone':files.length == 0 }" >
                                <h2> <i class="fas fa-upload"></i> </h2>
                                <span>Upload/Drag and Drop Image Here</span>
                                
                            </div>
                            <input style="display: none" accept="image/*" type="file" ref="fileInput" id="avatarCropInput" @change="imageSelected" multiple>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right mt-4">
                    <button @click="$emit('next-step')" class="we-btn-dark-round">Next <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                </div>

        </div><!-- col -->
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                required: true
            },
            gallery_id:{
                required: true
            },
            photos:{
            }
        },
        
        data(){
            return {
                loading: false,
                isDragging: false,
                files: [],
                acceptedTypes: ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'],

            }
        },
        created(){
            this.photos.forEach( image => {
                this.files.push( { url: this.$options.filters.eventMedia(image.src ) , file: image , status: 'success' , server_file: image , uploadProgress: 100} )
            })
        },
        methods: {
            filesDropped(event) {
                let droppedFile = event.dataTransfer.files; // extract dropped files
                if(!droppedFile) return;
                this.handleFiles(([...droppedFile]))         
            },
            imageSelected(event)
            {
                let files = event.target.files 
                if(!files) return;
                this.handleFiles(([...files]))
            },

            handleFiles(files)
            {
                this.$emit('uploading-status' , true) 
                files.forEach(file => {
                    if(this.isValid(file))
                        this.processFile(file);
                    else{
                        this.$toastr.error('Please Select Only Images');
                        console.log("invalid file") // please handle this error
                    }

                });

            },
            processFile(file)
            {
                const index = this.addToFiles(file)
                this.postImage(file, index)
            },

            postImage(file, index)
            {
                
                this.files[index].status = 'uploading'; // Update file status to success
                
                var fd = new FormData();
                fd.append('image', file)
                fd.append('gallery_id', this.gallery_id)
                axios.post('/upload-event-photo', fd, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                    onUploadProgress: function(progressEvent) {
                        this.files[index].progress = parseInt( Math.round((progressEvent.loaded / progressEvent.total) * 100))
                    }.bind(this),
                })
                .then(response => {

                    this.files[index].file = response.data.media; // Update file status to success
                    this.files[index].status = 'success'; // Update file status to success
                    if(this.files.length - 1 == index){
                        this.$emit('uploading-status' , false) 
                    }
                    this.$toastr.info('Image Uploaded Successfully');
                })
                .catch(error => {
                    this.$toastr.error('Image Upload Failed');
                    this.files[index].status = 'failed'; // Update file status to success
                    console.log(error);
                    if(this.files.length - 1 == index){
                        this.$emit('uploading-status' , false) 
                    }

                    this.uploading = false
                })
            },

            deleteImg(image){
                image.status = 'deleting'

                 axios.post('/delete-event-img', {
                    media: image.file.id
                })
                .then(response => {
                    this.files.splice(this.files.indexOf(image) , 1)
                    this.$toastr.info('Image Removed');

                })
                .catch(error => {
                    console.log(error);
                    this.$toastr.error('Image Remove Failed');
                })
            },

            reUplaodImage(index , image){
                if(image.original_file){
                    this.postImage(image.original_file , index)
                }else{
                    this.files.splice(this.files.indexOf(image) , 1)
                }
            },

            remmoveImg(image){
                image.status = 'deleting'
                this.files.splice(this.files.indexOf(image) , 1)
                this.$toastr.info('Image Removed');
            },

            addToFiles(file)
            {
                
                let src = URL.createObjectURL(file)
                // console.log(src)
                const length = this.files.push({
                    file: null,
                    original_file: file,
                    name: file.name,
                    url: src,
                    status: 'uploading', // uploading, success, error
                    progress: 0 // Upload % 0-100
                })
                return length - 1; // index of the file in this.files[]
            },
            isValid(file)
            {
                return this.acceptedTypes.includes(file.type)
            },
            inputFile()
            {
                this.$refs.fileInput.click()
            },
            next()
            {
                this.$emit('post')
            },
            updateLocation(location)
            {
                console.log('update')
                this.inputs.lat = location.lat
                this.inputs.lng = location.lng
            }
        },
        
        
    }
</script>
