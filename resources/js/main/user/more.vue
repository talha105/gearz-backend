<template>
    <div class="" >
    <div class="profile-menu pt-5" >


        <div class="profile-box" >
            
            <router-link to="/contact-us" class="menu-item">
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <svg _ngcontent-smartarz-client-c161="" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" class="menu-item-icon"><path _ngcontent-smartarz-client-c161="" id="contact_us" data-name="contact us" d="M7.5,0A7.508,7.508,0,0,0,0,7.5v5.893A1.607,1.607,0,0,0,1.607,15H3.75a.536.536,0,0,0,.536-.536V9.107a.536.536,0,0,0-.536-.536H1.607a1.59,1.59,0,0,0-.536.1V7.5a6.429,6.429,0,1,1,12.857,0V8.67a1.589,1.589,0,0,0-.536-.1H11.25a.536.536,0,0,0-.536.536v5.357A.536.536,0,0,0,11.25,15h2.143A1.607,1.607,0,0,0,15,13.393V7.5A7.508,7.508,0,0,0,7.5,0ZM1.607,9.643H3.214v4.286H1.607a.536.536,0,0,1-.536-.536V10.179A.536.536,0,0,1,1.607,9.643Zm12.321,3.75a.536.536,0,0,1-.536.536H11.786V9.643h1.607a.536.536,0,0,1,.536.536Z" fill="#59d539"></path></svg>
                
                {{trans._getMessage('Contact us')}}
            </router-link>

            <router-link to="/terms-and-condition" class="menu-item">
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <svg _ngcontent-smartarz-client-c161="" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" class="menu-item-icon"><path _ngcontent-smartarz-client-c161="" id="terms_condition" data-name="terms &amp; condition" d="M7.47,11.748a.586.586,0,1,1,.586-.586A.586.586,0,0,1,7.47,11.748Zm.586-2.637V8.324A2.443,2.443,0,1,0,5.751,4.2a2.4,2.4,0,0,0-.742,1.742.586.586,0,1,0,1.172,0,1.237,1.237,0,0,1,.383-.9,1.3,1.3,0,0,1,.957-.361,1.265,1.265,0,0,1,.232,2.5,1.1,1.1,0,0,0-.869,1.075v.844a.586.586,0,1,0,1.172,0Zm3.324,4.808a.586.586,0,1,0-.607-1,6.384,6.384,0,1,1,1.982-1.9.586.586,0,1,0,.974.651A7.5,7.5,0,0,0,2.2,2.2,7.5,7.5,0,0,0,11.38,13.919Zm0,0" transform="translate(0.001 0)" fill="#d96bf3"></path></svg>
                
                {{trans._getMessage('Terms and Conditions')}}
            </router-link>
            
            <a v-if="$store.getters.getCurrentLocale == 'en'" href="/change-language/ar" class="menu-item no-border">
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <svg _ngcontent-smartarz-client-c161="" xmlns="http://www.w3.org/2000/svg" width="14.327" height="15" viewBox="0 0 14.327 15" class="menu-item-icon"><g _ngcontent-smartarz-client-c161="" id="language_-_english" data-name="language - english" transform="translate(-23.074 -4780)"><path _ngcontent-smartarz-client-c161="" id="Path_3958" data-name="Path 3958" d="M13.07,3.545H6.915L5.885.3a.422.422,0,0,0-.4-.3H1.261A1.291,1.291,0,0,0,0,1.318v8.818a1.291,1.291,0,0,0,1.259,1.318H5.887L6.908,14.69a.424.424,0,0,0,.4.31H13.07a1.291,1.291,0,0,0,1.259-1.318V4.863A1.291,1.291,0,0,0,13.07,3.545ZM1.261,10.576a.43.43,0,0,1-.42-.439V1.318a.43.43,0,0,1,.42-.439H5.184l3.079,9.7Zm6.932.879-.823,1.9-.6-1.9Zm5.3,2.227a.43.43,0,0,1-.42.439H7.961L9.227,11.2a.462.462,0,0,0,.016-.32L7.194,4.424H13.07a.43.43,0,0,1,.42.439Z" transform="translate(23.072 4780)" fill="#17ac5c"></path><path _ngcontent-smartarz-client-c161="" id="Path_3959" data-name="Path 3959" d="M64.689,122.639H63.46a.41.41,0,0,0,0,.819h.749a1.229,1.229,0,1,1-.289-1.279.41.41,0,1,0,.579-.579,2.048,2.048,0,1,0,.6,1.448A.41.41,0,0,0,64.689,122.639Z" transform="translate(-36.786 4663.063)" fill="#17ac5c"></path><path _ngcontent-smartarz-client-c161="" id="Path_3960" data-name="Path 3960" d="M305.018,211.892h-1.339v-.446a.446.446,0,1,0-.892,0v.446h-1.339a.446.446,0,0,0,0,.892h2.592a5.608,5.608,0,0,1-.8,1.4c-.076-.1-.152-.209-.224-.316a.446.446,0,1,0-.738.5c.125.184.256.363.387.533-.223.259-.443.493-.636.682a.446.446,0,1,0,.625.637c.015-.015.259-.255.584-.623.317.363.555.6.573.62a.446.446,0,0,0,.631-.631s-.278-.279-.626-.686a5.806,5.806,0,0,0,1.15-2.122h.053a.446.446,0,0,0,0-.892Z" transform="translate(-268.94 4574.482)" fill="#17ac5c"></path></g></svg>
                العربية
            </a>
                
                
            <a v-if="$store.getters.getCurrentLocale == 'ar'" href="/change-language/en" class="menu-item no-border">
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <svg _ngcontent-smartarz-client-c161="" xmlns="http://www.w3.org/2000/svg" width="14.327" height="15" viewBox="0 0 14.327 15" class="menu-item-icon"><g _ngcontent-smartarz-client-c161="" id="language_-_english" data-name="language - english" transform="translate(-23.074 -4780)"><path _ngcontent-smartarz-client-c161="" id="Path_3958" data-name="Path 3958" d="M13.07,3.545H6.915L5.885.3a.422.422,0,0,0-.4-.3H1.261A1.291,1.291,0,0,0,0,1.318v8.818a1.291,1.291,0,0,0,1.259,1.318H5.887L6.908,14.69a.424.424,0,0,0,.4.31H13.07a1.291,1.291,0,0,0,1.259-1.318V4.863A1.291,1.291,0,0,0,13.07,3.545ZM1.261,10.576a.43.43,0,0,1-.42-.439V1.318a.43.43,0,0,1,.42-.439H5.184l3.079,9.7Zm6.932.879-.823,1.9-.6-1.9Zm5.3,2.227a.43.43,0,0,1-.42.439H7.961L9.227,11.2a.462.462,0,0,0,.016-.32L7.194,4.424H13.07a.43.43,0,0,1,.42.439Z" transform="translate(23.072 4780)" fill="#17ac5c"></path><path _ngcontent-smartarz-client-c161="" id="Path_3959" data-name="Path 3959" d="M64.689,122.639H63.46a.41.41,0,0,0,0,.819h.749a1.229,1.229,0,1,1-.289-1.279.41.41,0,1,0,.579-.579,2.048,2.048,0,1,0,.6,1.448A.41.41,0,0,0,64.689,122.639Z" transform="translate(-36.786 4663.063)" fill="#17ac5c"></path><path _ngcontent-smartarz-client-c161="" id="Path_3960" data-name="Path 3960" d="M305.018,211.892h-1.339v-.446a.446.446,0,1,0-.892,0v.446h-1.339a.446.446,0,0,0,0,.892h2.592a5.608,5.608,0,0,1-.8,1.4c-.076-.1-.152-.209-.224-.316a.446.446,0,1,0-.738.5c.125.184.256.363.387.533-.223.259-.443.493-.636.682a.446.446,0,1,0,.625.637c.015-.015.259-.255.584-.623.317.363.555.6.573.62a.446.446,0,0,0,.631-.631s-.278-.279-.626-.686a5.806,5.806,0,0,0,1.15-2.122h.053a.446.446,0,0,0,0-.892Z" transform="translate(-268.94 4574.482)" fill="#17ac5c"></path></g></svg>
                English
            </a>

            

            <!-- <a @click="$store.commit('resetState')" class="menu-item no-border" >
                <i class="fas fa-angle-right right-icon float-right" ></i>
                <i class="fa fa-history menu-item-icon"></i>
                RESET
            </a> -->

            <!-- <router-link to="/seller/home" class="menu-item" v-if="$store.getters.isAuthenticated" >
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <i class="fab fa-buysellads menu-item-icon"></i>
                Upgrade To Business
            </router-link> -->

            <!-- <div class="menu-item ">
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <svg _ngcontent-smartarz-client-c161="" width="15" height="18" viewBox="0 0 20 26" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-item-icon"><path _ngcontent-smartarz-client-c161="" d="M9.98465 0C13.3317 0 16.3327 1.63268 18.2083 4.53488C20.0838 7.37686 20.5167 11.0048 19.3625 14.1792C19.0452 15.0259 18.5543 15.9022 17.9197 16.6887L10.6198 25.6977C10.4468 25.879 10.2738 26 10.014 26C9.75415 26 9.58114 25.879 9.40812 25.6977L2.07888 16.6881C1.4443 15.9022 0.924688 15.0555 0.636141 14.1786C-0.518053 11.0042 -0.0852318 7.37627 1.79033 4.53429C3.60785 1.63268 6.60886 0 9.98465 0ZM9.98465 15.2373C12.4661 15.2373 14.5146 13.0909 14.5146 10.4911C14.5146 7.89117 12.4661 5.74478 9.98465 5.74478C7.50325 5.74478 5.45467 7.89117 5.45467 10.4911C5.45467 13.0909 7.47451 15.2373 9.98465 15.2373Z" fill="#5BC0DE"></path></svg>
                {{trans._getMessage('All Cities (UEA)')}}
            </div> -->

            <!-- <a data-toggle="collapse" href="#moreCollapse" role="button" aria-expanded="false" aria-controls="moreCollapse" class="menu-item no-border show-more-btn collapsed">
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <i class="fas fa-angle-down menu-item-icon"> </i>
                More
            </a> -->

            <!-- <div class="collapse" id="moreCollapse">

            </div> -->

        </div>
        
        <!-- <div class="profile-box" > -->
            
            
            <!-- <a @click="openModal" class="menu-item no-border" v-if="!$store.getters.isAuthenticated"  >
                <i class="fas fa-angle-right right-icon float-right" v-if="$store.getters.ltr" ></i>
                <i class="fas fa-angle-left right-icon float-left" v-else ></i>
                <i class="fa fa-sign-in menu-item-icon"></i>
                Sign in
            </a>
            -->
        <!-- </div> -->








    </div>



<bottom-nav></bottom-nav>
</div>
</template>



<style>


</style>