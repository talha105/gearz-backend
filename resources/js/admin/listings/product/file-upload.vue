<template>
<div class="">

  <div v-if="product.file" class="current-file-details">
      <div class="current-file-heading">Current File Details</div>
      <div class="current-file">
      <div class="file-name">
        {{product.file.src}}
      </div>
      <div class="file-upload-date">
        {{product.file.proper_date_time}}
      </div>
      <div class="file-btn-area">
        <a :href="'/api/download-file/'+product.file.id" class="btn btn-sm btn-primary" >Download <i class="fas fa-download"></i> </a>
        <!-- <a @click="downloadFile" href="javascript:;" class="btn btn-sm btn-primary" >Download <i class="fas fa-download"></i> </a> -->
        <a @click="removeFile" :disabled="loading" href="javascript:;" class="loading-btn btn btn-sm btn-danger" >
          <loader v-if="loading" ></loader>
          <span v-if="!loading">  Remove <i class="fas fa-times"></i> </span>  </a>
      </div>
    </div>
  </div>
      

  <div  v-else>
    <uploader :options="options" class="uploader-example" @file-complete="fileComplete" @complete="complete" ref="uploader" @change="changed" @file-added="fileAdded($event)" @file-progress="fileProgress" @is-uploading="isUploading"  @is-complete="isComplete" @error="showError" :fileStatusText="fileStatusText" @fileComplete="fileCompleted"  >
      <uploader-unsupport></uploader-unsupport>
      <uploader-drop>
        <uploader-btn :single="true" v-if="!is_file_selected" >select files</uploader-btn>
      </uploader-drop>
      <uploader-list></uploader-list>
    </uploader>
  </div>

  

<div class="col-md-12 text-right mt-4">
    <button @click="$emit('next-step')" class="btn btn-success">Next <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
</div>

</div>
</template>

<style scoped>
.current-file .file-name{
  width: 50%;
}
.current-file .file-upload-date{
  width: 30%;
}
.current-file .file-btn-area{
  width: 20%;
}
.current-file-heading{
    font-size: 20px;
    margin-bottom: 10px;
}
.current-file-details{
    color: #515151;
}
.current-file{
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

<script>
export default {
    watch:{
      product_id(){
        console.log(this.product_id , 'Parent Updated')
        this.product_id = this.product_id;
      }
    },
    props:['product' , 'product_id'],
    computed: {
            csrf() {
                return 0
            //     return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            },
    },
    data () {
      return {
        is_file_selected: false,
        isUploading: false,
        isComplete: false,
        file: '',
        error: '',
        loading: false,
        // fileStatusText : '',
        uploaderInstance : '',
        options: {
          // https://github.com/simple-uploader/Uploader/tree/develop/samples/Node.js
          target: '/api/upload-product-file/'+this.product_id,
          testChunks: false,
        },
        attrs: {
          accept: '*'
        //   accept: 'image/*'
        }
      }
    },
    methods: {

      downloadFile(){

        axios.post('/api/download-file' , {
          file_id: this.product.file.id
        } ).then( res => {
          console.log( res )
        }).catch( err => {
          console.log(err)
        })
      },

      removeFile(){
        this.loading = true;
        axios.post('/api/delete-file' , {
          file_id: this.product.file.id
        }).then( res => {
          console.log( res )
          this.product.file = '';
          this.is_file_selected = false;
          this.loading = false;

        }).catch( err => {
          this.loading = false;

          console.log(err)
          
        })
      },



    fileAdded(file){
        console.log(file , 'fileAdded')
        // file.ignored = true
        this.is_file_selected = true;

        // return false
    },
    fileProgress($rootFile, $file, $chunk){
        console.log($rootFile, $file, $chunk)

        // console.log(this.uploaderInstance.isUploading() , 'isUploading');

    },
    changed($event){
        // console.log($event.target.files[0] , 'changed')
    },
    fileRemoved($file){
        console.log($file , 'removed')
        this.$emit('uploading-status' , true) 
    },
    showError($error){
        console.log($error , 'error')
    },

    fileCompleted(file){
      console.log('File complete' , file)
    },
    fileStatusText(status, response) {

        console.log(status, response , 'fileStatusText')
        
        const statusTextMap = {
            uploading: 'uploading',
            paused: 'paused',
            waiting: 'waiting'
        }
        console.log(status , response);
        if (status === 'success' || status === 'error') {
            // only use response when status is success or error
            console.log(status , 'status'  , response , response.file)

            this.file = response.file;
            // eg:
            // return response data ?
            return response.data
        } else {
            return statusTextMap[status]
        }
        },

      complete () {
        // debugger
        console.log('complete', arguments)
        this.product.file = this.file;
        this.$emit('uploading-status' , false) 
      },
      fileComplete () {
        //   this.is_file_selected = true;
        console.log('file complete', arguments)
      }
    },
    mounted () {
    //   this.$nextTick(() => {
    //     window.uploader = this.$refs.uploader.uploader
    //   })

        // var uploader = new this.$uploader({
        //     target: '/api/photo/redeem-upload-token', 
        //     query: { upload_token: 'my_token' }
        //     })
        //     // Uploader isn't supported, fall back on a different method
        //     if (!uploader.support) location.href = '/some-old-crappy-uploader'

            this.uploaderInstance = this.$refs.uploader.uploader
            // const uploaderInstance = this.$refs.uploader.uploader
            // now you can call all uploader methods
            // https://github.com/simple-uploader/Uploader#methods




    }

}
</script>
<style>
  /* .uploader-example {
    width: 880px;
    padding: 15px;
    margin: 40px auto 0;
    font-size: 12px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .4);
  }
  .uploader-example .uploader-btn {
    margin-right: 4px;
  }
  .uploader-example .uploader-list {
    max-height: 440px;
    overflow: auto;
    overflow-x: hidden;
    overflow-y: auto;
  } */
</style>
