<template>


<div class="categories">
      <div class="row">
        <div class="col-md-12" style="padding:10px" >
            <div class="card ">
                <div class="card-header">
                </div>
                <!-- /.card-header -->
                <div class="card-body position-relative table-wrapper block-wrapper">
                    <loader v-if="loading" :small="false"></loader>

                    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                        <li v-for="(tab,index) in tabs" :key="index" class="nav-item screen-nav-item" role="presentation">
                            <a
                                :class="{'active': tab.active}"
                                class="nav-link"
                                :id="`ex3-tab-${index}`"
                                data-mdb-toggle="tab"
                                :href="`#ex3-tabs-${index}`"
                                role="tab"
                                :aria-controls="`ex3-tab-${index}`"
                                aria-selected="true"
                                @click="tab.active = true"
                            >{{tab.text}}</a
                            >
                        </li>

                        </ul>
                        <!-- Tabs navs -->

                        <!-- Tabs content -->
                        <div class="tab-content" id="ex2-content">
                                <!-- show active -->
                            <div
                                :class="{'show active': tab.active}"
                                class="tab-pane fade"
                                :id="`ex3-tabs-${index}`"
                                role="tabpanel"
                                :aria-labelledby="`ex3-tab-${index}`"
                                v-for="(tab,index) in tabs"
                                :key="index"
                            >
                                <div class="row">
                                    <div
                                    :class="{
                                        'col-12': tab.multiple || tab.imager,
                                        'col-sm-12 col-12 col-md-4 col-lg-4 text-center offset-md-4': !tab.multiple && !tab.imager,
                                    }"
                                    >

                                        <MultiImage
                                            v-if="tab.multiple"
                                            :slug="tab.slug"
                                            :contentKey="tab.arabic ? 'ar_content' : 'content'"
                                        ></MultiImage>
                                        <screen-image
                                            v-else-if="!tab.imager"
                                            :contentKey="tab.arabic ? 'ar_content' : 'content'"
                                            :vertical="tab.vertical"
                                            :slug="tab.slug"
                                        ></screen-image>
                                        <ImageSize v-if="tab.imager" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tabs content -->

                </div>
            </div>

        </div>
    </div>











</div>
</template>

<script>
import screenImage from '../partials/screen-image.vue'
import MultiImage from '../partials/MultiImage.vue'
import ImageSize from './ImageSize.vue'

export default {
  components: { screenImage, MultiImage, ImageSize },
    data() {
        return {
            loading: false,
            tabs: [
                {
                    text: 'Splash Screen',
                    active: true,
                    vertical: true,
                    slug: 'splash-screen'
                },
                {
                    text: 'Login Screen',
                    active: false,
                    multiple: true,
                    slug: 'login-screen'
                },
                {
                    text: 'Register Screen',
                    active: false,
                    multiple: true,
                    slug: 'register-screen'
                },
                {
                    text: 'Arabic Splash Screen',
                    active: false,
                    vertical: true,
                    arabic: true,
                    slug: 'splash-screen'
                },
                {
                    text: 'Arabic Login Screen',
                    active: false,
                    multiple: true,
                    arabic: true,
                    slug: 'login-screen'
                },
                {
                    text: 'Arabic Register Screen',
                    active: false,
                    multiple: true,
                    arabic: true,
                    slug: 'register-screen'
                },
                {
                    text: 'Listing Default',
                    active: false,
                    slug: 'listing-default-image'
                },
                {
                    text: 'Image Sizes',
                    active: false,
                    imager: true,
                    slug: 'item-images-sizes'
                }
            ]
        }
    }
}
</script>
<style>
.screen-nav-item{
    min-width: 200px;
}
</style>
