<template>
    <div class="profile">
        <div class="container">

        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 col-12 offset-md-3">
                <form id="" action="" autocomplete="off" >
                    <div class="profile-image-box">
                        <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog"  class="profile-image" />

                        <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />

                        <div class="mt-4 form-group">
                            <v-select placeholder="Select City" class="md-form-select" :options="cities" >
                                <template #open-indicator="{ attributes }">
                                    <span class="select-open-indicator" v-bind="attributes"> <img src="/img/down-arrow.png" /> </span>
                                </template>

                            </v-select>
                        </div>
                    </div>


                    <div class="mt-4 form-group">
                        <input class="mb-form-control" type="text"  autocomplete="off" placeholder="Name" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control"  value="" type="email"  autocomplete="off" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="tel"  autocomplete="off" placeholder="Phone" />
                    </div>
                    <div class="form-group">
                        <textarea  autocomplete="off" placeholder="About us" class="mb-form-control" rows="6"></textarea>
                    </div>

                    <hr>
                    <div class="form-group">
                        <input class="mb-form-control" type="password"  autocomplete="off" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="password"  autocomplete="off" placeholder="Confirm Password" />
                    </div>
                    <div class="form-group">
                        <button type="button" @click="loading = !loading" class="update-btn btn">
                            <b-spinner v-if="loading"></b-spinner>
                            <span v-else> <i class="fas fa-save"></i> UPDATE </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- <div class="row">
            <div class="col-md-4 col-lg-6 col-sm-12 col-12">
                <form autocomplete="off">
                    <div class="profile-image-box">
                        <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog"  class="profile-image" />

                        <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />
                    </div>


                    <div class="mt-4 form-group">
                        <v-select :options="cities" ></v-select>
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="email"  autocomplete="off" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="tel"  autocomplete="off" placeholder="Phone" />
                    </div>
                    <hr>
                    <div class="form-group">
                        <textarea  autocomplete="off" placeholder="About us" class="mb-form-control" rows="6"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="password"  autocomplete="off" placeholder="Confirm Password" />
                    </div>
                    <div class="form-group">
                        <button class="update-btn btn">UPDATE</button>
                    </div>
                </form>
            </div>
            
            <div class="col-md-4 col-lg-6 col-sm-12 col-12 ">
                <form autocomplete="off">
                    <div class="profile-image-box">
                        <img :src="newImageSrc ? newImageSrc : imagePlaceholder" @click="selectImageDialog"  class="profile-image" />

                        <input type="file" @change="imageSelected" ref="category_image" id="category_image" class="d-none" />


                    </div>
                    <div class="mt-4 form-group">
                        <input class="mb-form-control" type="text"  autocomplete="off" placeholder="Name" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="email"  autocomplete="off" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="tel"  autocomplete="off" placeholder="Phone" />
                    </div>
                    <hr>
                    <div class="form-group">
                        <input class="mb-form-control" type="password"  autocomplete="off" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input class="mb-form-control" type="password"  autocomplete="off" placeholder="Confirm Password" />
                    </div>
                    <div class="form-group">
                        <button class="update-btn btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div> -->
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            loading: false,
            cities:['Lahore' , 'Karachi'],
            newImageSrc: '',
            imagePlaceholder: '/img/no-image-found.jpg',
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


    }
}
</script>

<style>

</style>