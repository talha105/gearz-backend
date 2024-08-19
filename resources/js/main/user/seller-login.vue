<template>
  <div class="login-page">
      <div class="container">
        <div class="row mb-0">
            <div class="col-12">
                <div class="login-area">
                    <div class="mt-tabs">
                        <div class="mt-tab  first" v-if="$store.getters.ltr" :class="{'active' : isLogin }"  @click="isLogin = true" >{{trans._getMessage('Login')}}</div>
                        <div class="mt-tab second" v-if="$store.getters.ltr" :class="{'active' : !isLogin }" @click="isLogin = false" >{{trans._getMessage('Register')}}</div>
                        <div class="mt-tab  third" v-if="$store.getters.rtl" :class="{'active' : isLogin }"  @click="isLogin = true" >{{trans._getMessage('Login')}}</div>
                        <div class="mt-tab forth" v-if="$store.getters.rtl" :class="{'active' : !isLogin }" @click="isLogin = false" >{{trans._getMessage('Register')}}</div>
                    </div>
                
                    <div class="login-box" v-if="isLogin" >
                        <div class="login-box-heading">
                            <i class="fal fa-user-tag"></i>
                            <!-- <i class="fas fa-user-lock"></i> -->
                            {{trans._getMessage('Seller Login')}}
                        </div>
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <input  name="email" v-model="login_form.email" type="text" class="mb-form-control" :placeholder="trans._getMessage('Email')" required autocomplete="off" >
                            </div>
                            
                            <div class="form-group">
                                <input  name="password" v-model="login_form.password" type="password" class="mb-form-control" :placeholder="trans._getMessage('Password')" required autocomplete="off" >
                            </div>
                            <div class="seller-link"><router-link to="/user-login" > <i class="fal fa-sign-in-alt"></i>  {{trans._getMessage('Login as A User')}} </router-link></div>

                            <div class="form-group last">
                                <button type="submit" class="btn mb-btn-100">
                                    <b-spinner small v-if="loading"></b-spinner>
                                    <i v-else class="fal fa-sign-in-alt"></i> 
                                    <span class="ml-1"> {{trans._getMessage('Login')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
            <div class="login-box" v-if="!isLogin" >

                <div class="login-box-heading" v-if="!success">
                    <i class="fal fa-user-plus"></i>
                    {{trans._getMessage('Seller Signup')}}
                </div>

                <form @submit.prevent="register" v-if="!success">

                    <div class="form-group position-relative change-image text-center">
                        <span class="position-relative">
                            <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog"  class="profile-image" />
                            <i class="fas fa-pencil-alt edit-icon" @click="selectImageDialog"></i>
                        </span>

                        <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
                    </div>

                    <div class="form-group">
                        <input v-model="register_form.name" name="text"  type="text" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Name')">
                    </div>
                    <div class="form-group ">
                        <v-select v-model="register_form.city" :clearable="false" :placeholder="trans._getMessage('Select City')" class="md-form-select" required :options="cities" >
                            <template #open-indicator="{ attributes }">
                                <span class="select-open-indicator" v-bind="attributes"> <img src="/img/down-arrow.png" /> </span>
                            </template>

                        </v-select>
                    </div>

                    <div class="form-group">
                        <input v-model="register_form.phone" name="text"  type="tel" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Phone')">
                    </div>
                    
                    <div class="form-group">
                        <input v-model="register_form.email" name="email"  type="text" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Email')">
                    </div>

                    <div class="form-group">
                        <textarea v-model="register_form.about" class="mb-form-control" :placeholder="trans._getMessage('About Your Business')" rows="5" required  ></textarea>
                    </div>

                    
                    <div class="form-group">
                        <input v-model="register_form.password" type="password" class="mb-form-control" required autocomplete="off" :placeholder="trans._getMessage('Password')" >
                    </div>

                    <div class="form-group" v-if="passwordMismatch">
                        <div class="text-danger">{{trans._getMessage('Password does not match')}}</div>
                    </div>
                    <div class="form-group">
                        <input v-model="register_form.confirm_password" name="password"  type="password" required class="mb-form-control"  autocomplete="off" :placeholder="trans._getMessage('Confirm Password')" >
                    </div>

                    <!-- <div class="seller-link">Registered as User ? <router-link to="/user-login" > <i class="fal fa-sign-in-alt"></i>  Login here </router-link></div> -->

                    <hr>
                    <div class="addEventForm">
                        <div class="docs-heading">{{trans._getMessage('Business Documents')}}</div>
                        <div class="docs-small-text">{{trans._getMessage('Trade license, business registration documents, proof of id')}}</div>
                        <div class="files-container" :class="{'justify-content-center' : register_form.files.length == 0}">
                            <div class="file-item" v-for="(file, index) in register_form.files" :key="index">
                                <i class="fad fa-file-alt file-icon"></i>
                                <div class="file-name"> {{file.name}} </div>

                                <span @click="deleteImg(file)" class="image-center-button delete"> <i class="fas fa-times"></i> </span>
                            </div>
                            <div :class="{ 'w-100' : register_form.files.length == 0 }">
                                <div @click="inputFile()" class="file-dropzone-small image-box"  @drop.prevent="filesDropped" @dragover.prevent  @dragenter="isDragging = true" @dragleave="isDragging = false" @mouseleave="isDragging = false" :class="{'is-dragging': isDragging , 'file-center-dropzone':register_form.files.length == 0 }" >
                                    <h2> <i class="fas fa-upload"></i> </h2>
                                    <span>{{trans._getMessage('Upload/Drag and Drop Files')}}</span>
                                    
                                </div>
                                <input style="display: none" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" type="file" ref="fileInput" id="avatarCropInput" @change="filesSelected" multiple>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group last">
                        <button type="submit" class="btn mb-btn-100">
                            <b-spinner small v-if="loading"></b-spinner>
                            <i v-else class="fas fa-plus"></i> 
                            <span class="ml-1"> {{trans._getMessage('Submit')}}</span>
                        </button>
                    </div>

                </form>
                <div v-if="success" class="text-success success-message">{{trans._getMessage('Your Account is Registered, You will be able to login once admin approves')}}</div>
                <div class="text-center" v-if="success" >
                </div>
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
            // imagePlaceholder: '/img/logo-icon.png',
            // imagePlaceholder: '/img/camera.png',
            login_form:{
                email: "",
                password: "",
            },
            register_form:{
                email:'',
                password:'',
                confirm_password:'',
                phone:'',
                name:'',
                logo:'',
                about:'',
                city: this.trans._getMessage('Abu Dhabi') ,
                files: [] ,
                _files: [] ,
            },
        // acceptedTypes: ['file/gif', 'image/jpg', 'image/jpeg', 'image/png'],

        }
    },
    methods:{
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
        register(){
            if(this.register_form.password != this.register_form.confirm_password){
                this.passwordMismatch = true
                this.$toastr.error('Password not match');
            }else{

            let logo = this.new_image;
            let files = [];
            this.loading = true;

            var fd = new FormData();
            fd.append('image', logo ? logo : "")
            fd.append('email', this.register_form.email)
            fd.append('password', this.register_form.password)
            fd.append('phone', this.register_form.phone)
            fd.append('city', this.register_form.city)
            fd.append('name', this.register_form.name)
            fd.append('about', this.register_form.about)
            if(this.register_form.files.length){
                this.register_form.files.map(file => {
                    fd.append('docs[]', file)
                })
            }

            this.loading = true;
            axios.post('/api/seller-register' , fd ,
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
                        this.register_form.files.push(file)
                        this.register_form._files.push({
                            name: file.name,
                            file,
                        });
                    }
                    else{
                        this.$toastr.error('Please Select Only Images');
                        console.log("invalid file") // please handle this error
                    }

                });

            },

            deleteImg(file){
                this.register_form.files.splice(this.register_form.files.indexOf(file) , 1)
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

.login-box .success-message{
    font-size: 20px;
    margin-top: 45px;
    text-align: center;
}
.login-box textarea.mb-form-control{
    height: 100px;
}
.login-box .vs__dropdown-toggle{
    padding: 1px 0 7px !important;
}
.edit-icon{
    color: #0e2859;
    font-size: 20px;
    position: absolute;
    bottom: -50px;
    right: -10px;
    background-color: #e3e3e3;
    border-radius: 200%;
    padding: 9px;
    cursor: pointer;
}
.login-box-heading{
    color: #0e2859;
    font-size: 25px;
    text-align: center;
    margin-bottom: 20px;
}
.login-page .last{
    margin-bottom: -5px;
}

.login-page{
    background-color: #fafafa;
    min-height: 100vh;
    height: 100%;
    padding-bottom: 100px;
}
.login-box .docs-heading{
    font-size: 20px;
    color: #848484;
}

.login-box .docs-small-text{
    margin-bottom: 13px;
    font-size: 14px;
    color: #75758b;
}

.login-box{
    background-color: white;
    padding: 20px;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
    border-radius: 2px;
    margin-top: 50px;
    min-height: 200px;
}
/* .login-page button{
    float: right;
    background-color: #0e2859 !important;  
} */
.login input{
    padding: 10px 15px;
    border: 1px solid #cecece;
    border-radius: 5px;
    width: 100%;
}

input.valid:not([type]), input.valid:not([type]):focus, input.valid[type=text]:not(.browser-default), input.valid[type=text]:not(.browser-default):focus, input.valid[type=password]:not(.browser-default), input.valid[type=password]:not(.browser-default):focus, input.valid[type=email]:not(.browser-default), input.valid[type=email]:not(.browser-default):focus, input.valid[type=url]:not(.browser-default), input.valid[type=url]:not(.browser-default):focus, input.valid[type=time]:not(.browser-default), input.valid[type=time]:not(.browser-default):focus, input.valid[type=date]:not(.browser-default), input.valid[type=date]:not(.browser-default):focus, input.valid[type=datetime]:not(.browser-default), input.valid[type=datetime]:not(.browser-default):focus, input.valid[type=datetime-local]:not(.browser-default), input.valid[type=datetime-local]:not(.browser-default):focus, input.valid[type=tel]:not(.browser-default), input.valid[type=tel]:not(.browser-default):focus, input.valid[type=number]:not(.browser-default), input.valid[type=number]:not(.browser-default):focus, input.valid[type=search]:not(.browser-default), input.valid[type=search]:not(.browser-default):focus, textarea.materialize-textarea.valid, textarea.materialize-textarea.valid:focus, .select-wrapper.valid>input.select-dropdown{
    border-color: #0e2859;
}
/* label focus color */
.login-page .login-area {
    max-width: 500px;
    width: 100%;
    margin-left: auto;
    margin-right: auto;
}
.login-page .form-group input[type=text]:focus + label {
    color: #0e2859;
}
/* label underline focus color */
.login-page .form-group input[type=text]:focus {
    border-bottom: 1px solid #0e2859;
    box-shadow: 0 1px 0 0 #0e2859;
}

/* label focus color */
.login-page .form-group input:focus + label {
    color: #0e2859 !important;
}
/* label underline focus color */
.login-page .row .form-group input:focus {
    border-bottom: 1px solid #0e2859 !important;
    box-shadow: 0 1px 0 0 #0e2859 !important
}
.mt-tabs .mt-tab.first{
    border-radius: 50px 0 0 50px;
}
.mt-tabs .mt-tab.second{
    border-radius: 0 50px 50px 0;
}
.mt-tabs .mt-tab.third{
    border-radius: 0 50px 50px 0;
}
.mt-tabs .mt-tab.forth{
    border-radius: 50px 0 0 50px;
}
.mt-tabs .mt-tab.active{
    background-color: #0e2859;
    color: white;
}
.mt-tabs .mt-tab:hover{
    background-color: #0e28591f;
    color: #0e2859;
}
.mt-tabs .mt-tab{
    color: #0e2859;
    background-color: #ffffff;
    border: 1px solid #0e2859;
    width: 49%;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-size: 20px;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 10%);
}
.mt-tabs{
    width: 100%;
    margin-top: 20vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
     
</style>