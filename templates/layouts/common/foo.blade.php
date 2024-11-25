@extends('layouts/common/no-columns')
@section('page-content-all')

<div class="content-container">

        <div class="content @yield('container-css-class')">
            @yield('page-content')
        </div>

        <div class="menu-right">
            <x-right-menu />
        </div>
    </div>
@endsection


