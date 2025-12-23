@extends ('admin.plane')

@section('pagespecificstyles')
<link rel="stylesheet" href="{{ asset("plugins/captcha-slider/captcha-slider.css") }}" />
@stop

@section('pagespecificscripts')
<script src="{{ asset("plugins/captcha-slider/captcha-slider.js") }}" type="text/javascript"></script>

<script src="{{ asset('js/admin/login.js?v=').env('ASSET_V', 1) }}"></script>
@stop

<?php

$locale = App::getLocale();

?>

@section ('content')

<div class="container" style="height: 100%">

  <!-- Outer Row -->
  <div class="row justify-content-center align-items-center flex-direction-column" style="height: 100vh">

    <div class="col-sm-12 col-md-5">

      <div class="card  border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-sm-12">
              <div class="dropdown float-right show " style=" color: #D4AF37;margin-bottom: 10px; z-index: 99 ">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ asset('img/flags/'.App::getLocale().'.svg') }}" width="30px" />
                </a>

                <div class="dropdown-menu" style="max-width:80px;background: #000;border:1px solid #D4AF37" aria-labelledby="dropdownMenuLink">
                  <a href="{{ url('/locale/en') }}" class="dropdown-item " style="padding-right:0px;padding-left: 0px">
                    <img src="{{ asset('img/flags/en.svg') }}" width="30px" style="display:block;margin:0 auto" />
                  </a>
                  <a href="{{ url('/locale/zh') }}" class="dropdown-item" style="padding-right:0px;padding-left: 0px">
                    <img src="{{ asset('img/flags/cn.svg') }}" width="30px" style="display:block;margin:0 auto" />
                  </a>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="p-5" style="padding-top: 0 !important;">

                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">{{ __('app.login') }}</h1>
                </div>
                <form class="user" method="post" action="{{ admin_url('login') }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-user" placeholder="{{ __('app.username') }}">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" placeholder="{{ __('app.password') }}">
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('app.login') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

@stop