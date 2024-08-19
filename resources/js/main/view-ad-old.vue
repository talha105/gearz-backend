<template>
  <div class="view-ad">


      <div class="bread-crumbs my-3">
          <div class="bread-crumbs-item">Vehicles 
              <!-- <i class="fas fa-angle-right"></i>  -->
              </div>
          <!-- <div class="bread-crumbs-item">Hot Picks </div> -->
      </div>


      <div class="row">
          <div class="col-12 col-sm-12 col-md-8 col-lg-8 smz-box-container">
              <div class="smz-box ad-image-slider p-0">


                    <div class="product-image-gallery">
                        <div class="splide" id="primary-slider">
                            <div class="splide__track">
                                <ul class="splide__list imglist" >
                                    <li class="splide__slide" v-for="(image,index) in dummy_images" :key="index">
                                        <a data-fancybox="images" :href="image">
                                            <img :src="image" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div id="secondary-slider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide" v-for="(image,index) in dummy_images" :key="index">
                                        <img :src="image" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                <div class="ad-price">Starting From AED
                    <br>
                    <span class="price-digit">499/ Day </span> 
                    <br>
                    <span class="price-digit">2,499/ Week</span> 
                    <br>
                    <span class="price-digit">14,000/ Month </span> 
                </div>


                <!-- <div class="ad-price">Starting From AED  <span class="price-digit">499/day</span> </div>
                <div class="ad-price">Starting From AED  <span class="price-digit">2499/month</span> </div>
                <div class="ad-price">Starting From AED  <span class="price-digit">64999/year</span> </div> -->
                <div class="ad-title">Toyota FJ Cruiser VXR 4.0L
                    <div class="ratings float-right mr-3">
                        <star-rating 
                            active-color="#0e2859"
                            v-model="rating" 
                            :read-only="true" 
                            :round-start-rating="false"
                            :show-rating="false"
                            :star-size="20" 
                        ></star-rating>
                    </div>
                </div>
              </div>

                <div class="ad-category-list">
                    <div class="category-item">
                    <span>Vehicles</span>
                    <!-- <svg _ngcontent-smartarz-client-c122="" height="7" width="7"><circle _ngcontent-smartarz-client-c122="" cx="3" cy="4" r="1.5" stroke="black" stroke-width="3" fill="black"></circle></svg> -->
                    </div>

                    <!-- <div class="category-item"> Hot Picks </div> -->
                </div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 padding-lg">
                        <div class="smz-box h-100">
                            <div class="smz-box-title-with-border">
                                Vehicle Overview
                            </div>


                            <div class="ad-features">
                                <div class="feature-item">
                                    <div class="feature-item-image">
                                        <img src="/img/safety-seat.png"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">4 Seats</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <div class="feature-item-image">
                                        <img src="/img/car-door.png"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">4 Doors</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <div class="feature-item-image">
                                        <img src="/img/year.svg"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">2019</div>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <div class="feature-item-image">
                                        <img src="/img/transmission.svg"  />
                                    </div>
                                    <div class="feature-item-details">
                                        <div class="">Automatic</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 vehicle-details">
                        <div class="smz-box h-100">
                            <div class="smz-box-title-with-border">
                                Features
                            </div>

                            <div class="ad-specs">
                                <div class="spec-item">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>



                

                <div class="smz-box mt-5 text-center action-btns-area">
                    <button class="btn share-btn smz-btn-dark mr-2"> <i class="fas fa-share-square"></i> Share Ad</button>
                    <button class="btn report-btn smz-btn-red-light"><i class="fas fa-flag"></i> Report Post</button>
                </div>

                <div class="smz-box mt-5">
                    <div class="smz-box-title-with-border">
                        Description
                    </div>

                    <div class="ad-description-text">
                        The car is clean and ready to drive
                    </div>
                </div>
                
                <div class="smz-box mt-5">
                    <div class="smz-box-title-with-border">
                        Reivews
                    </div>

                    <div class="comment-section-text">
                        <div>
                            <span>
                            <i class="fas fa-lightbulb"></i>
                            Please note that its a public message and visible to everyone. For private chat click on chat button in detail section.</span>
                        </div>

                        <div class="comment-text">
                            <textarea class="form-control" placeholder="@Type here"></textarea>
                        </div>

                        <div class="comment-submit">
                            <button class="btn smz-btn-dark float-right">Submit</button>
                        </div>
                    </div>
                    
                </div>

          </div>


        <div class="col-12 col-sm-12 col-md-4 col-lg-4 padding-sm-none">
            <div class="smz-box">
                <div class="smz-box-title-with-border">
                    Posted By
                </div>

                <div class="user-info">
                    <div class="user-image-box">
                        <img src="/images/default-user-avatar.png" />
                    </div>

                    <div class="user-details">
                        <div class="listing-by">Listing By</div>
                        <div class="user-name">Cyber Rental Carz</div>
                        <!-- <div class="show-other-ads">(View Property Ads)</div> -->
                        <div class="verified">
                            <svg _ngcontent-smartarz-client-c111="" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c111="" d="M18.997 8.39739C18.9809 8.24248 18.9018 8.10161 18.7782 8.00805L17.2732 6.86238L17.8209 5.04616C17.8659 4.89749 17.8473 4.73635 17.7702 4.60172C17.6926 4.46709 17.5634 4.3704 17.4129 4.33505L15.5743 3.90361L15.3395 2.02085C15.3203 1.86646 15.2381 1.72716 15.113 1.63567C14.9878 1.54418 14.8306 1.50883 14.6785 1.53846L12.8244 1.89609L11.8475 0.271681C11.7673 0.138609 11.636 0.0445227 11.4849 0.0122943C11.3334 -0.0199341 11.1757 0.0117745 11.049 0.100662L9.5 1.18551L7.95053 0.101182C7.8233 0.0122943 7.66556 -0.0199341 7.51455 0.0128141C7.36301 0.0450425 7.23217 0.139129 7.152 0.2722L6.17557 1.89661L4.32148 1.53898C4.16943 1.50987 4.01221 1.5447 3.88705 1.63619C3.76189 1.72768 3.68018 1.86698 3.66052 2.02137L3.42572 3.90413L1.58715 4.33557C1.43665 4.37092 1.30736 4.46761 1.22978 4.60224C1.1522 4.73687 1.1341 4.89749 1.17909 5.04668L1.72679 6.8629L0.221795 8.00857C0.0987059 8.10265 0.0195774 8.24352 0.00302766 8.39791C-0.0130049 8.55281 0.0350928 8.7072 0.13646 8.82467L1.37149 10.2599L0.460215 11.9217C0.385741 12.0579 0.370225 12.219 0.418323 12.3667C0.465904 12.5143 0.57296 12.6359 0.712598 12.702L2.42188 13.5082L2.26207 15.3993C2.24914 15.5542 2.30034 15.7075 2.40378 15.8234C2.50721 15.9388 2.65357 16.0064 2.80821 16.0095L4.69592 16.0475L5.31498 17.8403C5.36567 17.9874 5.47479 18.1064 5.61598 18.1699C5.75717 18.2333 5.91853 18.2348 6.06076 18.1745L7.80055 17.4374L9.09143 18.8222C9.19745 18.9355 9.34485 19 9.49948 19C9.65412 19 9.80203 18.9355 9.90754 18.8222L11.1984 17.4374L12.9382 18.1745C13.081 18.2348 13.2418 18.2333 13.383 18.1699C13.5242 18.1064 13.6333 17.9874 13.684 17.8403L14.3031 16.0475L16.1908 16.0095C16.3454 16.0064 16.4918 15.9393 16.5952 15.8234C16.6986 15.708 16.7498 15.5547 16.7369 15.3993L16.5771 13.5082L18.2864 12.702C18.4265 12.6359 18.5331 12.5143 18.5806 12.3667C18.6282 12.219 18.6132 12.0579 18.5388 11.9217L17.6275 10.2599L18.8625 8.82467C18.9649 8.70668 19.013 8.55229 18.997 8.39739Z" fill="#0e2859"></path></svg>
                            <svg _ngcontent-smartarz-client-c111="" width="9" height="7" viewBox="0 0 9 7" fill="none" xmlns="http://www.w3.org/2000/svg" class="check_mark"><path _ngcontent-smartarz-client-c111="" d="M8.68711 1.90168L4.11131 6.67387C3.90251 6.89112 3.62939 7 3.35627 7C3.08315 7 2.80953 6.89112 2.60122 6.67387L0.312829 4.28778C-0.104276 3.85277 -0.104276 3.14736 0.312829 2.71235C0.729935 2.27734 1.40631 2.27734 1.82342 2.71235L3.35627 4.311L7.17702 0.326256C7.59412 -0.108752 8.2705 -0.108752 8.6876 0.326256C9.10421 0.761781 9.10421 1.46719 8.68711 1.90168Z" fill="white"></path></svg>
                            <span>Verified</span>
                            </div>
                        <div class="member-date"><svg _ngcontent-smartarz-client-c111="" width="20" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c111="" d="M17.8572 2.14284H15.7143V0.71442C15.7143 0.319752 15.3946 0 14.9999 0C14.6052 0 14.2855 0.319752 14.2855 0.71442V2.14284H5.71411V0.71442C5.71411 0.319752 5.39435 0 4.99969 0C4.60502 0 4.28568 0.319752 4.28568 0.71442V2.14284H2.14284C0.959257 2.14284 0 3.1021 0 4.28568V17.8572C0 19.0407 0.959257 20 2.14284 20H17.8572C19.0407 20 20 19.0407 20 17.8572V4.28568C20 3.1021 19.0403 2.14284 17.8572 2.14284ZM2.14284 3.57126H4.28568V4.99969C4.28568 5.39435 4.60544 5.71411 5.0001 5.71411C5.39477 5.71411 5.71452 5.39435 5.71452 4.99969V3.57126H14.2859V4.99969C14.2859 5.39435 14.6056 5.71411 15.0003 5.71411C15.395 5.71411 15.7147 5.39435 15.7147 4.99969V3.57126H17.8576C18.2522 3.57126 18.572 3.89102 18.572 4.28568V7.14295H1.42842V4.28568C1.42842 3.89102 1.74817 3.57126 2.14284 3.57126ZM17.8572 18.5712H2.14284C1.74817 18.5712 1.42842 18.2514 1.42842 17.8567V8.57137H18.5712V17.8572C18.5712 18.2514 18.2514 18.5712 17.8572 18.5712Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M5.71413 9.99979H4.28571C3.89104 9.99979 3.57129 10.3195 3.57129 10.7142C3.57129 11.1089 3.89104 11.4286 4.28571 11.4286H5.71413C6.1088 11.4286 6.42855 11.1089 6.42855 10.7142C6.42855 10.3195 6.1088 9.99979 5.71413 9.99979Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M10.7143 9.99979H9.28583C8.89116 9.99979 8.57141 10.3195 8.57141 10.7142C8.57141 11.1089 8.89116 11.4286 9.28583 11.4286H10.7143C11.1089 11.4286 11.4287 11.1089 11.4287 10.7142C11.4287 10.3195 11.1089 9.99979 10.7143 9.99979Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M15.7144 9.99979H14.286C13.8913 9.99979 13.5715 10.3195 13.5715 10.7142C13.5715 11.1089 13.8913 11.4286 14.286 11.4286H15.7144C16.109 11.4286 16.4288 11.1089 16.4288 10.7142C16.4288 10.3195 16.1086 9.99979 15.7144 9.99979Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M5.71413 12.857H4.28571C3.89104 12.857 3.57129 13.1768 3.57129 13.5715C3.57129 13.9661 3.89104 14.2859 4.28571 14.2859H5.71413C6.1088 14.2859 6.42855 13.9661 6.42855 13.5715C6.42855 13.1768 6.1088 12.857 5.71413 12.857Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M10.7143 12.857H9.28583C8.89116 12.857 8.57141 13.1768 8.57141 13.5715C8.57141 13.9661 8.89116 14.2859 9.28583 14.2859H10.7143C11.1089 14.2859 11.4287 13.9661 11.4287 13.5715C11.4287 13.1768 11.1089 12.857 10.7143 12.857Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M15.7144 12.857H14.286C13.8913 12.857 13.5715 13.1768 13.5715 13.5715C13.5715 13.9661 13.8913 14.2859 14.286 14.2859H15.7144C16.109 14.2859 16.4288 13.9661 16.4288 13.5715C16.4284 13.1768 16.1086 12.857 15.7144 12.857Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M5.71413 15.7143H4.28571C3.89104 15.7143 3.57129 16.0341 3.57129 16.4287C3.57129 16.8234 3.89104 17.1432 4.28571 17.1432H5.71413C6.1088 17.1432 6.42855 16.8234 6.42855 16.4287C6.42855 16.0341 6.1088 15.7143 5.71413 15.7143Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M10.7143 15.7143H9.28583C8.89116 15.7143 8.57141 16.0341 8.57141 16.4287C8.57141 16.8234 8.89116 17.1432 9.28583 17.1432H10.7143C11.1089 17.1432 11.4287 16.8234 11.4287 16.4287C11.4287 16.0341 11.1089 15.7143 10.7143 15.7143Z" fill="#0e2859"></path><path _ngcontent-smartarz-client-c111="" d="M15.7144 15.7143H14.286C13.8913 15.7143 13.5715 16.0341 13.5715 16.4287C13.5715 16.8234 13.8913 17.1432 14.286 17.1432H15.7144C16.109 17.1432 16.4288 16.8234 16.4288 16.4287C16.4288 16.0341 16.1086 15.7143 15.7144 15.7143Z" fill="#0e2859"></path></svg> 
                        <span> Member Since 05 Apr 2021</span>
                        </div>
                    </div>
                </div>


                <div class="user-number">
                    <svg _ngcontent-smartarz-client-c111="" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c111="" d="M16.5558 11.8148C15.4537 11.8148 14.3719 11.6423 13.3463 11.3034C12.8438 11.1319 12.2259 11.2894 11.9194 11.6044L9.89531 13.132C7.54828 11.8791 6.10219 10.4339 4.86656 8.10422L6.34969 6.13312C6.735 5.74828 6.87328 5.18625 6.70781 4.65891C6.3675 3.62812 6.19453 2.54672 6.19453 1.44422C6.19453 0.647812 5.54625 0 4.74984 0H1.44422C0.647812 0 0 0.647812 0 1.44422C0 10.5731 7.42688 18 16.5558 18C17.3522 18 18 17.3522 18 16.5558V13.2595C18 12.4631 17.3522 11.8148 16.5558 11.8148Z" fill="#0e2859"></path></svg>

                    <label class="user-number--digits" v-if="!showNumber"  >**********</label>
                    <label class="user-number--digits" v-else >+971552095949</label>

                    <a class="float-right btn smz-btn-lite show-number" @click="showNumber = !showNumber">Show Number</a>
                </div>

                <div class="ad-action-btns">
                    <button type="button" @click="goToLink('info@cyber-pixel.com')"  class="btn email-btn"> <i class="fas fa-envelope"></i> Email</button>
                    <button  @click="goToLink('https://wa.me/+971552095949?text=I%27m%20interested')" type="button" class="btn chat-btn"> 
                    <img class="whatsapp-icon-btn" src="/images/whatsapp.png"/> Chat</button>
                </div>
            </div>



            <div class="smz-box mt-5 location-area">
                <div class="smz-box-title-with-border">
                    Posted Location
                </div>

                <div class="location-text">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Dubailand, Dubai</span>
                    <img src="/images/map-btn.png" />
                </div>
            </div>
            <div class="smz-box mt-5">
                <div class="smz-box-title-with-border">
                    <i class="fas fa-lightbulb"></i>
                    General Tips:
                </div>
                <div class="general-tips">
                    <div class="tip-item">
                        <i class="fas fa-check"></i>
                        <span>Only meet in public and never share personal info.</span>
                    </div>
                    
                    <div class="tip-item">
                        <i class="fas fa-check"></i>
                        <span>Never Pay or transfer money in advance.</span>
                    </div>
                    
                    <div class="tip-item">
                        <i class="fas fa-check"></i>
                        <span>Inspect the product before you buy it.</span>
                    </div>
                </div>
                
            </div>


        </div>
    </div>




    <div class="action-btns-fixed">
        <div class="ad-action-btns mt-2 mb-2 text-center">
            <button @click="goToLink('https://wa.me/+971552095949?text=I%27m%20interested')" type="button" class="btn chat-btn"> <img class="whatsapp-icon-btn" src="/images/whatsapp.png"/>  Chat</button>
            <!-- <button @click="goToLink('https://wa.me/+971552095949?text=I%27m%20interested')" type="button" class="btn chat-btn"> <svg _ngcontent-smartarz-client-c110="" width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-smartarz-client-c110="" d="M20.1464 0H3.29526C1.47805 0 0 1.48458 0 3.30982V18.1426C0 18.8453 0.791379 19.2408 1.34906 18.8407L6.04271 15.4776C6.4365 15.1963 6.89934 15.047 7.38342 15.047H17.7055C19.5227 15.047 21.0008 13.5624 21.0008 11.7372V0.857366C21 0.3841 20.6176 0 20.1464 0ZM16.0006 10.3867H6.13755C5.66637 10.3867 5.28395 10.0026 5.28395 9.52934C5.28395 9.05608 5.66637 8.67198 6.13755 8.67198H15.9998C16.471 8.67198 16.8534 9.05608 16.8534 9.52934C16.8542 10.0026 16.4718 10.3867 16.0006 10.3867ZM16.0006 6.38566H6.13755C5.66637 6.38566 5.28395 6.00156 5.28395 5.5283C5.28395 5.05503 5.66637 4.67093 6.13755 4.67093H15.9998C16.471 4.67093 16.8534 5.05503 16.8534 5.5283C16.8542 6.00156 16.4718 6.38566 16.0006 6.38566Z" fill="white"></path></svg> Chat</button> -->
            <button @click="goToLink('tel:+971552095949')" type="button" class="btn email-btn"> <i class="fas fa-phone-alt"></i> Call</button>
        </div>
    </div>


</div>
</template>

<script>
export default {

    created(){
        this.initializeSliders();
    },
    methods:{
        goToLink(link){
            window.location.href = link;
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
                pagination : false,
                drag : true,
                //focus       : 'center',
                arrows     : false,

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
                height      : 410,
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
    },
    data(){
        return{
            showNumber: false,
            rating: 4,
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
</style>