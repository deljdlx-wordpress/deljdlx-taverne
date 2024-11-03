@extends('layouts/common/default')
@section('page-title')
    {{the_title()}}
@endsection

@section('page-content')


    <h1>{{$fields['title']}}</h1>
    
    <div class="banner">
        <span>{{$fields['publication_subtitle']}}</span>
    </div>


    <div class="column-text" style="margin-top: 1rem">

        @if($fields['illustration'])
            <img src="{{$fields['illustration']['url']}}" />
        @endif


        {!!the_content()!!}

    </div>


@endsection
