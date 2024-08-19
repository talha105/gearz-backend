<template>
  
</template>

<script>
export default {
    methods:{
        closeModal(){
            $('body').css('overflow' , 'auto')
            this.currentCategory = '';
            this.showSubcategoies = false;
        },

    }
}
</script>

<style>

</style>