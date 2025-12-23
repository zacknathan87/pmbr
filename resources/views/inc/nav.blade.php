<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}"><img class="logo" src="{{ asset('images/logo.png') }}" /></a>

    <div class="dropdown show"style="background: rgba(0,0,0,0.7); color: #D4AF37">
      <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{ asset('img/flags//'.App::getLocale().'.svg') }}" width="30px"/>
      </a>

      <div class="dropdown-menu" style="max-width:80px;background: #000;border:1px solid #D4AF37" aria-labelledby="dropdownMenuLink">
        <a href="{{ url('/locale/en') }}" class="dropdown-item " style="padding-right:0px;padding-left: 0px">
          <img src="{{ asset('img/flags//en.svg') }}" width="30px" style="display:block;margin:0 auto" />
        </a>
        <a href="{{ url('/locale/my') }}" class="dropdown-item" style="padding-right:0px;padding-left: 0px">
          <img src="{{ asset('img/flags//my.svg') }}" width="30px" style="display:block;margin:0 auto" />
        </a>
        <a href="{{ url('/locale/cn') }}" class="dropdown-item" style="padding-right:0px;padding-left: 0px">
          <img src="{{ asset('img/flags//cn.svg') }}" width="30px" style="display:block;margin:0 auto" />
        </a>
      </div>
    </div>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('home') }}">{{ __('app.home') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('guessing_game') }}">{{ __('app.guessing_game') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">{{ __('app.online_sport') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('logout') }}">{{ __('app.logout') }}</a>
        </li>
      </ul>
    </div>
  </div>
</nav>