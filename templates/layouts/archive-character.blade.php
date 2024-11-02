@php

// load all posts of type 'character'

if(!isset($authorId)) {
    $authorId = null;
}

$posts = get_posts([
    'post_type' => 'character',
    'numberposts' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
    'author' => $authorId

]);

$characters = [];

foreach ($posts as $post) {
    $characters[] = [
        'post' => $post,
        'fields' => get_fields($post->ID)
    ];
}

@endphp


@extends('layouts/common/default')
@section('page-title')
    Personnages
@endsection

@section('page-content')
    <h1>Personnages</h1>
    <div class="characters-list">
        @foreach($characters as $character)
            <div class="card-character">
                <a href="{{get_permalink($character['post']->ID)}}">
                    @if($character['fields']['illustration'])
                        <div class="illustration" style="background-image: url({{$character['fields']['illustration']['url']}})"></div>
                    @endif
                    <span class="content">
                        {{$character['post']->post_title}}
                    </span>
                </a>
            </div>
        @endforeach
    </div>
@endsection
