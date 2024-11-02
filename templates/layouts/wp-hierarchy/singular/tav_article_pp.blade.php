@php
$fields = get_fields($post->ID);

$npcs = [];
$pcs = [];

if(isset($fields['characters']) && is_array($fields['characters'])) {
    foreach($fields['characters'] as $character) {
    $characterFields = get_fields($character->ID);
    if(isset($characterFields['is_npc']) && $characterFields['is_npc'] == 1) {
        $npcs[] = $character;
    }
    else {
        $pcs[] = $character;
    }
}
}


$places = get_field('places', $post->ID);

@endphp

@extends('layouts/common/default')


@section('page-title')
    {{$post->post_title}}
@endsection

@section('container-css-class')
    @php
        $cpt = get_post_type($post->ID);
        echo 'singular singular-'.$cpt;
    @endphp
@endsection

@section('page-content')

<section class="section article">

    @if(isset($fields['title']))
        <h1 class="article-title">
            {{$fields['title']}}
        </h1>
    @endif

    <div class="banner" style="column-span: all; margin-bottom: 1rem;">
        {!!$fields['publication_subtitle']!!}
    </div>

    @yield('after-title')


    <div class="column-text">
        @if(isset($fields['illustration']) && $fields['illustration'])
            <img class="main-illustration" src="{{$fields['illustration']['url']}}" data-modal/>
        @endif

        @if($post->post_content)
            @php
                $content = apply_filters('the_content', $post->post_content);
                echo $content;
            @endphp
        @endif
    </div>
</section>


@if(isset($fields['address']) && is_array($fields['address']) && count($fields['address']['markers']))
<section class="section">
    <h2>Adresse</h2>

    <div class="map" id="map" style="width: 100%; height:500px; position: relative; border: solid 1px #000 "></div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
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
    </script>
</section>
@endif


@yield('before-characters')


@if(is_array($places))
<section class="section">
    <h2>Lieux associés</h2>
    <ul>
    @foreach($places as $place)
        <li>
            <a href="{{get_permalink($place->ID)}}">
                {{ $place->post_title}}
            </a>
        </li>
    @endforeach
    </ul>
</section>
@endif

@if(isset($fields['characters']) && is_array($fields['characters']))
<section class="section characters-list ">
    @if(count($npcs) > 0)
        <div>
            <h2>PNJ associés</h2>
            <ul>
            @foreach($npcs as $character)
                <li>
                    <a href="{{get_permalink($character->ID)}}">
                        @include('partials/character-portrait', ['character' => $character])
                        {{ $character->post_title}}
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
                    <a href="{{get_permalink($character->ID)}}">
                        @include('partials/character-portrait', ['character' => $character])
                        {{ $character->post_title}}
                    </a>
                </li>'
            @endforeach
            </ul>
        </div>
    @endif
</section>
@endif



@endsection
