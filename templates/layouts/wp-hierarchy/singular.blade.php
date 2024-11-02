@php
$fields = $post->getFields();

$npcs = [];
$pcs = [];

$relatedCharacters = $post->getCharacters();

foreach($relatedCharacters as $character) {
    if($character->getField('is_npc')) {
        $npcs[] = $character;
    }
    else {
        $pcs[] = $character;
    }
}

$places = $post->getPlaces();

// dump($places);

$resources = $post->getResources();

// $resources = [];

@endphp

@extends('layouts/common/default')


@section('page-title')
    {{$post->getTitle()}}
@endsection

@section('container-css-class')
    singular singular-{{$post->getType()}}
@endsection

@section('page-content')

<section class="section article">
    <h1 class="section-title-1">{{$post->getTitle()}} @yield('after-title')</h1>

    @yield('before-content')
    <div class="--column-text">
        @if(isset($fields['illustration']) && $fields['illustration'])
            <img class="main-illustration" src="{{$fields['illustration']['url']}}" data-modal/>
        @endif

        {!! $post->getContent()!!}

        @yield('content-end')

    </div>
</section>

{{-- ======================================================================================== --}}
@yield('before-address')
@if(isset($fields['address']) && is_array($fields['address']) && count($fields['address']['markers']))
<section class="section">
    <h2>Adresse</h2>

    <div class="map" id="map" style="width: 100%; height:500px; position: relative; border: solid 1px #000 "></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let lat = {{ $fields['address']['lat'] }};
            let lon = {{ $fields['address']['lng'] }};
            var map = L.map('map').setView([lat, lon], 18);
            let tileLayer = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
            L.tileLayer(tileLayer, {
                maxZoom: 20,
            }).addTo(map);
            // Ajouter un marqueur à Paris avec une popup
            var marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup('<span>{{ $fields['address']['markers'][0]['label'] }}</span>').openPopup();
        });
    </script>
</section>
@endif

{{-- ======================================================================================== --}}
@yield('before-resources')
@if(is_array($resources) && count($resources) > 0)
    @include('partials.singular.section-resources', [
        'resources' => $resources,
    ])
@endif

{{-- ======================================================================================== --}}
@yield('before-gallery')
@if(isset($fields['gallery']) && is_array($fields['gallery']))
    <section>
        <h2>Galerie</h2>
        @foreach($fields['gallery'] as $image)
            <img style="width: 200px" src="{{$image['full_image_url']}}" data-modal/>
        @endforeach
    </section>
@endif

{{-- ======================================================================================== --}}
@yield('before-places')
@if(is_array($places) && count($places) > 0)
    @include('partials.singular.section-places', [
        'places' => $places,
    ])
@endif

{{-- ======================================================================================== --}}
@yield('before-characters')
@if(!empty($relatedCharacters))
<section class="section characters-list ">
    @if(count($npcs) > 0)
        <div>
            <h2>PNJ associés</h2>
            <ul>
            @foreach($npcs as $character)
                <li>
                    <a href="{{get_permalink($character->getId())}}">
                        @include('partials/character-portrait', ['character' => $character])
                        {{ $character->getTitle()}}
                    </a>
                </li>'
            @endforeach
            </ul>
        </div>
    @endif

    @if(count($pcs) > 0)
        <div>
            <h2>Personnages associés</h2>
            <ul>
            @foreach($pcs as $character)
                <li>
                    <a href="{{get_permalink($character->getId())}}">
                        @include('partials/character-portrait', ['character' => $character])
                        {{ $character->getTitle()}}
                    </a>
                </li>'
            @endforeach
            </ul>
        </div>
    @endif
</section>
@endif
@endsection
