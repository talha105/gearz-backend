<template>

<div class="terms-and-conditions">
    <loader :small="false" v-if="loading" class="mt-4"></loader>

    <div class="english-description content"  v-if="page && $store.getters.ltr" v-html="page.content"></div>
    <div class="arabic-description content" v-if="page && $store.getters.rtl" v-html="page.ar_content"></div>
    <!-- <div class="content content-ar" v-if="$store.getters.rtl" >
        <div class="top-text">
        يُرجى قراءة هذه المعلومات القانونية المهمة التي تحكم استخدامكم لموقع موتوركوم والخدمات.
        </div>
        <div class="main-heading">
            مرحبا بكم في موتوركم.
        </div>


        (هانى المهرى للتعامل الإلكتروني ذ.م.م) مقرها في دولة الإمارات العربية المتحدة وتمتلك وتشغل الموقع الإلكتروني  (Motorcom.com)  والتطبيق (mMotorco). 
        <div class="section-margins"></div>

        (نحن / لنا / موتوركم / الشركة / المنصة): إلى (هانى المهرى للتعامل الإلكترونى ذ.م.م) الذي يوفر الموقع والتطبيقات ويديرها.
        <div class="section-margins"></div>

        (موتوركو) تشير إلى الموقع الإلكتروني موتوركم دوت كوم والتطبيق موتوركم.
        <div class="section-margins"></div>

        موتوركم هي بوابة إعلانات مبوبة مجانية توفر للبائعين فرصة الإعلان عن منتجاتهم ونشرها مع مقطع فيديو قصير لجذب المزيد من الاهتمام لسهولة التأجير وعدد كبير من الخدمات ضمن أنواع واسعة من الفئات والفئات الفرعية، وفرصة المشترين لتصفح، والبحث عن، والاتصال بالمؤجر لاستئجار المنتجات.
        <div class="section-margins"></div>

        تحدد شروط الاستخدام هذه الاتفاقية المبرمة بينكم وبين موتوركم / (هانى المهرى للتعامل الإلكترونى ذ.م.م)
        حيث إنها تحكم استخدامكم للمنتجات والخدمات التي نقدمها من خلال موقعنا الإلكتروني وتطبيقاتنا (يشار إليها مجتمعة باسم موتوركم.
        <div class="section-margins"></div>

        باستخدامكم موتوركم فأنكم توافقون على الشروط التالية:-
        <div class="section-margins"></div>

        ربما توفر موتوركوم ترجمة للنسخة الإنجليزية من الشروط إلى لغات أخرى. أي ترجمة للشروط إلى لغات أخرى هي لراحتكم فقط، والنسخة العربية هي التي تحكم شروط علاقتكم مع موتوركوم.
        من أجل الوصول إلى بعض الخدمات أو جزء منها واستخدامها، قد يُطلب منكم تسجيل حسابكم معنا وإنشاء حساب بعنوان بريدكم الإلكتروني وكلمة مرور.
        <div class="section-margins"></div>

        سيكون عنوان البريد الإلكتروني الذي تقدمونه هو عنوان بريدكم الإلكتروني، وأنتم وحدكم المسؤولين عن الحفاظ على سرية كلمة المرور الخاصة بكم.
        <div class="section-margins"></div>

        أنتم وحدكم المسؤولين عن جميع الأنشطة التي تحدث تحت حسابكم.
        <div class="section-margins"></div>

        لذلك، يجب عليكم حماية كلمة المرور الخاصة بكم.
        <div class="section-margins"></div>

        يمكنكم الاتصال بالخدمات من خلال خدمة جهة خارجية (على سبيل المثال، فيسبوك) وتمنحونا الإذن بالوصول إلى معلوماتكم وتخزينها واستخدامها من تلك الخدمة على النحو الذي تسمح به تلك الخدمة وكما هو موضح في سياسة الخصوصية.
        <div class="section-margins"></div>

        إذا كنتم تعتقدون أنه قد تم اختراق حسابكم أو إساءة استخدامه، فاتصلوا بنا على الفور على دعم عملاء موتوركم.
        <div class="section-margins"></div>

        باستخدام موتوركم، سيتم نشركم في الفئة أو المنطقة المناسبة ولن تفعلوا أيا من الأشياء السيئة التالية: -
        <div class="section-margins"></div>

        انتهاك أي قوانين أو سياسة المحتوى المحظور لدينا ، تقديم معلومات خاطئة أو مضللة ، انتهاك أي حق لطرف ثالث ، توزيع أو احتواء بريد عشوائي أو رسائل متسلسلة أو مخططات هرمية ، توزيع فيروسات أو أي تقنيات أخرى قد تضر موتوركم أو مصالح أو ممتلكات مستخدمي موتوركم ، فرض عبء غير معقول على بنيتنا التحتية أو التدخل في العمل السليم لشركة موتوركم ، نسخ أو تعديل أو توزيع محتوى أي شخص آخر ، استخدام أي روبوت أو عنكبوت أو مكشطة أو أي وسيلة آلية أخرى للوصول إلى متوركوم وجمع المحتوى لأي غرض دون إذن كتابي صريح منا ، حصاد أو جمع معلومات عن الآخرين ، بما في ذلك عناوين البريد الإلكتروني ، دون تضمين معلومات شخصية أو معرِّفة لشخص آخر دون موافقة صريحة منه، المحتوى المحظور.
        سيتم حذف أي منشور يحتوي على شيء غير قانوني بموجب قانون دولة الإمارات العربية المتحدة، بمجرد تحديده وتحتفظ موتوركوم بالحق في حذف حساب المستخدم بشكل دائم، وإدراج الحساب في القائمة السوداء، و / أو الإبلاغ عن المحتوى ومعلومات المستخدم إلى هيئة إنفاذ القانون أو السلطة المناسبة.
        <div class="section-margins"></div>

        ومع ذلك، سواء قررنا اتخاذ أي من هذه الخطوات، أو إزالة المحتوى المستضاف أو إبقاء المستخدم خارج موتوركوم أم لا، فإننا لا نتحمل أي مسؤولية المراقبة أو عن محتوى غير مصرح به أو غير قانوني على موتوركوم أو استخدام موتوركوم من قبل المستخدمين.
        <div class="section-margins"></div>

        يحق لموتوركم، وفقا لتقديرها الخاص والمطلق، رفض أو حذف أو نقل أي محتوى أو عضوية في أي وقت.
        إرشادات السلامة والأمن التعاملات.
        <div class="section-margins"></div>

        يمكنكم التأجير / البيع من خلال موتوركوم من خلال إيجاد السلعة التي تريد شراءها أولا ، ثم التواصل مع المعلن من خلال طرق الاتصال المتاح والاستفسار عما تريدونه ، والاتفاق على البيع والتسليم ، ولكي تكونوا بأمان دون احتيال ، يرجى التحقق من ذلك يوجد منتج حقيقي ، بفحصه ، لا ترسلوا أي مبالغ نقدية لأي شخص دون تأكيد المعلن والسلعة ، ويفضل التواصل مع المعلن وإجراء مقابلة على البيئة الحقيقية ، وتجنب الدفع المسبق والشحن ، الخطوات التي يجب اتباعها عند الشراء و البيع ، يمكنكم اتباع النصائح والخطوات التالية عند الشراء والبيع في السوق المفتوح :-
        <div class="section-margins"></div>

        1-	اختيار البائع / العناصر بحكمة.
        2-	عدم إرسال أي أموال قبل الموافقة على الحصول على الخدمة المقدمة من البائع.
        3-	طلب صور المنتج الفعلية.
        4-	التعرف على حالة المنتج. (سؤال عن جميع الاستفسارات الرئيسية والثانوية حول الإعلان مثل حالة المنتج).
        5-	التأكد من سعر المنتج بحيث يكون ضمن حدود مناسبة.
        6-	استخدم طرق دفع آمنة.
        <div class="section-margins"></div>


        يعمل كوسيط، وليس في توفير خدمة الإيجار نفسها<b>موتوركوم</b>

        <div class="section-margins"></div>

        موتوركوم، يعمل على تسهيل الخدمات من خلال الموقع والتطبيقات، بين المستخدم / المستأجر والمؤجر.
        <div class="section-margins"></div>

        موتوركوم، هي المسؤولة فقط عن إدارة الموقع والتطبيقات لربط المستأجر مع المؤجر من خلال قنوات آمنة.
        يؤكد استخدامكم للتطبيق موافقتكم على شروط الاستخدام هذه. استخدام التطبيق. يمنحكم موتوركوم الحق في استخدام التطبيق لاستخدامكم الشخصي فقط. يجب أن تمتثل لجميع القوانين المعمول بها في دولة الإمارات العربية المتحدة.
        <div class="section-margins"></div>

        بمجرد تنزيل التطبيق واستخدامه يكون وفقا لتقديركم الخاص وعلى مسؤوليتكم الخاصة، وأنتم وحدكم المسؤولين عن أي أضرار تلحق بجهازكم (أجهزتكم) أو فقدان البيانات الناتج عن تنزيل التطبيق أو استخدامه.
        <div class="section-margins"></div>

        الملكية الفكرية - التطبيقات. تمتلك شركة موتوركوم، أو المرخص لها، جميع الحقوق والملكية والمصلحة في وتطبيقاتها، بما في ذلك جميع الحقوق الممنوحة بموجب براءات الاختراع وحقوق النشر والأسرار التجارية والعلامات التجارية وأي وجميع حقوق الملكية الأخرى، بما في ذلك جميع التطبيقات والتجديدات والإضافات و تعديلها.
        <div class="section-margins"></div>

        لقد وافقتم على عدم تعديل أو تكييف أو ترجمة أو إعداد أعمال مشتقة من أو إلغاء التحويل البرمجي أو الهندسة العكسية أو التفكيك أو محاولة استنباط كود المصدر من أي تطبيق، ولن تقوموا بإزالة أو إخفاء أو تغيير إشعار حقوق النشر الخاص بشركة موتوركوم أو العلامات التجارية أو إشعارات حقوق الملكية الأخرى الملصقة أو المضمنة في أو التي يتم الوصول إليها بالاقتران مع أو عن طريق أي تطبيق من تطبيقات موتوركوم.
        <div class="section-margins"></div>

        تخضع سياسة الخصوصية، وكذلك وصولكم إلى الموقع الإلكتروني والتطبيقات، لقوانين دولة الإمارات العربية المتحدة التي تطبق في إمارة دبي دون أن تُدخل أي تأثير على تعارض مبادئ القانون. يخضع أي نزاع يتعلق بهذه السياسة أو تعاملنا مع معلوماتكم الشخصية ومعلوماتكم العامة إلى الاختصاص القضائي الحصري للمحاكم في دبي.

    </div> -->

    <!-- <div class="content" v-if="$store.getters.ltr" >

        <div class="top-text">
            PLEASE READ THIS IMPORTANT LEGAL INFORMATION THAT GOVERNS YOUR USE OF THE MOTORCOM.COM WEBSITE AND THE SERVICES.
        </div>

        <div class="main-heading">
            Welcome to MOTORCOM
        </div>

        In this privacy policy the following words, shall have the following meaning:-

        <div class="section-margins"></div>

        (…………………) is based in the UAE and owns and operates the Internet website (Motorcom.com) and the application (Motorcom).

        <div class="section-margins"></div>
        (We/us/our/motorcom/the company/the platform): refer to (…………...L.L.C) the one who provides the website & applications and manage it.

        <div class="section-margins"></div>
        (Motorcom): Refer to the website (motorcom.com) and the app (motorcom).

        <div class="section-margins"></div>

        <b>MOTORCOM</b> is a free classifieds portal that offers sellers the opportunity to advertise and post their products together with a short video to call more attention for easy renting and, large number of services under a vast type of categories and sub-categories, and the opportunity for buyers to browse, search for, and contact lessor to rent the listed products or services. 
        <div class="section-margins"></div>

        These Terms of Use sets forth the agreement between you and motorcom/ ……... L.L.C.
        <div class="section-margins"></div>

        It governs your use of the products and services we offer through our website and applications, collectively the motorcom.
        <div class="section-margins"></div>

        By using/ accessing motorcom you are agreeing to the following terms:-
        <div class="section-margins"></div>

        Motorcom may provide a translation of the English version of the Terms into other languages. Any translation of the Terms into other languages is for your convenience only and the Arabic version governs the terms of your relationship with motorcom. 
        <div class="section-margins"></div>

        Your Account, in order to access and use some or a portion of the Services, you may be required to register with us and set up an account with your email address and a password.
        <div class="section-margins"></div>

        The email address you provide will be your email address, and you are solely responsible for maintaining the confidentiality of your password.
        <div class="section-margins"></div>

        You are solely responsible for all activities that occur under your Account.
        <div class="section-margins"></div>
        Therefore, you should protect your password.
        <div class="section-margins"></div>


        You may connect to the Services with a third-party service (e.g., Facebook) and you give us permission to access, store, and use your information from that service as permitted by that service and as may be described in our Privacy Policy.
        <div class="section-margins"></div>

        If you believe your Account may have been compromised or misused, contact us immediately at motorcom Customer Support.
        <div class="section-margins"></div>


        By Using motorcom, you will post in the appropriate category or area and will not do any of the following bad things:-
        <div class="section-margins"></div>

        violate any laws or our Prohibited Content Policy; be false or misleading; infringe any third-party right; distribute or contain spam, chain letters, or pyramid schemes; distribute viruses or any other technologies that may harm motorcom or the interests or property of motorcom users; impose an unreasonable load on our infrastructure or interfere with the proper working of motorcom; copy, modify, or distribute any other person's content; use any robot, spider, scraper or other automated means to access motorcom and collect content for any purpose without our express written permission; harvest or otherwise collect information about others, including email addresses, without their consent; bypass measures used to prevent or restrict access to motorcom, include personal or identifying information about another person without that person's explicit consent; Prohibited content.

        <div class="section-margins"></div>
        Any post that contains something illegal the UAE law will be deleted, once we identify it and motorcom reserves the right to permanently delete the user account, blacklisting the account, and/or reporting the content and the user information to Law Enforcement or the appropriate Authority.
        <div class="section-margins"></div>

        However, whether we decide to take any of these steps, remove hosted content or keep a user off motorcom or not, we do not accept any liability for monitoring or for unauthorized or unlawful content on motorcom or use of motorcom by users.
        <div class="section-margins"></div>

        Motorcom has the right, at its sole and absolute discretion, to refuse, delete or move any content or membership at any time. 
        <div class="section-margins"></div>

        <div class="section-heading"> Safety & Security Tips Dealings.</div>
        You can rent/sell through motorcom by finding the item you want to buy first, then contact the advertiser through the available communication methods and inquire about what you want, and agree on the sale and delivery, To be safe without fraud, please verify that there is a real product, inspect it, do not send any cash to anyone without confirming the advertiser and the commodity, preferably communicate with the advertiser and interview on the real environment, and avoid the prepayment and shipping done, Steps to follow when buying and selling, you can follow the following tips and steps when buying and selling on the open market site:
        <div class="section-margins"></div>


        1-	Choose the seller/Items wisely.
        2-	Do not send any money before agreeing to getting the service provided by the seller.
        3-	Order actual product images.
        4-	Know the product status. (Ask them all major and minor inquiries about the ad such as product status.
        5-	Make sure the price of the product so that it is reasonable limits.
        6-	Use secure payment methods.


        <div class="section-margins"></div>

        Motorcom works as an intermediate, and not in the provision of the rent service itself.
        <div class="section-margins"></div>

        Motorcom, working to make the services easier through the website & applications, between the user/tenant and the lessor.
        <div class="section-margins"></div>

        Motorcom, is only responsible for managing the site and applications to connect the lessee with the lessor through secure channels.

        <div class="section-margins"></div>
        Your use of the Application confirms your agreement to these Terms of Use. Application Use. motorcom grants you the right to use the Application only for your personal use. You must comply with all applicable laws in UAE.

        <div class="section-margins"></div>
        once download and use of the Application is at your own discretion and risk, and you are solely responsible for any damages to your hardware device(s) or loss of data that results from the download or use of the Application.

        <div class="section-margins"></div>
        Intellectual Property - Applications. motorcom owns, or is the licensee to, all right, title, and interest in and to its Applications, including all rights under patent, copyright, trade secret, trademark, and any and all other proprietary rights, including all applications, renewals, extensions, and restorations thereof.

        <div class="section-margins"></div>
        You agreed, will not modify, adapt, translate, prepare derivative works from, decompile, reverse-engineer, disassemble, or otherwise attempt to derive source code from any Application and you will not remove, obscure, or alter motorcom copyright notice, trademarks or other proprietary rights notices affixed to, contained within, or accessed in conjunction with or by any motorcom Application.

        <div class="section-margins"></div>

        This Policy, as well as your access to the Website & applications, is subject to and governed by the laws of the United Arab Emirates as applied in the Emirate of Dubai without giving effect to conflicts of law principles thereof. Any dispute regarding this Policy or our handling of your Personal Information and General Information shall be subject to the exclusive jurisdiction of the Courts in Dubai.



    </div> -->
<bottom-nav></bottom-nav>

</div>

</template>

<script>
export default {
    created(){
        this.getPageData();
    },
    data(){
        return{
            page: '',
            loading: false,
        }
    },
    methods:{
        // getPageData(){
        //     this.loading = true
        //     axios.post('/api/page-data' , {
        //         slug: 'terms-and-condition',
        //     }).then( res => {
        //         this.loading = false
        //         this.page = res.data.page;
        //     }).catch( err => {
        //         this.loading = false
        //         console.log(err)
        //     })
        // }

        getPageData(){
            this.loading = true
            axios.post('/api/page-data' , {
                slug: 'terms-and-condition'
            }).then( res => {
                this.loading = false

                if(res.data.page){
                    this.page = res.data.page;
                }
            }).catch( err => {
                this.loading = false
                console.log(err)
            })
        },
    }
}
</script>

<style>
.terms-and-conditions .english-description{

}
/* english-description
arabic-description */
.terms-and-conditions .ql-align-center{
    text-align: center;
}
.terms-and-conditions .ql-align-right{
    text-align: right;
}


.terms-and-conditions *{
    margin-bottom:  0 !important;
}
.terms-and-conditions {
    position: relative;
    height: 100vh;
    padding-bottom: 50px;
    line-height: 1.5;

}

.terms-and-conditions .main-heading{
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}
.terms-and-conditions .top-text{
    font-size: 18px;
    margin-bottom: 10px;
    text-align: center;
}
.terms-and-conditions .section-heading{
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 7px;
    margin-top: 10px;
}
.terms-and-conditions .content{
    padding: 40px 100px;
    font-size: 17px;
    padding-bottom: 75px;
}
@media screen and (max-width:768px){
    .terms-and-conditions .content{
        padding: 25px;
        padding-bottom: 75px !important;
    }
}
.terms-and-conditions .content.content-ar{
    font-size: 20px;
}
/* .terms-and-conditions .content br{
    margin: 8px 0;
} */
.terms-and-conditions .content .section-margins{
    margin: 8px 0;
}
</style>