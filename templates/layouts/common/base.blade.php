@extends('layouts/common/empty')

@section('body-content')
  <div class="container">

    <div id="header-image" @php
      if(get_theme_mod('header-image')) {
        echo 'style="
          background-image: url('.get_theme_mod('header-image').');
          display: block;
        "';
      }
      @endphp></div>

    @include('partials.site-header')

    @yield('page-content-all')

  </div>
@endsection

