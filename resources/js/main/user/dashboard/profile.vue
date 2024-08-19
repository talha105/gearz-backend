<template>
  <div class="mz--dashboard dashboard-profile">
      <div class="container-fluid mt-4">

      <div class="row">


        <div class="col-12 col-sm-12 col-md-12 col-lg-12 column-2nd" :class="{'right-area' : $store.getters.ltr , 'left-area' : $store.getters.rtl }" >

        <div class="smz-box">
            <div class="smz-box-title">
                {{ trans._getMessage('Update Profile')}}
            </div>
          <!-- right-area -->
            <form @submit.prevent="updateSeller" v-if="profile.seller">
                <div class="row">
                    <div class="col-12 pb-4">
                    <div class="form-group position-relative change-image text-center">
                        <span class="position-relative">
                            <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog"  class="profile-image" />
                            <i class="fas fa-pencil-alt edit-icon" @click="selectImageDialog"></i>
                        </span>

                        <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12" :class="{'first-col' : $store.getters.ltr , 'second-col' : $store.getters.rtl}">
                    
                    <div class="form-group">
                        <input v-model="user.name" name="text"  type="text" class="form-control" required autocomplete="off" :placeholder="trans._getMessage('Name')">
                    </div>
                    <div class="form-group ">
                        <v-select v-model="user.city" :clearable="false" :placeholder="trans._getMessage('Select City')" required :options="cities" >
                        </v-select>
                    </div>

                    <div class="form-group">
                        <input v-model="user.phone" name="text"  type="tel" class="form-control" required autocomplete="off" :placeholder="trans._getMessage('Phone')">
                    </div>
                    
                    <div class="form-group">
                        <input v-model="user.email" name="email"  type="text" class="form-control" required autocomplete="off" disabled :placeholder="trans._getMessage('Email')">
                    </div>

                    <div class="form-group">
                        <textarea v-model="user.about" class="form-control" :placeholder="trans._getMessage('About Your Business')" rows="5" required  ></textarea>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-12"  :class="{'second-col' : $store.getters.ltr , 'first-col' : $store.getters.rtl}"  >

                    <div class="form-group">
                        <input v-model="user.password" type="password" class="form-control" autocomplete="off" :placeholder="trans._getMessage('Password')" >
                    </div>

                    <div class="form-group">
                        <input v-model="user.confirm_password" name="password"  type="password"  class="form-control"  autocomplete="off" :placeholder="trans._getMessage('Confirm Password')" >
                    </div>
                    <div class="form-group" v-if="passwordMismatch">
                        <div class="text-danger">{{trans._getMessage('Password does not match')}}</div>
                    </div>

                    <!-- <hr> -->
                    <div class="addEventForm ">
                        <div class="docs-heading">{{trans._getMessage('Business Documents')}}</div>
                        <!-- <hr> -->
                        <div class="files-container" :class="{'justify-content-center' : user.files.length == 0}">

                            <div class="file-item" v-for="(file, index) in user.files" :key="index">
                                <i class="fad fa-file-alt file-icon"></i>
                                <div class="file-name"> {{file.name}} </div>

                                <span @click="deleteFile(file)" class="image-center-button delete"> <i class="fas fa-times"></i> </span>
                            </div>
                            <div :class="{ 'w-100' : user.files.length == 0 }">
                                <div @click="inputFile()" class="file-dropzone-small image-box"  @drop.prevent="filesDropped" @dragover.prevent  @dragenter="isDragging = true" @dragleave="isDragging = false" @mouseleave="isDragging = false" :class="{'is-dragging': isDragging , 'file-center-dropzone small-height-dropzone':user.files.length == 0 }" >
                                    <h2> <i class="fas fa-upload"></i> </h2>
                                    <span>{{trans._getMessage('Upload/Drag and Drop Files')}}</span>
                                    
                                </div>
                                <input style="display: none" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" type="file" ref="fileInput" id="avatarCropInput" @change="filesSelected" multiple>
                            </div>
                        </div>
                        </div>
                    </div>

                <div class="col-12 text-center"   >
                    <div class="form-group last mt-3">
                        <button type="submit" :disabled="loading" class="btn mb-btn-100 update-btn" >
                            <b-spinner small v-if="loading"></b-spinner>
                            <i v-else class="fas fa-edit"></i> 
                            <span class="ml-1"> {{trans._getMessage('Update')}}</span>
                        </button>
                    </div>
                </div>

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
            loadingProfile: false,
            loading: false,
            passwordMismatch: false,
            isDragging: false,
            success: false,
            cities:[
                this.trans._getMessage('Abu Dhabi') , 
                this.trans._getMessage('Al Ain') , 
                this.trans._getMessage('Ajman') , 
                this.trans._getMessage('Dubai') , 
                this.trans._getMessage('Fujairah') , 
                this.trans._getMessage('Sharjah') , 
                this.trans._getMessage('Ras Al Khaimah')
                ],
            newImageSrc: '',
            imagePlaceholder: '/images/profile-placeholder.jpg',
            // imagePlaceholder: '/img/camera.png',
            login_form:{
                email: "",
                password: "",
            },
            profile:"",
            user:{
                email:'',
                password:'',
                confirm_password:'',
                phone:'',
                name:'',
                city:'',
                files:[],
                _files:[],
            },
        // acceptedTypes: ['file/gif', 'image/jpg', 'image/jpeg', 'image/png'],

        }
    },
    created(){
        this.fetchUserProfile();
    },
    methods:{
        fetchUserProfile(){
            this.loadingProfile = true
            axios.post('/api/profile' , {
                user_id: this.$route.query.user_id,
            } ).then( res => {
                this.profile = res.data.user
                this.user.name = res.data.user.name
                this.user.email = res.data.user.email
                this.user.name = res.data.user.name
                this.user.phone = res.data.user.phone

                if(this.profile.seller){
                    
                    this.user.about = res.data.user.seller.about
                    this.user.city = this.trans._getMessage(res.data.user.seller.city)
                    res.data.user.seller.docs.map( doc => {
                        this.user.files.push({ name :doc});
                    } )

                    if(res.data.user.seller.logo){
                        this.newImageSrc =  '/storage/sellers/' + res.data.user.seller.logo
                    }
                }
                this.loadingProfile = false

            }).catch( err => {
                this.loadingProfile = false
                console.log(err)
            })
        },
        selectImageDialog(){
            $('#category_image').click()
        },
        imageSelected(event){
            let file = event.target.files[0]
            if(!file) return;
            // console.log(file)
            this.new_image = file
            let src = URL.createObjectURL(file)
            this.newImageSrc = src
        },

        login(){
            this.loading = true;
            axios.post('/api/seller-login' , {
                email : this.login_form.email,
                password : this.login_form.password
            })
            .then( res => {
                this.loading = false
                this.$store.commit('login' , res.data.user);
                this.$router.push('/profile-menu')
                console.log(res)
            }).catch(err => {
                this.loading = false
                // console.log(err)
                this.$toastr.error(err.response.data.message);

            })
        },
        updateSeller(){
            if(this.user.password != this.user.confirm_password){
                this.passwordMismatch = true
            }else{

            let logo = this.new_image;
            let files = [];
            this.user.files.map( file => {
                files.push(file.name);
            } )

            this.loading = true;

            var fd = new FormData();
            fd.append('user_id', this.$route.query.user_id)
            fd.append('image', logo ? logo : "")
            fd.append('email', this.user.email)
            fd.append('phone', this.user.phone)
            fd.append('city', this.user.city)
            fd.append('name', this.user.name)
            fd.append('about', this.user.about)

            if(this.user.password && this.user.password == this.user.confirm_password){
                fd.append('password', this.user.password)
            }
            if(files.length){
                files.map(file => {
                    fd.append('docs[]', file)
                })
            }
            if(this.user._files.length){
                this.user._files.map(file => {
                    fd.append('_docs[]', file)
                })
            }

            this.loading = true;
            axios.post('/api/seller-update' , fd ,
            {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
            .then( res => {
                this.loading = false

                // this.$router.push('/profile-menu')
                // this.$store.commit('login' , res.data.user);
                this.success = true
                console.log(res)
                this.$toastr.success(this.trans._getMessage('Profile Updated'));
            }).catch(err => {
                this.loading = false
                console.log(err)
                this.$toastr.error(err.response.data.message);

            })
        }
        
        },
        
        





            filesDropped(event) {
                let droppedFile = event.dataTransfer.files; // extract dropped files
                if(!droppedFile) return;
                this.handleFiles(([...droppedFile]))         
            },
            filesSelected(event)
            {
                let files = event.target.files 
                if(!files) return;
                this.handleFiles(([...files]))
            },

            handleFiles(files)
            {
                files.forEach(file => {
                    // if(this.isValid(file)){
                    if(true){
                        console.log(file)
                        this.user.files.push({ name : file.name})
                        this.user._files.push(file);
                    }
                    else{
                        this.$toastr.error('Please Select Only Images');
                        console.log("invalid file") // please handle this error
                    }

                });

            },

            deleteCurrentFile(file){
                this.user._files.splice(this.user._files.indexOf(file) , 1)
            },
            deleteFile(file){
                this.user.files.splice(this.user.files.indexOf(file) , 1)
            },

            isValid(file)
            {
                return this.acceptedTypes.includes(file.type)
            },
            inputFile()
            {
                this.$refs.fileInput.click()
            },



    }
}
</script>
<style>

.dashboard-profile .update-btn{
    max-width: 400px;
    width: 100%;
}
.dashboard-profile{
    padding-bottom: 100px;
}
.dashboard-profile .files-container{
    margin-top: 10px;
}
.dashboard-profile .small-height-dropzone{
    height: 175px !important;
}
.dashboard-profile .docs-heading{
    color: #7c7c7c;
    font-size: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 7px 0;
}



.dashboard-profile .first-col{
    padding-right: 5px;
}
.dashboard-profile .second-col{
    padding-left: 5px;
}

@media screen and (max-width:768px){
    .dashboard-profile .first-col{
        padding-right: 15px;
    }
    .dashboard-profile .second-col{
        padding-left: 15px;
    }
}

</style>