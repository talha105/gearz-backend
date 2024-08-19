<template>
    <div class="x">
  <div class="view-ad">


    <!-- <div class="bread-crumbs my-3">
        <div class="bread-crumbs-item">Vehicles 
            <i class="fas fa-angle-right"></i> 
        </div>
        <div class="bread-crumbs-item">Hot Picks </div>
    </div> -->
    <div class="bread-crumbs my-3">
        <div class="bread-crumbs-item">
            {{listing.category ? listing.category.proper_title : ""}} 
            <!-- <i class="fas fa-angle-right"></i>  -->
        </div>
        <div class="bread-crumbs-item" v-if="listing.make"> 
            <i class="fas" :class="{'fa-angle-right' : $store.getters.ltr , 'fa-angle-left' : $store.getters.rtl}" ></i> 
            {{listing.make ? listing.make.proper_title : ""}}
        </div>
        <div class="bread-crumbs-item" v-if="listing.model"> 
            <i class="fas" :class="{'fa-angle-right' : $store.getters.ltr , 'fa-angle-left' : $store.getters.rtl}" ></i> 
            {{listing.model ? listing.model.proper_title : ""}} 
        </div>
        <!-- <div class="bread-crumbs-item">Hot Picks </div> -->
    </div>

    <div class="loading-view-ad" v-if="loadingListing">
        <loader :small="false"  ></loader>
    </div>

        <!-- <div class="row" v-if="loadingListing">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8 " :class="{'smz-box-container': $store.getters.ltr , 'padding-sm-none': $store.getters.rtl }">
                <div class="smz-box loading-box-left">
                    <b-skeleton-img></b-skeleton-img>  
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 " :class="{'padding-sm-none': $store.getters.ltr , 'smz-box-container': $store.getters.rtl }">
                <div class="smz-box loading-box-right">
                    <b-skeleton animation="wave" width="85%"></b-skeleton>
                    <b-skeleton animation="wave" width="55%"></b-skeleton>
                    <b-skeleton animation="wave" width="70%"></b-skeleton>
                    <b-skeleton animation="wave" width="85%"></b-skeleton>
                    <b-skeleton animation="wave" width="55%"></b-skeleton>
                    <b-skeleton animation="wave" width="70%"></b-skeleton>
                    <b-skeleton animation="wave" width="85%"></b-skeleton>
                    <b-skeleton animation="wave" width="55%"></b-skeleton>
                    <div class="d-flex">
                        <hr>
                        <b-skeleton type="button" class="mt-3 w-50 mr-2"></b-skeleton>
                        <b-skeleton type="button" class="mt-3 w-50" ></b-skeleton>
                    </div>
                </div>
            </div>
        </div> -->



      <div class="row" v-if="!loadingListing">
          <div class="col-12 col-sm-12 col-md-8 col-lg-8 smz-box-container">
              <div class="smz-box ad-image-slider p-0">


                    <div class="product-image-gallery">
                        <img class="no-image-placeholder" src="/img/car_no_image.jpg" v-if="listing.images.length == 0" />

                        <div class="splide" id="primary-slider" v-if="listing.images.length">
                            <div class="splide__track">
                                <ul class="splide__list imglist" >
                                    <li class="splide__slide" v-for="(image,index) in listing.images" :key="index">
                                        <a data-fancybox="images" :href="'/storage/listings/'+ image.name">
                                            <img :src="'/storage/listings/'+ image.name" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>



                        <div id="secondary-slider" class="splide" v-if="listing.images.length" >
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide" v-for="(image,index) in listing.images" :key="index">
                                        <img :src="'/storage/listings/'+ image.name" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                <div class="ad-price">{{trans._getMessage('Starting From AED')}}
                    <br>
                    <span class="price-digit" v-if="listing.day_price">{{$root.numberWithCommas(listing.day_price)}}/ {{trans._getMessage('Day')}} </span> 
                    <br>
                    <span class="price-digit" v-if="listing.week_price">{{$root.numberWithCommas(listing.week_price)}}/ {{trans._getMessage('Week')}}</span> 
                    <br>
                    <span class="price-digit" v-if="listing.month_price">{{$root.numberWithCommas(listing.month_price)}}/ {{trans._getMessage('Month')}} </span> 
                </div>


                <!-- <div class="ad-price">Starting From AED  <span class="price-digit">499/day</span> </div>
                <div class="ad-price">Starting From AED  <span class="price-digit">2499/month</span> </div>
                <div class="ad-price">Starting From AED  <span class="price-digit">64999/year</span> </div> -->
                <div class="ad-title">{{listing.proper_title}}
                    <div class="ratings" :class="{'float-right mr-3' : $store.getters.ltr , 'float-left ml-3' : $store.getters.rtl}">
                        
                        <star-rating 
                            active-color="#0e2859"
                            v-model="listing.average_ratings" 
                            :read-only="true" 
                            :round-start-rating="false"
                            :show-rating="false"
                            :star-size="20"
                            :rtl="$store.getters.rtl"
                        ></star-rating>
                    </div>
                </div>
              </div>

                <div class="ad-category-list">
                    <div class="category-item">
                    <span> {{listing.category ? listing.category.proper_title : ""}} </span>
                    <!-- <svg _ngcontent-smartarz-client-c122="" height="7" width="7"><circle _ngcontent-smartarz-client-c122="" cx="3" cy="4" r="1.5" stroke="black" stroke-width="3" fill="black"></circle></svg> -->
                    </div>
                    
                    <div class="category-item" v-if="listing.make">
                    <svg _ngcontent-smartarz-client-c122="" height="7" width="7"><circle _ngcontent-smartarz-client-c122="" cx="3" cy="4" r="1.5" stroke="black" stroke-width="3" fill="black"></circle></svg>
                    <span> {{listing.make ? listing.make.proper_title : ""}}</span>
                    </div>
                    
                    <div class="category-item" v-if="listing.model">
                    <svg _ngcontent-smartarz-client-c122="" height="7" width="7"><circle _ngcontent-smartarz-client-c122="" cx="3" cy="4" r="1.5" stroke="black" stroke-width="3" fill="black"></circle></svg>
                    <span> {{listing.model ? listing.model.proper_title : ""}} </span>
                    </div>

                    <!-- <div class="category-item"> Hot Picks </div> -->
                </div>

                <div class="row">
                    <!-- <div class="col-12 smz-box-margin-bottom-bg"  v-if="listing && listing.delivery_options && listing.delivery_options.length">
                        <div class="smz-box">
                            <div class="smz-box-title-with-border">
                                {{trans._getMessage('Delivery Options')}}
                            </div>

                            <div class="delivery-options">
                                <div class="delivery-option" :class="{'g-border-left' : $store.getters.rtl , 'g-border-right' : $store.getters.ltr }" >
                                    <div class="delivery-option-icon"> <i :style="{color: listing.color}" class="fas fa-palette"></i> </div>
                                    <div class="delivery-option-name">{{trans._getMessage(listing.color)}}</div>
                                </div>
                                
                                <div class="delivery-option" :class="{'g-border-left' : $store.getters.rtl , 'g-border-right' : $store.getters.ltr }" >
                                    <div class="delivery-option-image"> <i class="fas fa-color"></i> </div>
                                    <div class="delivery-option-name" v-if="listing.genre">{{ listing.genre.proper_title }}</div>
                                </div>
                            </div>

                        </div>
                    </div> -->
                    
                    <div class="col-12 smz-box-margin-bottom-bg"  v-if="listing && listing.delivery_options && listing.delivery_options.length">
                        <div class="smz-box">
                            <div class="smz-box-title-with-border">
                                {{trans._getMessage('Delivery Options')}}
                            </div>

                            <div class="delivery-options">
                                <div class="delivery-option" v-for="(option,index) in listing.delivery_options" :class="{'g-border-left' : $store.getters.rtl , 'g-border-right' : $store.getters.ltr }"  :key="index">
                                    <!-- :class="{'no-border': $store.getters.rtl && index == 0 , 'no-border': $store.getters.ltr && listing.delivery_options.length - 1 == index }" -->
                                    <!-- 'no-border': $store.getters.ltr && listing.delivery_options.length - 1 == index   -->
                                    <div class="delivery-option-image"><img :src="option.image" alt=""> </div>
                                    <div class="delivery-option-name">{{trans._getMessage(option.name)}}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6" :class="{'padding-lg': $store.getters.ltr}">
                        <div class="smz-box h-100">
                            <div class="smz-box-title-with-border">
                                {{trans._getMessage('Vehicle Overview')}}
                            </div>


                            <div class="ad-features">
                                <div class="feature-item" :class="{'item-border-left': $store.getters.rtl}">
                                    <div class="feature-item-image">
                                        <img src="/img/safety-seat.png"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">{{listing.attr.seats}} {{trans._getMessage('Seats')}}</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item" :class="{'item-border-left': $store.getters.ltr}">
                                    <div class="feature-item-image">
                                        <img src="/img/car-door.png"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">{{listing.attr.doors}} {{trans._getMessage('Doors')}}</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item" :class="{'item-border-left': $store.getters.rtl}">
                                    <div class="feature-item-image" >
                                        <img src="/img/year.svg"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">{{listing.attr.model}}</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item" :class="{'item-border-left': $store.getters.ltr}" >
                                    <div class="feature-item-image">
                                        <img src="/img/transmission.svg"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">{{trans._getMessage(listing.attr.transmission)}}</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item" :class="{'item-border-left': $store.getters.rtl}" >
                                    <div class="feature-item-image">
                                        <img src="/img/paint.png"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="" v-if="listing.color" >{{trans._getMessage(listing.color)}}</div>
                                        <div class="" v-else >{{trans._getMessage('Color')}}</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item" :class="{'item-border-left': $store.getters.ltr}" >
                                    <div class="feature-item-image">
                                        <img src="/img/car-genre.png"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">{{listing.genre.proper_title}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 vehicle-details" :class="{'padding-lg': $store.getters.rtl , }">
                        <div class="smz-box h-100">
                            <div class="smz-box-title-with-border">
                                {{trans._getMessage('Features')}}
                            </div>

                            <div class="ad-specs">
                                 <!-- :class="{'item-border-left' : index % 2 != 0 }" -->
                                <div class="spec-item" :class="{'item-border-left' : isEven(index) && $store.getters.rtl , 'item-border-left pl-2' : !isEven(index) && $store.getters.ltr , 'pr-2' : !isEven(index) && !$store.getters.ltr}" v-for="(feature,index) in listing.features" :key="index">
                                    
                                    <div class="spec-item-image text-center">
                                        <img :src="'/storage/features/'+feature.image" v-if="feature.image" />
                                        <img src="/img/star.png" v-else  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="feature-text-limit">{{feature.proper_title}}</div>
                                        <!-- <div class="">Connectivity</div> -->
                                    </div>
                                </div>

                                <!-- <div class="spec-item">
                                    <div class="spec-item-image">
                                        <img src="/img/android-logo.png"  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="">Android</div>
                                        <div class="">Connectivity</div>
                                    </div>
                                </div>
                                
                                <div class="spec-item">
                                    <div class="spec-item-image">
                                        <img src="/img/pngfind.com-wheel-icon-png-4444492.png"  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="">4 Wheel</div>
                                        <div class="">Drive</div>
                                    </div>
                                </div>
                                
                                <div class="spec-item">
                                    <div class="spec-item-image">
                                        <img src="/img/safety-seat.png"  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="">Heated</div>
                                        <div class="">Seats</div>
                                    </div>
                                </div>
                                

                                <div class="spec-item">
                                    <div class="spec-item-image">
                                        <img src="/img/maps-and-flags.png"  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="">Navigation</div>
                                        <div class=""></div>
                                    </div>
                                </div>

                                <div class="spec-item">
                                    <div class="spec-item-image">
                                        <img src="/img/bluetooth.png"  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="">Bluetooth</div>
                                        <div class="">Connectivity</div>
                                    </div>
                                </div>
                                
                                <div class="spec-item">
                                    <div class="spec-item-image">
                                        <img src="/img/usb.png"  />
                                    </div>
                                    <div class="spec-item-details">
                                        <div class="">USB</div>
                                        <div class="">Ports</div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="col-12 smz-box-margin-top-bg" v-if="haveExtraOptions">
                        <div class="smz-box">

                            <template v-if="listing.rental_includes && (listing.rental_includes.limit || listing.rental_includes.additional_charges || listing.rental_includes.insurance)">

                                <div class="smz-box-title-with-border">
                                    {{trans._getMessage('Rental Includes')}}
                                </div>

                                <div class="utils-container">
                                    <div class="utils utils-includes" v-if="listing.rental_includes.limit">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Mileage Limits')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.rental_includes.limit}}
                                        </div>
                                    </div>
                                    
                                    <div class="utils utils-includes" v-if="listing.rental_includes.additional_charges">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Additional Mileage Charge')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.rental_includes.additional_charges}}
                                        </div>
                                    </div>
                                    
                                    <div class="utils utils-includes" v-if="listing.rental_includes.insurance">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Insurance')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.rental_includes.insurance}}
                                        </div>
                                    </div>
                                </div>
                            </template>



                            <template v-if="listing.requirements && (listing.requirements.age || listing.requirements.deposit || listing.requirements.accepted)">

                                <div class="smz-box-title-with-border">
                                    {{trans._getMessage('Requirements')}}
                                </div>

                                <div class="utils-container">
                                    <div class="utils utils-requirements" v-if="listing.requirements.age">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Minimum Age')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.requirements.age}}
                                        </div>
                                    </div>
                                    
                                    <div class="utils utils-requirements" v-if="listing.requirements.deposit">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Security Deposit')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.requirements.deposit}}
                                        </div>
                                    </div>
                                    
                                    <div class="utils utils-requirements" v-if="listing.requirements.accepted">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Accepted in')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.requirements.accepted}}
                                        </div>
                                    </div>
                                </div>

                            </template>


                            <template v-if="listing.extras && (listing.extras.driver_insurance || listing.extras.excess_claim || listing.extras.toll_charges)">

                                <div class="smz-box-title-with-border">
                                    {{trans._getMessage('Extras')}}
                                </div>

                                <div class="utils-container">
                                    <div class="utils utils-extras" v-if="listing.extras.driver_insurance">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Additional Driver Insurance')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.extras.driver_insurance}}
                                        </div>
                                    </div>
                                    
                                    <div class="utils utils-extras" v-if="listing.extras.excess_claim">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Excess Claim')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.extras.excess_claim}}
                                        </div>
                                    </div>
                                    
                                    <div class="utils utils-extras" v-if="listing.extras.toll_charges">
                                        <div class="util-item-name">
                                            {{trans._getMessage('Salik/Toll Charges')}}
                                        </div>
                                        <div class="util-item-value">
                                            {{listing.extras.toll_charges}}
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    
                </div>



                

                <div class="smz-box mt-5 text-center action-btns-area">

                    <div class="share-container">
                        <div class="share-options" :class="{'left' : $store.getters.ltr ,'right' : $store.getters.rtl }" v-if="showShareOptions">
                        <div class="single-option mail">
                            <a href="javascript:;" @click="shareEmail">
                                <i class="fas fa-at"></i>
                                <div class="name">Email</div>
                            </a>
                        </div>
                        <div class="single-option fb">
                            <a href="javascript:;" @click="shareFacebook">
                                <i class="fab fa-facebook-f"></i>
                                <div class="name">Facebook</div>
                            </a>
                        </div>

                        <div class="single-option wapp">
                            <a href="javascript:;" @click="shareWhatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <div class="name">Whatsapp</div>
                            </a>
                        </div>
                    </div>
                    <button class="btn share-btn smz-btn-dark" :class="{'mr-2' : $store.getters.ltr ,'ml-2' : $store.getters.rtl }" @click="showShareOptions = !showShareOptions"> <i class="fas fa-share-square"></i> {{trans._getMessage('Share Ad')}}</button>
                    </div>
                    
                    <button type="button" @click="openReportModal" class="btn report-btn smz-btn-red-light"><i class="fas fa-flag"></i> {{trans._getMessage('Report Post')}}</button>

                </div>

                <div class="smz-box mt-5">
                    <div class="smz-box-title-with-border">
                        {{trans._getMessage('Description')}}
                    </div>

                    <div class="ad-description-text" v-html="listing.proper_description">
                        
                    </div>
                </div>
                
                <div class="smz-box mt-5">
                    <template v-if="!listing.already_reviewed">
                    <div class="smz-box-title-with-border">
                        {{trans._getMessage('Reivews')}}
                    </div>
                    
                    <div class="comment-section-text">
                        <div>
                            <span class="review-text">
                            <i class="fas fa-lightbulb"></i>
                            {{trans._getMessage('Please note that its a public message and visible to everyone. For private chat click on chat button in detail section.')}}</span>
                        </div>
                        <form @submit.prevent="postReview" >
                        <div class="comment-text">
                            <textarea class="form-control" v-model="review.text" required :placeholder="trans._getMessage('@Type here')"></textarea>
                        </div>
                        <div class="new-review">
                            <star-rating 
                                active-color="#0e2859"
                                v-model="review.rating" 
                                :round-start-rating="false"
                                :show-rating="false"
                                :star-size="30" 
                            ></star-rating>
                        </div>
                        <div class="comment-submit">
                            <button :disabled="reviewing" type="submit" class="btn smz-btn-dark float-right">
                                <b-spinner class="text-light" small v-if="reviewing"></b-spinner>
                                <i v-else class="far fa-star-half-alt"></i>
                                <span>{{trans._getMessage('Submit')}}</span>
                            </button>
                            <!-- <button class="btn smz-btn-dark float-right"><i class="fal fa-file-signature"></i>Submit</button> -->
                        </div>
                        </form>
                    </div>

                    <hr>
                    </template>

                    <div class="smz-box-title-with-border" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" > <i class="fas fa-stars"></i> {{trans._getMessage('View Reviews')}} <i class="fas fa-angle-down"></i> <div :class="{'float-right' : $store.getters.ltr , 'float-left' : $store.getters.rtl}" >{{listing.total_reviews}}</div> </div>

                    <div class="all-reviews">
                        <div class="collapse" id="collapseExample">

                        <div class="single-review" v-for="(single_review,index) in reviews" :key="index">
                            <div class="review-top">
                                <div class="user-image">
                                    <img src="/images/profile-placeholder.jpg" />
                                </div>
                                <div class="review-name-box">
                                    <div class="review-user-name" v-if="single_review.user">{{single_review.user.name}}</div>
                                    <div class="review-date">{{single_review.create_date}}</div>
                                </div>
                                <div class="review-rating-box">
                                    <div class="review-user-name">
                                        <star-rating 
                                            active-color="#0e2859"
                                            v-model="single_review.rating" 
                                            :round-start-rating="false"
                                            :show-rating="false"
                                            :read-only="true"
                                            :star-size="20" 
                                        ></star-rating>
                                    </div>
                                </div>
                            </div>
                            <div class="review-text-box">
                                <div class=""> {{single_review.text}} </div>
                            </div>
                        </div>
                        <div class="load-more-button" v-if="!noMoreReviews">
                            <button @click="getListingReviews" class="load-more-reviews btn" type="button">
                                <loader v-if="loadingReviews"></loader>
                                <span v-else> <i class="fas fa-angle-down"></i> {{trans._getMessage('Load More')}} </span>
                            </button>
                        </div>
                        </div>
                    </div>
                    
                </div>

          </div>


        <div class="col-12 col-sm-12 col-md-4 col-lg-4 padding-sm-none">
            <div class="smz-box">
                <div class="smz-box-title-with-border">
                    {{trans._getMessage('Posted By')}}
                </div>

                <div class="user-info">
                    <div class="user-image-box">
                        <img src="/images/default-user-avatar.png" />
                    </div>

                    <div class="user-details">
                        <div class="listing-by">{{trans._getMessage('Listing By')}}</div>
                        <div class="user-name">{{listing.user ? listing.user.name : trans._getMessage("Motrcom")}}</div>
                        <div class="verified">
                            <i class="fas fa-badge-check"></i>
                            
                            <span>{{trans._getMessage('Verified')}}</span>
                            </div>
                        <div class="member-date" v-if="listing && listing.user" ><svg _ngcontent-smartarz-client-c111="" width="20" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c111="" d="M17.8572 2.14284H15.7143V0.71442C15.7143 0.319752 15.3946 0 14.9999 0C14.6052 0 14.2855 0.319752 14.2855 0.71442V2.14284H5.71411V0.71442C5.71411 0.319752 5.39435 0 4.99969 0C4.60502 0 4.28568 0.319752 4.28568 0.71442V2.14284H2.14284C0.959257 2.14284 0 3.1021 0 4.28568V17.8572C0 19.0407 0.959257 20 2.14284 20H17.8572C19.0407 20 20 19.0407 20 17.8572V4.28568C20 3.1021 19.0403 2.14284 17.8572 2.14284ZM2.14284 3.57126H4.28568V4.99969C4.28568 5.39435 4.60544 5.71411 5.0001 5.71411C5.39477 5.71411 5.71452 5.39435 5.71452 4.99969V3.57126H14.2859V4.99969C14.2859 5.39435 14.6056 5.71411 15.0003 5.71411C15.395 5.71411 15.7147 5.39435 15.7147 4.99969V3.57126H17.8576C18.2522 3.57126 18.572 3.89102 18.572 4.28568V7.14295H1.42842V4.28568C1.42842 3.89102 1.74817 3.57126 2.14284 3.57126ZM17.8572 18.5712H2.14284C1.74817 18.5712 1.42842 18.2514 1.42842 17.8567V8.57137H18.5712V17.8572C18.5712 18.2514 18.2514 18.5712 17.8572 18.5712Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M5.71413 9.99979H4.28571C3.89104 9.99979 3.57129 10.3195 3.57129 10.7142C3.57129 11.1089 3.89104 11.4286 4.28571 11.4286H5.71413C6.1088 11.4286 6.42855 11.1089 6.42855 10.7142C6.42855 10.3195 6.1088 9.99979 5.71413 9.99979Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M10.7143 9.99979H9.28583C8.89116 9.99979 8.57141 10.3195 8.57141 10.7142C8.57141 11.1089 8.89116 11.4286 9.28583 11.4286H10.7143C11.1089 11.4286 11.4287 11.1089 11.4287 10.7142C11.4287 10.3195 11.1089 9.99979 10.7143 9.99979Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M15.7144 9.99979H14.286C13.8913 9.99979 13.5715 10.3195 13.5715 10.7142C13.5715 11.1089 13.8913 11.4286 14.286 11.4286H15.7144C16.109 11.4286 16.4288 11.1089 16.4288 10.7142C16.4288 10.3195 16.1086 9.99979 15.7144 9.99979Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M5.71413 12.857H4.28571C3.89104 12.857 3.57129 13.1768 3.57129 13.5715C3.57129 13.9661 3.89104 14.2859 4.28571 14.2859H5.71413C6.1088 14.2859 6.42855 13.9661 6.42855 13.5715C6.42855 13.1768 6.1088 12.857 5.71413 12.857Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M10.7143 12.857H9.28583C8.89116 12.857 8.57141 13.1768 8.57141 13.5715C8.57141 13.9661 8.89116 14.2859 9.28583 14.2859H10.7143C11.1089 14.2859 11.4287 13.9661 11.4287 13.5715C11.4287 13.1768 11.1089 12.857 10.7143 12.857Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M15.7144 12.857H14.286C13.8913 12.857 13.5715 13.1768 13.5715 13.5715C13.5715 13.9661 13.8913 14.2859 14.286 14.2859H15.7144C16.109 14.2859 16.4288 13.9661 16.4288 13.5715C16.4284 13.1768 16.1086 12.857 15.7144 12.857Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M5.71413 15.7143H4.28571C3.89104 15.7143 3.57129 16.0341 3.57129 16.4287C3.57129 16.8234 3.89104 17.1432 4.28571 17.1432H5.71413C6.1088 17.1432 6.42855 16.8234 6.42855 16.4287C6.42855 16.0341 6.1088 15.7143 5.71413 15.7143Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M10.7143 15.7143H9.28583C8.89116 15.7143 8.57141 16.0341 8.57141 16.4287C8.57141 16.8234 8.89116 17.1432 9.28583 17.1432H10.7143C11.1089 17.1432 11.4287 16.8234 11.4287 16.4287C11.4287 16.0341 11.1089 15.7143 10.7143 15.7143Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M15.7144 15.7143H14.286C13.8913 15.7143 13.5715 16.0341 13.5715 16.4287C13.5715 16.8234 13.8913 17.1432 14.286 17.1432H15.7144C16.109 17.1432 16.4288 16.8234 16.4288 16.4287C16.4288 16.0341 16.1086 15.7143 15.7144 15.7143Z" fill="#0e2859"></path></svg> 
                        <span v-if="listing && listing.user"> {{trans._getMessage('Member Since')}} {{listing.user.created_at | formatedDateWithDay}}</span>
                        </div>
                    </div>
                </div>


                <!-- <div class="user-number">
                    <svg _ngcontent-smartarz-client-c111="" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c111="" d="M16.5558 11.8148C15.4537 11.8148 14.3719 11.6423 13.3463 11.3034C12.8438 11.1319 12.2259 11.2894 11.9194 11.6044L9.89531 13.132C7.54828 11.8791 6.10219 10.4339 4.86656 8.10422L6.34969 6.13312C6.735 5.74828 6.87328 5.18625 6.70781 4.65891C6.3675 3.62812 6.19453 2.54672 6.19453 1.44422C6.19453 0.647812 5.54625 0 4.74984 0H1.44422C0.647812 0 0 0.647812 0 1.44422C0 10.5731 7.42688 18 16.5558 18C17.3522 18 18 17.3522 18 16.5558V13.2595C18 12.4631 17.3522 11.8148 16.5558 11.8148Z" fill="#0e2859"></path></svg>

                    <label class="user-number--digits" v-if="!showNumber"  >**********</label>
                    <label class="user-number--digits" v-else >{{listing.phone}}</label>

                    <a v-if="$store.getters.isAuthenticated" class="float-right btn smz-btn-lite show-number" @click="showNumber = !showNumber">Show Number</a>
                </div> -->

                <div class="ad-action-btns">
                    <button type="button" @click="goToLink( 'mailto:' + listing.user.email , 'auth')"  class="btn email-btn"> <i class="fas fa-envelope"></i> {{trans._getMessage('Email')}}</button>
                    <button  @click="goToWhatsapp()" type="button" class="btn chat-btn"> 
                    <img class="whatsapp-icon-btn" src="/images/whatsapp.png"/> {{trans._getMessage('Chat')}}</button>
                </div>
            </div>



            <div class="smz-box mt-5 location-area">
                <div class="smz-box-title-with-border">
                    {{trans._getMessage('Posted Location')}}
                </div>

                <div class="location-text">
                    <i class="fas fa-map-marker-alt"></i>
                    <span> {{trans._getMessage(listing.city)}}  {{listing.address ? ',' + listing.address : ""}}</span>

                    <div class="text-center position-relative">
                        <div class="view-map-btn-container">
                            <a target="blank" :href="'https://www.google.com/maps/search/?api=1&query=' + listing.city + '+'+listing.address" class="btn view-map-btn">{{trans._getMessage('View Map')}}</a>
                        </div>
                        <img src="/images/maps.png" />
                    </div>
                </div>
            </div>
            


        </div>
    </div>




    <div class="action-btns-fixed" >
        <div class="ad-action-btns mt-2 mb-2 text-center">
            <button @click="goToWhatsapp()" type="button" class="btn chat-btn"> <img class="whatsapp-icon-btn" src="/images/whatsapp.png"/>  {{trans._getMessage('Chat')}}</button>
            <!-- <button @click="goToLink('https://wa.me/+971552095949?text=I%27m%20interested')" type="button" class="btn chat-btn"> <svg _ngcontent-smartarz-client-c110="" width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c110="" d="M20.1464 0H3.29526C1.47805 0 0 1.48458 0 3.30982V18.1426C0 18.8453 0.791379 19.2408 1.34906 18.8407L6.04271 15.4776C6.4365 15.1963 6.89934 15.047 7.38342 15.047H17.7055C19.5227 15.047 21.0008 13.5624 21.0008 11.7372V0.857366C21 0.3841 20.6176 0 20.1464 0ZM16.0006 10.3867H6.13755C5.66637 10.3867 5.28395 10.0026 5.28395 9.52934C5.28395 9.05608 5.66637 8.67198 6.13755 8.67198H15.9998C16.471 8.67198 16.8534 9.05608 16.8534 9.52934C16.8542 10.0026 16.4718 10.3867 16.0006 10.3867ZM16.0006 6.38566H6.13755C5.66637 6.38566 5.28395 6.00156 5.28395 5.5283C5.28395 5.05503 5.66637 4.67093 6.13755 4.67093H15.9998C16.471 4.67093 16.8534 5.05503 16.8534 5.5283C16.8542 6.00156 16.4718 6.38566 16.0006 6.38566Z" fill="white"></path></svg> Chat</button> -->
            <button @click="goToLink('tel:' + listing.phone , 'auth')" type="button" class="btn email-btn"> <i class="fas fa-phone-alt"></i> {{trans._getMessage('Call')}}</button>
        </div>
    </div>



<div class="sub-category-modal" v-if="showReportModal">

  <div class="sub-category-modal-main">
    <div class="_modal-close-btn" :class="{'left' : $store.getters.rtl , 'right' : $store.getters.ltr}" @click="closeModal" >
        <svg _ngcontent-smartarz-client-c151="" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15.125 15.125"><path _ngcontent-smartarz-client-c151="" id="_2089733" data-name="2089733" d="M15.125,1.782,13.342,0,7.562,5.78,1.782,0,0,1.782l5.78,5.78L0,13.342l1.782,1.782,5.78-5.78,5.78,5.78,1.782-1.782-5.78-5.78Z" fill="#fff"></path></svg>
     </div>

        
        <div class="smz-modal-title">{{trans._getMessage('Report Listing')}}</div>

        <div class="sub-category-listing">
            <div class="report-options">
                <div class="report-option">
                    <div class="radio-box">
                        <input type="radio" v-model="report.reason" value="Duplicate" id="duplicate" name="report" />
                    </div>
                    <div class="report-text">
                        <label for="duplicate">{{trans._getMessage('Duplicate')}} </label>
                        <div class="report-text-description">{{trans._getMessage("There's already a listing posted just like this one")}}.</div>
                    </div>
                </div>
                
                <div class="report-option">
                    <div class="radio-box">
                        <input type="radio" v-model="report.reason" value="Spam" id="spam" name="report" />
                    </div>
                    <div class="report-text">
                        <label for="spam"> {{trans._getMessage("Spam")}} </label>
                        <div class="report-text-description">{{trans._getMessage("It's a junk ad")}}.</div>
                    </div>
                </div>
                
                <div class="report-option">
                    <div class="radio-box">
                        <input type="radio" v-model="report.reason" value="Wrong" id="Wrong" name="report" />
                    </div>
                    <div class="report-text">
                        <label for="Wrong">{{trans._getMessage("Wrong Contact Info")}} </label>
                        <div class="report-text-description">{{trans._getMessage("Contact info is incorrect")}}.</div>
                    </div>
                </div>

                <div class="mt-3 text-center action-btns-area">
                    <button class="btn share-btn smz-btn-dark report-modal-btn" :class="{'mr-2' : $store.getters.ltr ,'ml-2' : $store.getters.rtl }" @click="reportListing" :disabled="reporting"> {{trans._getMessage('Report')}}</button>
                    <button type="button" @click="closeModal" class="btn report-btn smz-btn-red-light report-modal-btn"> {{trans._getMessage('Cancel')}}</button>
                </div>
            </div>
        </div>
        </div>
  </div>
</div>
</div>
</template>

<script>
export default {

    created(){
        // this.initializeSliders();
        let self = this;
        window.addEventListener('click', function(e){
            // close dropdown when clicked outside
            if (!self.$el.contains(e.target)){
                self.showShareOptions = false
            } 
        })
        this.getListingDetails()
    },
    mounted(){
        this.$store.commit('setGenreStatus' , false)
    },
    computed:{
        haveExtraOptions(){
            // if(this)
            if( 
                this.listing.rental_includes && ( this.listing.rental_includes.limit || this.listing.rental_includes.additional_charges || this.listing.rental_includes.insurance)
                
                || 
                
                this.listing.requirements && ( this.listing.requirements.age || this.listing.requirements.deposit || this.listing.requirements.accepted) 
                
                ||

                this.listing.extras && ( this.listing.extras.driver_insurance || this.listing.extras.excess_claim || this.listing.extras.toll_charges)){
                return true;
            }else{
                return false
            }
        }
    },
    methods:{
        showInConsole(option){
            // console.log(option , typeof option ,  JSON.parse(option) , option.name)
        },
        getListingDetails(){
            this.loadingListing = true
            axios.post('/api/listing_details', {
                listing_id: this.$route.params.listing_id,
                user_id : this.$store.getters.isAuthenticated.id
            }).then( res => {
                this.listing = res.data.listing
                this.initializeSliders();
                this.getListingReviews();
                this.loadingListing = false
                
            }).catch( err => {
                this.loadingListing = false
                console.log(err)
            })
        },
        getListingReviews(){
            this.loadingReviews = true
            axios.post('/api/fetch-listing-reviews', {
                listing_id: this.$route.params.listing_id,
                skip: this.reviews.length,
                take: 10
            }).then( res => {
                this.reviews.push(...res.data.reviews)  
                this.loadingReviews = false

                if(res.data.reviews.length < 10){
                    this.noMoreReviews = true
                }
            }).catch( err => {
                this.loadingReviews = false
                console.log(err)
            })
        },

        goToWhatsapp(){

            var text = 'Hi I am interested in your ad ' + this.listing.title;
            if(this.listing.make){
            text += ' make ' + this.listing.make.title;
            }
            if(this.listing.model){
            text += ' model ' + this.listing.model.title;
            }
            text += ' from MOTRCOM';
            // text = text.replace(" ", "%");  
            // text = text.replace(/ /g, '%');
            text = encodeURIComponent(text)
            window.location.href = 'https://wa.me/'+this.listing.phone+'?text='+text;

            // if(this.$store.getters.isAuthenticated){

            //     // window.location.href = 'https://wa.me/'+this.listing.phone+'?text=I%27m%20interested'
            // }else{
            //     Swal.fire({
            //         title: this.trans._getMessage('Please login to continue'),
            //         icon: 'info',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         cancelButtonText: this.trans._getMessage('Cancel'),
            //         confirmButtonText: this.trans._getMessage('Login Now'),
            //         }).then((result) => {
            //     if (result.isConfirmed) {
            //         this.$router.push('/user-login');
            //         }
            //     })
            // }
        },

        goToLink(link , check = ''){

            window.location.href = link;
            // if(check && check == 'auth'){
            //     if(this.$store.getters.isAuthenticated){
            //     }else{
            //         // this.$toastr.warning('Login to continue');

            //     Swal.fire({
            //         title: this.trans._getMessage('Please login to continue'),
            //         icon: 'info',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         cancelButtonText: this.trans._getMessage('Cancel'),
            //         confirmButtonText: this.trans._getMessage('Login Now'),
            //         }).then((result) => {
            //     if (result.isConfirmed) {
            //         this.$router.push('/user-login');
            //         }
            //     })
            //     }
            // }else{

            // }
        },

        currencyFormat(price){
            return new Intl.NumberFormat('ja-JP',  {
            style: 'currency',
            currency: 'AED',
            }).format(price);

        },

        postReview(){

            if(this.$store.getters.isAuthenticated){
                this.reviewing = true
                axios.post('/api/review/store' , {
                    text: this.review.text,
                    rating: this.review.rating,
                    listing_id: this.listing.id,
                    user_id: this.$store.getters.isAuthenticated.id,
            }).then(res => {
                this.$toastr.success(this.trans._getMessage('Review added Successfully'));
                this.reviewing = false
                this.review.text = '';
                this.review.rating = 1;
                // this.reviews.unshift(res.data.review);
                this.listing.already_reviewed = true
                // console.log(res)
            }).catch( err => {
                console.log(err)
                this.reviewing = false
                this.$toastr.error(err.response.data.message);
            })
            }else{
                
                Swal.fire({
                    title: this.trans._getMessage('Please login to continue'),
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: this.trans._getMessage('Cancel'),
                    confirmButtonText: this.trans._getMessage('Login Now'),
                }).then((result) => {
                if (result.isConfirmed) {
                    this.$router.push('/user-login');
                    }
                })
            }
        },
        reportListing(){
            if(this.report.reason){
                this.reporting = true
                axios.post('/api/main/report/store' , {
                    listing_id: this.$route.params.listing_id,
                    user_id : this.$store.getters.isAuthenticated.id,
                    reason: this.report.reason,
                    text: this.report.text,
                }).then (res => {
                    this.$toastr.success(this.trans._getMessage('Listing Reported Successfully'));
                    this.closeModal();
                    this.report.reason = ""
                    this.report.text = ""
                    this.reporting = false
                }).catch( err => {
                    console.log(err)
                    this.reporting = false
                })
            }else{
                this.$toastr.error(this.trans._getMessage('Select Any Reason to report'));
            }
        },
        numberWithCommas(price) {
            return price.toString().replace(/\B(?=(\d{2})+(?!\d))/g, ",");
        },
        initializeSliders(){
            // document.addEventListener( 'DOMContentLoaded', function () {

        $(document).ready( () =>  {
            var secondarySlider = new Splide( '#secondary-slider', {
                fixedWidth  : 100,
                height      : 60,
                gap         : 5,
                cover       : true,
                isNavigation: true,
                pagination  : false,
                drag : true,
                //focus       : 'center',
                arrows     : false,
                direction :  this.$store.getters.rtl ? 'rtl' : 'ltr' ,

                breakpoints : {
                    '600': {
                        fixedWidth: 66,
                        height    : 40,
                    }
                },
            } ).mount();
            
            var primarySlider = new Splide( '#primary-slider', {
                type       : 'slide',
                heightRatio: 0.5,
                pagination : false,
                arrows     : false,
                cover      : true,
                height     : 410,
                direction :  this.$store.getters.rtl ? 'rtl' : 'ltr' ,
                breakpoints : {
                    '380': {
                        height    : 350,
                    }
                },

                //arrowPath: 'm15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z',
            } ); // do not call mount() here.
            
            primarySlider.sync( secondarySlider ).mount();
        } );
    },
    closeModal(){
        $('body').css('overflow' , 'auto')
        this.showReportModal = false;       
    },
    openReportModal(){
        if(this.$store.getters.isAuthenticated){
            $('body').css('overflow' , 'hidden')
            this.showReportModal = true;       
        }else{
            Swal.fire({
                title: this.trans._getMessage('Please login to continue'),
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: this.trans._getMessage('Cancel'),
                confirmButtonText: this.trans._getMessage('Login Now'),
                }).then((result) => {
            if (result.isConfirmed) {
                this.$router.push('/user-login');
                }
            })

        }
    },
    shareWhatsapp(){
        window.location.href = "https://wa.me?text="+encodeURIComponent('Hey! Check this ')+window.location;
        // window.location.href = "https://wa.me?text=${encodeURIComponent('The message to send')}`";
        // window.location.href = 'https://web.whatsapp.com/send?text=' + window.location;
    },
    shareFacebook(){
        window.location.href = 'https://www.facebook.com/sharer/sharer.php?u='+window.location;
    },
    shareEmail(){
        window.location.href = 'mailto:?subject='+encodeURIComponent('Hey Check this one')+'&body='+encodeURIComponent('Check this one ') + window.location;
        // window.location.href = 'mailto:?subject=Hey Check this out&amp;body=Check this out' + window.location;
    },

    isEven(value) {
        if (value%2 == 0)
            return true;
        else
            return false;
    },

    },
    data(){
        return{
            loadingListing: false,
            loadingReviews: false,
            showReportModal: false,
            noMoreReviews: false,
            showNumber: false,
            reviewing: false,
            reporting: false,
            showShareOptions: false,
            listing: '',
            report: {
                reason: "",
                text: "",
            },
            rating: 4,
            reviews:[],
            review:{
                text: "",
                rating: 1,
            },
            dummy_images:[
                '/images/fj-car.jpg',
                'https://www.tuningblog.eu/wp-content/uploads/2020/06/slammed-Toyota-FJ-Cruiser-Widebody-Atoy-Customs-Header.jpg',
                'https://ymimg1.b8cdn.com/resized/used_car/2019/6/9/897961/pictures/4370682/listing_main_Toyota_FJ_Cruiser_2016_in_Dubai_897961_0.jpeg',
                'https://www.wacecars.com/media/carphotos/1E0E7CC8-23AF-40F5-8410-1F12876F38CF/2.jpg',
                'https://toyota-dealer.org/wp1/wp-content/uploads/2017/01/toyota_fj-cruiser.jpg',
                'https://www.wacecars.com/media/carphotos/BDCAFBC3-6B75-4685-8891-B5BFBC7741AC/1.jpg',
                'https://cdn05.carsforsale.com/00e0e35f06c6f6b1546f98c624167ce226/800x600/2012-toyota-fj-cruiser-base-4x4-4dr-suv-5a.jpg',
                'https://images.customwheeloffset.com/web/875820-10-2009-fj-cruiser-toyota-rsr-lowered-on-springs-xd-xd844-black.jpg',
                'https://www.fjcruiserforums.com/attachments/lowered-jpg.12754/',
                'https://img.gta5-mods.com/q95/images/2012-toyota-fj-cruiser/e0103f-5.png',
                // 'https://www.iihs.org/api/ratings/model-year-images/1664',
                // 'https://static.toiimg.com/thumb/msid-76849381,width-1070,height-580,imgsize-154769,resizemode-75,overlay-toi_sw,pt-32,y_pad-40/photo.jpg',
                // 'https://upload.wikimedia.org/wikipedia/commons/d/d2/2019_Hyundai_Elantra_Limited_%28AD_facelift%29_front_NYIAS_2019.jpg',
                // 'https://i.ytimg.com/vi/iU014EEoqdk/maxresdefault.jpg',
                // 'https://s1.paultan.org/image/2020/03/2020-Hyundai-Elantra-Global-Debut_Exterior-12-1200x628.jpg',
                // 'https://www.automobilemag.com/uploads/sites/11/2020/11/2021-Hyundai-Elantra-N-Line-front-03.jpg?fit=around%7C875:492',
                // 'https://cdn.motor1.com/images/mgl/jqrpR/s1/2021-hyundai-elantra-n-line-exterior-front-quarter.jpg',
                // 'https://cnet1.cbsistatic.com/img/YiOrcbBSVOiWKMYDZ-Yi6SimP40=/1200x675/2020/03/31/c96dfc14-8f2f-4e01-bd74-10f80ce84813/ogi-elantra.jpg',
            ]

        }
    }
}
</script>

<style>
    .view-ad{
        padding-bottom: 100px;
    }


    #primary-slider .splide__slide img{
        /* width: auto; */
        /* max-width: 100%; */
        width: 100%;
        height: 100%;
        max-height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    #secondary-slider{
        margin-top: 5px;
    }

    .splide__slide {
        border-radius: 5px;
        padding: 1px;
    }
    #secondary-slider .splide__slide{
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0.5;
        text-align: center;
    }
    #secondary-slider .splide__slide img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .splide__slide, .is-visible{
        transition: all .3s ease-in-out;
    }
    #secondary-slider .is-active{
        opacity: 1 !important;
        border: 2px solid #0e2859;
    }
    .splide.is-active .splide__list{
        text-align: center;
    }
    .splide--nav>.splide__track>.splide__list>.splide__slide.is-active{
        border: none;
        background-blend-mode: normal;
    }
   
      .splide--nav>.splide__track>.splide__list>.splide__slide{
          border: unset;
      }

    .splide__arrow svg path{
        fill: #fff;
    }
    .splide__arrow{
        background-color: #0e2859;
        border: 4px solid white;
        width: 40px;
        height: 40px;
    }


    @media screen and (max-width:768px) {
        #primary-slider .splide__slide img{
            border-radius: 0 !important;
        }
    }

    .view-ad .ratings .vue-star-rating{
        margin-top: -2px;
    }

    .view-ad .loading-box-right{
        height: 300px;
    }
    .view-ad .loading-box-left .b-skeleton-img{
        margin: -20px;
        border-radius: 10px;
        width: auto;
    }
    .view-ad .loading-box-right .b-aspect{
        height: 100%;
    }
    /* .view-ad .loading-box-left{ */
        /* height: 100vh; */
    /* } */
    .view-ad .product-image-gallery{
        min-height: 410px;
    }
    .view-ad .product-image-gallery .no-image-placeholder{
        min-height: 410px;
        object-fit: contain;
        width: 100%;
    }
    .view-ad .new-review{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .view-ad .new-review .vue-star-rating:nth-child(1) {
        justify-content: center;
        /* box-shadow: 0 0 5px 2px rgb(14 40 89 / 12%); */
        padding: 3px 32px 6px;
        border-radius: 50px;
    }

    .loading-view-ad{
        height: 100vh;
    }


    .view-ad .share-options.left{
        left: -45px;
    }
    .view-ad .share-options.right{
        right: -45px;
    }
    .view-ad .share-options{
        position: absolute;
        top: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        background-color: white;
        color: white;
        border: 1px solid #e1e1e1;
        border-radius: 5px;
        box-shadow: 0 0 5px 2px rgb(0 68 207 / 15%);
    }    
    .view-ad .share-options .single-option a{
        color: #fff !important;
        text-decoration: none;
    }
    .view-ad .share-options .single-option{
        width: 90px;
        height: 80px;
        border-radius: 5px;
        margin: 0 10px;
        display: flex;
        justify-content: center;
        font-size: 25px;
        align-items: center;
        flex-direction: column;
        transition: all .3s ease-in-out;
    }
    .view-ad .share-options .single-option .name{
        font-size: 15px;
        margin-top: -5px;
        font-weight: 600;
    }

    .view-ad .share-options .single-option.fb{
        background-color: #4267b2;
    }
    .view-ad .share-options .single-option.fb:hover{
        background-color: #385896;
    }
    .view-ad .share-options .single-option.wapp{
        background-color: #25d366;
    }
    .view-ad .share-options .single-option.wapp:hover{
        background-color: #20c45d;
    }
    .view-ad .share-options .single-option.mail{
        background-color: #00acee;
    }
    .view-ad .share-options .single-option.mail:hover{
        background-color: #0095ce;
    }


@media screen and (max-width:768px) {
    .view-ad .share-options{
        position: absolute;
        top: 50px;
    }    
    .view-ad .share-options.left{
        left: -20px;
        }
    .view-ad .share-options.right{
        right: -20px;
        }
    .view-ad .share-options .single-option{
        width: 75px;
        height: 70px;
        font-size: 20px;
    }
    .view-ad .share-options .single-option .name{
        font-size: 13px;
        margin-top: 0;
    }

}

.delivery-options{
    display: flex;
    color: #0e2859;
}
.delivery-options .delivery-option.no-border{
    border: none !important;
}

.delivery-options .delivery-option:last-child{
    border: none !important;
}
.delivery-options .delivery-option .delivery-option-image{
    margin-right: 7px;
    margin-left: 7px;
}
.delivery-options .delivery-option .delivery-option-icon{
    font-size: 16px;
    margin-right: 7px;
    margin-left: 7px;
}
.delivery-options .delivery-option .delivery-option-icon i{
    font-size: 25px;
}
.delivery-options .delivery-option .delivery-option-name{
    font-size: 16px;
}

.delivery-options .delivery-option.g-border-right{
    border-right: 1px solid #cccccc;
}
.delivery-options .delivery-option.g-border-left{
    border-left: 1px solid #cccccc;
}
.delivery-options .delivery-option{
    display: flex;
    width: 100%;
    justify-content: center;
}



.delivery-options .delivery-option img{
    width: 25px;
}

@media screen and (max-width:768px) {
    .delivery-options{
        font-size: 12px;
    }

    .delivery-options .delivery-option{
        flex-direction: column;
        align-items: center;
    }

    .delivery-options .delivery-option .delivery-option-image{
        margin-bottom: 8px;
        margin-right: 0;
    }
}

/* .utils.last-item{
    border-bottom: 1px solid #ececec;
    margin-bottom: 10px;
    padding-bottom: 15px !important;
} */

.utils-requirements:last-child{
    border-bottom: 1px solid #ececec;
    margin-bottom: 10px;
    padding-bottom: 15px !important;
}

/* .utils-includes:last-child{
    border-bottom: 1px solid #ececec;
    margin-bottom: 10px;
    padding-bottom: 15px !important;
} */

.utils-extras:last-child, .utils-includes:last-child, .utils-requirements:last-child{
    border-bottom: 1px solid #ececec;
    margin-bottom: 10px;
    padding-bottom: 15px !important;
}


.utils-container{
    margin-top: -15px;
}


.utils{
    display: flex;
    padding-bottom: 5px;
    padding-top: 5px;
    font-size: 16px;
}
/* .utils .util-item-value{
    text-align: right;
} */
.utils .util-item-name , .util-item-value{
    width: 50%;
    text-align: center;
}

@media screen and (max-width:450px) {
    .utils{
        font-size: 13px;
    }

}

.view-ad .smz-box-margin-top-bg{
    margin-top: 3rem;
}
.view-ad .smz-box-margin-bottom-bg{
    margin-bottom: 3rem;
}


@media screen and (max-width:768px) {
    .utils .util-item-value{
        width: 35%;
        text-align: inherit;
    }
    .utils .util-item-name{
        width: 65%;
        text-align: inherit;
    }

    .view-ad .smz-box-margin-top-bg{
        margin-top: 0 !important;
    }
    .view-ad .smz-box-margin-bottom-bg{
        margin-bottom: 0 !important;
    }

}

</style>