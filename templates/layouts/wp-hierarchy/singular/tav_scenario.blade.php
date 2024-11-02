@php

$places = [];
$relatedPlaces = $post->getPlaces();
$lat = 0;
$lng = 0;


if(is_array($relatedPlaces) && count($relatedPlaces) > 0) {
    foreach($relatedPlaces as $place) {
        $places[] = $place;


        $lat += $place->getField('address')['lat'];
        $lng += $place->getField('address')['lng'];
    }
    $lat = $lat / count($relatedPlaces);
    $lng = $lng / count($relatedPlaces);
}

@endphp

@extends('layouts/wp-hierarchy/singular')


@section('before-address')
<section class="section">
    <h2>Carte des lieux</h2>

    <div class="map" id="map" style="width: 100%; height:500px; position: relative; border: solid 1px #000 "></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let lat = {{ $lat }};
            let lon = {{ $lng }};
            var map = L.map('map').setView([lat, lon], 13);
            let tileLayer = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
            L.tileLayer(tileLayer, {
                maxZoom: 20,
            }).addTo(map);


            @foreach($places as $place)

                @php
                    $image = '';
                    if($place->getField('illustration')) {
                        $image = '<img src="' . $place->getField('illustration')['url'] . '" style="width: 200px; height: auto;"/>';
                    }
                @endphp


                var marker = L.marker([{{$place->getField('address')['lat']}}, {{$place->getField('address')['lng']}}]).addTo(map);
                marker.bindPopup(`
                    <div class="map-popup">
                        {!!$image!!}
                        <div style="max-width: 200px">{{$place->getTitle()}}</div>
                    </div>
                `);
                // .openPopup();
            @endforeach

        });
    </script>
</section>

@endsection


@section('content-end')
    <a class="btn btn-neutral" href="{{home_url()}}/timeline?scenario={{$post->getId()}}" class="button">Voir la timeline</a>
@endsection


