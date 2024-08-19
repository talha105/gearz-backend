@extends('layouts.auth-md')
{{--
@section('title')
<a href="/"><b>GEARZ </b>ADMIN</a>
@endsection

@section('content')

    <p class="login-box-msg">Sign in</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control  @error('email') is-invalid @enderror input-fields" name="email" value="{{ old('email') }}" required placeholder="email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror input-fields" name="password" required  placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
            @enderror
        </div>
        <div class="row">
            <div class="col-8">

            </div>
            <!-- /.col -->
            <input type="hidden" name="role" value="1" />

            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <p class="mb-1">
        <a href="{{route('password.request')}}">I forgot my password</a>
    </p>

@endsection  --}}


@section('styles')
    <style>
        .container{
            margin-top: 15% ;
            {{--  margin-top: 150px ;  --}}
        }
    </style>
@endsection

@section('content')

<div class="container">
<div class="row">
    <div class="offset-md-4 offset-lg-4 col-12 col-sm-12 col-md-4 col-lg-4">

<section class="mb-5 login-form">
    <div class="card">
    <div class="card-header text-center">
        Gearz Login
    </div>
    <div class="card-body">
    {{--  <form class="needs-validation" novalidate autocomplete="off">
        <input type="text"  class="form-control">

      <div class="md-form md-outline">
        <input type="email" name="login-email" id="login-email" class="form-control">
        <label data-error="wrong" data-success="right" for="login-email">Your email</label>
      </div>
      <div class="md-form md-outline">
        <input type="password" name="login-password" id="login-password" class="form-control">
        <label data-error="wrong" data-success="right" for="login-password">Your password</label>
      </div>

      <div class="d-flex justify-content-end align-items-center mb-2">


        <p><a href="#">Forgot password?</a></p>

      </div>

      <div class="text-center pb-2">

        <button type="submit" class="btn btn-primary mb-4">Sign in</button>

      </div>

    </form>  --}}


    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-4 @error('email') mb-5 @enderror ">
            <input type="text" class="form-control  @error('email') is-invalid @enderror input-fields" name="email" value="{{ old('email') }}" required placeholder="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="input-group mb-4">
            <input type="password" class="form-control @error('password') is-invalid @enderror input-fields" name="password" required  placeholder="Password">

            @error('password')
            <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
            @enderror
        </div>
        <div class="row">
            <div class="col-8">

            </div>
            <!-- /.col -->
            <input type="hidden" name="role" value="1" />

            <div class="col-md-4 col-lg-4 col-sm-12 col-12 text-center">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</section>
</div>
    </div>
    </div>

@endsection
