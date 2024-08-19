<template>
  <button  @click="clicked" :class="'btn position-relative ' +color + '  '  + size" :style="'min-width: ' + min_width + '; min-height: ' + min_heigt"  >
        <loader v-if="loading" class="text-black" :small="size" ></loader>
        <span v-else> <i :class="icon"></i> {{ title }} </span>
        <!-- <slot name="content">
        </slot> -->
            <!-- Content To Come Here -->
  </button>
</template>

<script>
export default {
    props:{
        loading : {
            default: false
        },
        title:{

        },
        icon:{

        },
        size:{

        },
        min_width:{
            type: String,
            default: 'auto'
        },
        min_heigt:{
            type: String,
            default: 'auto'
        },
        color:{
            type: String,
            default: ''
        },
        _color:{

        },
    },
    methods:{
        clicked () {
            this.$emit('action-button-clicked')
        }
    }
}
</script>

<style>

</style>