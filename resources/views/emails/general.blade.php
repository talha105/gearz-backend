<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gearz</title>

    <style>
        .mt--header{
            height: 70px;
            text-align: center;
            width: 100%;
            background-color: #fff;
            border-bottom: 1px solid #ececec;
        }
        .mt--footer .text{
            padding: 25px 0;
        }
        .mt--footer{
            text-align: center;
            width: 100%;
            /* background-color: #0e2859; */
            color: white;
            font-size: 15px;
        }
        .mt--header img{
            height: 60px;
        }
        .mt--email-content{
            padding: 40px 70px;
            max-width: 1200px;
            min-height: 60vh;
        }
        @media screen and (max-width:768px){
            .mt--email-content{
                padding: 20px;
            }
        }

    </style>
</head>
<body>
    @php
        $page = \App\Page::where('slug' , 'logo')->first();
    @endphp
    <div>

        <div class="mt--header">
            {{--  <img src="{{asset('images/GEARZ.png')}}" />  --}}
            @if(isset($page) && $page->content)
                <img src="{{ asset('images/'.$page->content) }}"/>
            @else
                <img src="{{ asset('images/GEARZ.png') }}"/>
            @endif
        </div>

        <div class="mt--email-content">
            {!! $msg !!}
        </div>

        <div class="mt--footer">
            <div class="text">
                All Rights Reserverd Gearz@2022
            </div>
        </div>

    </div>
</body>
</html>
