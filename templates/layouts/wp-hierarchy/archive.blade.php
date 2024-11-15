@extends('layouts/common/with-right-column')


@section('page-title')
    {{-- {{$post->getTitle()}} --}}
@endsection

@section('container-css-class')
    archive archive-{{$post_type}}
@endsection

@section('page-content')

<section class="section article">
    <h1 class="section-title-1">Documentation</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

        @foreach($posts as $post)
                <div class="card">
                    @php
                        $illustration = $post->getField('illustration');
                        if($illustration && isset($illustration['url'])){
                            echo '<img class="block" src="'.$illustration['url'].'" alt="'.$illustration['alt'].'" style="width: 100%"/>';
                        }
                    @endphp
                    <div class="card-title">
                        <a href="{{$post->getPermalink()}}">
                            {{$post->getTitle()}}
                        </a>
                    </div>
                </div>
        @endforeach
    </div>
</section>


@endsection
