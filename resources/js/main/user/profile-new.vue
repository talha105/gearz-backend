<template>



  <div class="login-page">
      <div class="container">
        <div class="row mb-0">
            <div class="col-12">
                <div class="login-area">
                <div class="login-box">
                <loader :small="false" v-if="loadingProfile"></loader>
                    <div class="login-box-heading">
                        <i class="fal fa-user-cog"></i>
                        {{trans._getMessage('My Profile')}}
                    </div>

                    <form  @submit.prevent="updateUser"  autocomplete="off" >
                        <div class="form-group">
                            <input  required v-model="user.name" name="text"  type="text" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Name')">
                        </div>

                        <div class="form-group">
                            <input name="text" required v-model="user.phone" type="tel" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Phone')">
                        </div>
                        
                        <div class="form-group">
                            <input  name="email" required v-model="user.email" type="text" class="mb-form-control" disabled autocomplete="off" :placeholder="trans._getMessage('Email')">
                        </div>
                        <hr>
                        <div class="form-group">
                            <input  name="password" v-model="user.password" type="password" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Password')" >
                        </div>

                        <div class="form-group">
                            <input  name="password" v-model="user.confirm_password" type="password" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Confirm Password')" >
                        </div>
                        <div class="form-group">
                            <div class="text-danger" v-if="passwordMismatch">{{trans._getMessage('Password Not Matched')}}</div>
                        </div>

                        <div class="form-group last">
                            <button type="submit" :disabled="loading" class="btn mb-btn-100">
                                <b-spinner small v-if="loading"></b-spinner>
                                <i v-else class="fas fa-edit"></i> 
                                <span class="ml-1"> {{trans._getMessage('Update')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 offset-md-3 col-sm-12 col-12" v-if="profile.seller">



                <div class="login-box">

                    <div class="login-box-heading">
                        <i class="fal fa-user-cog"></i>
                        {{trans._getMessage('My Profile')}}
                    </div>

                    <form @submit.prevent="updateSeller" v-if="profile.seller">
                    <div class="form-group position-relative change-image text-center">
                        <span class="position-relative">
                            <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog"  class="profile-image" />
                            <i class="fas fa-pencil-alt edit-icon" @click="selectImageDialog"></i>
                        </span>

                        <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
                    </div>
                    
                    <div class="form-group">
                        <input v-model="user.name" name="text"  type="text" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Name')">
                    </div>
                    <div class="form-group ">
                        <v-select v-model="user.city" :clearable="false" :placeholder="trans._getMessage('Select City')" class="md-form-select" required :options="cities" >
                            <template #open-indicator="{ attributes }">
                                <span class="select-open-indicator" v-bind="attributes"> <img src="/img/down-arrow.png" /> </span>
                            </template>

                        </v-select>
                    </div>

                    <div class="form-group">
                        <input v-model="user.phone" name="text"  type="tel" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Phone')">
                    </div>
                    
                    <div class="form-group">
                        <input v-model="user.email" name="email"  type="text" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Email')">
                    </div>

                    <div class="form-group">
                        <textarea v-model="user.about" class="mb-form-control" :placeholder="trans._getMessage('About Your Business')" rows="5" required  ></textarea>
                    </div>

                    <div class="form-group">
                        <input v-model="user.password" type="password" class="mb-form-control" autocomplete="off" :placeholder="trans._getMessage('Password')" >
                    </div>

                    <div class="form-group">
                        <input v-model="user.confirm_password" name="password"  type="password"  class="mb-form-control"  autocomplete="off" :placeholder="trans._getMessage('Confirm Password')" >
                    </div>
                    <div class="form-group" v-if="passwordMismatch">
                        <div class="text-danger">{{trans._getMessage('Password does not match')}}</div>
                    </div>

                    <hr>
                    <div class="addEventForm ">
                        <div class="docs-heading">{{trans._getMessage('Business Documents')}}</div>
                        <hr>
                        <div class="files-container" :class="{'justify-content-center' : user.files.length == 0}">

                            <div class="file-item" v-for="(file, index) in user.files" :key="index">
                                <i class="fad fa-file-alt file-icon"></i>
                                <div class="file-name"> {{file.name}} </div>

                                <span @click="deleteFile(file)" class="image-center-button delete"> <i class="fas fa-times"></i> </span>
                            </div>
                            <div :class="{ 'w-100' : user.files.length == 0 }">
                                <div @click="inputFile()" class="file-dropzone-small image-box"  @drop.prevent="filesDropped" @dragover.prevent  @dragenter="isDragging = true" @dragleave="isDragging = false" @mouseleave="isDragging = false" :class="{'is-dragging': isDragging , 'file-center-dropzone':user.files.length == 0 }" >
                                    <h2> <i class="fas fa-upload"></i> </h2>
                                    <span>{{trans._getMessage('Upload/Drag and Drop Files')}}</span>
                                    
                                </div>
                                <input style="display: none" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" type="file" ref="fileInput" id="avatarCropInput" @change="filesSelected" multiple>
                            </div>
                        </div>
                    </div>
                <div class="form-group last mt-3">
                    <button type="submit" :disabled="loading" class="btn mb-btn-100">
                        <b-spinner small v-if="loading"></b-spinner>
                        <i v-else class="fas fa-edit"></i> 
                        <span class="ml-1"> {{trans._getMessage('Update')}}</span>
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
                user_id: this.$store.getters.isAuthenticated.id,
            } ).then( res => {
                this.profile = res.data.user
                this.user.name = res.data.user.name
                this.user.email = res.data.user.email
                this.user.name = res.data.user.name
                this.user.phone = res.data.user.phone

                if(this.profile.seller){
                    
                    this.user.about = res.data.user.seller.about
                    this.user.city = res.data.user.seller.city
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
        updateUser(){
            if((this.user.password && this.user.password == this.user.confirm_password) || !this.user.password){
                this.passwordMismatch = false
                    this.loading = true
                    axios.post('/api/user-update' , {
                        user_id: this.$store.getters.isAuthenticated.id,
                        name : this.user.name,
                        password : this.user.password,
                        phone : this.user.phone,
                    }).then( res => {
                        this.loading = false
                        console.log(res)
                        this.$toastr.success(this.trans._getMessage('Profile Updated'));
                    }).catch( err => {
                        this.loading = false
                        this.$toastr.error(this.trans._getMessage('Profile Update Failed'));
                        console.log(err)
                    })
                }else{
                this.passwordMismatch = true

            }
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
            fd.append('user_id', this.$store.getters.isAuthenticated.id)
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

                // this.$store.commit('login' , res.data.user);
                // this.$router.push('/profile-menu')
                this.success = true
                console.log(res)
                this.$toastr.success('Profile Updated');
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
