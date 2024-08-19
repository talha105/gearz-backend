<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gearz Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .login-page{
            {{--  display: flex;
            justify-content: center;
            align-items: center;  --}}
            background-color: #fafafa;
            height: 100vh;
        }
        .login-box{
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
            border-radius: 2px;
            margin-top: 50px;
        }
        .login-page button{
            float: right;
            background-color: #0e2859 !important;
        }
        .login input{
            padding: 10px 15px;
            border: 1px solid #cecece;
            border-radius: 5px;
        }

        input.valid:not([type]), input.valid:not([type]):focus, input.valid[type=text]:not(.browser-default), input.valid[type=text]:not(.browser-default):focus, input.valid[type=password]:not(.browser-default), input.valid[type=password]:not(.browser-default):focus, input.valid[type=email]:not(.browser-default), input.valid[type=email]:not(.browser-default):focus, input.valid[type=url]:not(.browser-default), input.valid[type=url]:not(.browser-default):focus, input.valid[type=time]:not(.browser-default), input.valid[type=time]:not(.browser-default):focus, input.valid[type=date]:not(.browser-default), input.valid[type=date]:not(.browser-default):focus, input.valid[type=datetime]:not(.browser-default), input.valid[type=datetime]:not(.browser-default):focus, input.valid[type=datetime-local]:not(.browser-default), input.valid[type=datetime-local]:not(.browser-default):focus, input.valid[type=tel]:not(.browser-default), input.valid[type=tel]:not(.browser-default):focus, input.valid[type=number]:not(.browser-default), input.valid[type=number]:not(.browser-default):focus, input.valid[type=search]:not(.browser-default), input.valid[type=search]:not(.browser-default):focus, textarea.materialize-textarea.valid, textarea.materialize-textarea.valid:focus, .select-wrapper.valid>input.select-dropdown{
            border-color: #0e2859;
        }
        /* label focus color */
        .input-field input[type=text]:focus + label {
          color: #0e2859;
        }
     /* label underline focus color */
        .input-field input[type=text]:focus {
          border-bottom: 1px solid #0e2859;
          box-shadow: 0 1px 0 0 #0e2859;
        }

        /* label focus color */
        .input-field input:focus + label {
            color: #0e2859 !important;
        }
        /* label underline focus color */
        .row .input-field input:focus {
            border-bottom: 1px solid #0e2859 !important;
            box-shadow: 0 1px 0 0 #0e2859 !important
        }

        .mt-tabs .mt-tab.first{
            border-radius: 50px 0 0 50px;
        }
        .mt-tabs .mt-tab.second{
            border-radius: 0 50px 50px 0;
        }
        .mt-tabs .mt-tab.active{
            background-color: #0e2859;
            color: white;
        }
        .mt-tabs .mt-tab{
            color: #0e2859;
            background-color: #ffffff;
            border: 1px solid #0e2859;
            width: 45%;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        .mt-tabs{
            width: 100%;
            margin-top: 20vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .row{
            margin-bottom: 0 !important;
        }

    </style>
</head>
<body>
    <div class="login-page">

        <div class="row mb-0">
            <div class="col s4 offset-s4">

                <div class="mt-tabs">
                    <div class="mt-tab  first active">View</div>
                    <div class="mt-tab second ">Seller</div>
                </div>
                <div class="login-box">


                <form action="{{route('userLogin')}}" method="POST"  autocomplete="off" >
                    @csrf

                    <div class="row">
                        <div class="input-field">
                            <input id="last_name" name="email"  type="text" class="validate" autocomplete="off" >
                            <label for="last_name">Last Name</label>
                        </div>

                        <div class="input-field">
                            <input id="last_name" name="password"  type="password" class="validate" autocomplete="off" >
                            <label for="last_name">Password</label>
                        </div>
                        <div class="input-field">
                            <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">login</i> Signin</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

{{--  <div class="login-page">
    <div class="login-box">
        <div class="login">
            <div class="input-group">
                <input type="text" class="login-input" placeholder="Email" />
            </div>
            <div c>
                <input type="password" class="login-input" placeholder="Password" />
            </div>

            <div>
                <button class="submit-btn" type="submit">Signi</button>
            </div>
        </div>
    </div>
</div>  --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>


</body>
</html>
