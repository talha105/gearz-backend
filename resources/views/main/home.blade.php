<!DOCTYPE html>
<html lang="en" @if(session('locale') == 'ar') dir="rtl" @endif >
    {{--  dir="rtl"  --}}
{{--  <html lang="en" style="direction: rtl;" >  --}}
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gearz</title>
    <meta name="HandheldFriendly" content="true" />

    {{--  <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">  --}}


    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link href='http://www.fontonline.ir/css/BKoodakBold.css' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    {{--  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css" />



    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">  --}}

    {{--  <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css"
        rel="stylesheet"
        />  --}}


    <style>

        ._wrapper{
            {{--  margin-top: 60px;  --}}
        }
        .right-menu{
            font-size: 20px;
            position: absolute;
            right: 15px;
            top: 13px;
        }
        @media screen and (max-width:768px){
            .right-menu{
                font-size: 20px;
                position: absolute;
                right: 10px;
                top: 7px;
            }
        }
        .language-change-btn:hover{
            text-decoration: none;
        }
        .language-change-btn{
            padding: 5px 13px;
            color: white !important;
            border-radius: 5px;
            text-decoration: none;
            background-color: #0e2859;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="wrapper" id="app">
    <div class="main-head"  style="display:none !important;">
        <i class="fas fa-arrow-left back-btn" v-if="$route.path != '/'" @click="$router.back()" ></i>
        <router-link to="/">
            @if($page && $page->content)
            <img src="{{ asset('images/'.$page->content) }}" />
            @else
            <img src="{{ asset('images/GEARZ.png') }}" />
            @endif
        </router-link>

        <div class="right-menu">
            @if(session('locale') == 'ar')
            <a href="/change-language/en" class="language-change-btn" > English </a>
            @else
            <a href="/change-language/ar" class="language-change-btn" > العربية </a>
            @endif
        </div>
    </div>
        <div class="wrapper">
            <wrapper locale="{{session('locale')}}" ></wrapper>
        </div>
    </div>


    <script>
        window.default_locale = "{{ config('app.locale') }}";
        window.fallback_locale = "{{ config('app.fallback_locale') }}";
        window.languages = @json($languages);
</script>


    <script src="{{asset('/js/main.js')}}"></script>
    <script src="{{asset('/js/manifest.js')}}"></script>
    <script src="{{asset('/js/vendor.js')}}"></script>
    {{--  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js" ></script>  --}}



    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>

    <script>
    $('.carousel').on('touchstart', function(event){
    const xClick = event.originalEvent.touches[0].pageX;
        $(this).one('touchmove', function(event){
            const xMove = event.originalEvent.touches[0].pageX;
            const sensitivityInPx = 5;

            if( Math.floor(xClick - xMove) > sensitivityInPx ){
                $(this).carousel('next');
            }
            else if( Math.floor(xClick - xMove) < -sensitivityInPx ){
                $(this).carousel('prev');
            }
        });
        $(this).on('touchend', function(){
            $(this).off('touchmove');
        });
    });
    {{--  $(document).ready(function () {
        $('.carousel').each(function(){
            $(this).carousel();

            var carousel = $(this).data('bs.carousel'); // or .data('carousel') in bootstrap 2
            carousel.pause();

            // At first, reverse the order of the items in the carousel because we're moving backwards
            $(this).find('> .carousel-inner > .item:not(:first-child)').each(function() {
                $(this).prependTo(this.parentNode);
            });

            // Override the bootstrap carousel prototype function, adding a different one won't work (it'll work only for the first slide)
            carousel.cycle = function (e) {
                if (!e) this.paused = false
                if (this.interval) clearInterval(this.interval);
                this.options.interval
                && !this.paused
                && (this.interval = setInterval($.proxy(this.prev, this), this.options.interval))
                return this;
            };

            carousel.cycle();
        });
    });  --}}

    </script>

    {{--  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.rtlcss.com/bootstrap/v4.5.3/js/bootstrap.bundle.min.js" integrity="sha384-40ix5a3dj6/qaC7tfz0Yr+p9fqWLzzAXiwxVLt9dw7UjQzGYw6rWRhFAnRapuQyK" crossorigin="anonymous"></script>  --}}

</body>
</html>