@php
    use Deljdlx\WPTaverne\Models\Place;
    use Deljdlx\WPTaverne\Models\Character;
@endphp

@extends('layouts/common/empty')

@section('body-content')

    <style>
        .forge-layout-container {
            outline: solid 1px #f0f;
            /* display: flex;
            flex-grow:1;
            flex-shrink:1;
            flex-wrap: wrap; */

            float: left;
        }
    </style>

    <div style="height:100vh; width:100%; position: relative; display: flex">
        {!!$html!!}
    </div>
@endsection
