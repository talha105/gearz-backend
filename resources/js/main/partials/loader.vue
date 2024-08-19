<template> 

<div>
    <div class="loading-parent" :style="'width: '+ width + '; height: '+ height" >
        <b-spinner :small="small" :style="'border-width:' + border_width" label="Loading..."></b-spinner>
    </div>
</div>
</template>

<script>
    export default {
        props:{
            font_size : 23, 
            width : {
                type: String,
                default: '100%'
                // default: 'auto'
            }, 
            height : {
                type: String,
                default: '100%'
                // default: 'auto'
            }, 
            border_width : {
                type: String,
                default: 'initial'
            }, 
            small:{
                type: Boolean,
                default: true,
            }
        },
        data() {
            return {
               
            }
        },
    }
</script>

<style lang="sass" scoped>
    .loader-container
        display: flex
        justify-content: center
        align-items: center
        font-weight: 300
    
    .loading-parent
        position: absolute
        background-color: #ffffff70
        left: 0
        top: 0
        width: 100%
        height: 100%
        display: flex
        justify-content: center
        align-items: center
        z-index: 5
        
    .loader    
        z-index: 301
        // display: flex
        justify-content: center
        align-items: center
        // font-size: 23px
        // background: #0000009c
        color: inherit
</style>