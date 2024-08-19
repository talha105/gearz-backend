<template>
    <div>
        <div class="row">
            <div class="offset-md-1 col-12 col-md-10">
                <h6 class="mt-3 mb-3">Sizes of Images in for the Mobile APP</h6>
            </div>
        </div>
        <div class="row mb-3" v-for="(size, index) in sizes" :key="index">
            <div class="border-bottom pb-1 offset-md-1 col-5 col-md-4">
                {{ size.name }}
            </div>
            <div class="border-bottom pb-1 col-5 col-md-4">
                {{ size.value }}
            </div>
            <div class="col-2 col-md-2 text-center">
                <button @click="removeItem(index)" v-permission="'manage image sizes'" class="btn btn-sm btn-danger rounded-2"> <i class="fas fa-minus"></i> </button>
            </div>

        </div>
        <div class="new-size-add" >
            <div v-permission="'manage image sizes'" class="row align-items-center">
                <div class="offset-md-1 col-5 col-md-4 p-0">
                    <input class="form-control" v-model="item.name" placeholder="Name" />
                </div>
                <div class="col-5 col-md-4">
                    <input class="form-control" v-model="item.value" placeholder="Size" />
                </div>
                <div class="col-2 col-md-2 text-center">
                    <button :disabled="!item.name || !item.value" @click="addItem" class="btn btn-sm btn-success rounded-2"> <i class="fas fa-plus"></i> </button>
                </div>
            </div>
            <div v-permission="'manage image sizes'" class="row mt-3">
                <div class="col-10 text-end">
                    <button @click="saveSizes" class="btn btn-success rounded-2">
                        <b-spinner v-if="loading" small ></b-spinner>
                        <i v-else class="fas fa-file"></i>
                        <span class="ms-1">Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            sizes:[],
            item:{
                name:'',
                value:'',
            },
            page: {},
        }
    },
    mounted(){
        this.getImagesSize()
    },
    methods:{
        getImagesSize(){
            axios.post(`/api/get-page`,{
                slug: 'image-sizes'
            }).then( res => {
                console.log('res', res)
                this.page = res.data.page
                if(res.data.page && res.data.page.content){
                    this.sizes = JSON.parse(res.data.page.content)
                }
            }).catch( err => {
                console.log('err', err)
                this.$toastr.error(err.response.data.message);
            })
        },
        saveSizes(){
            this.loading = true
            axios.post(`/api/pages/${this.page.id}/update`,{
                content: JSON.stringify(this.sizes),
            }).then( res => {
                this.loading = false
                console.log('res', res)
                this.$toastr.success('Data saved successfuly');
            }).catch( err => {
                this.loading = false
                console.log('err', err)
                this.$toastr.error(err.response.data.message);
            })
        },
        removeItem(index){
            this.sizes.splice(index, 1)
        },
        addItem(){
            this.sizes.push(Object.assign({}, this.item))
            this.item.name = ''
            this.item.value = ''
        }
    }
}
</script>

<style>

</style>
