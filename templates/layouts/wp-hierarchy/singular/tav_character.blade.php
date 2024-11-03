@php
    $authorId = get_the_author_meta('ID');
    $currentUserId = get_current_user_id();
    $isAdmin = current_user_can('administrator');

@endphp

@extends('layouts/common/default')
@section('page-title')
    Fiche de personnage : {{ $character->getField('name') }}
@endsection

@section('page-content')


    <h1>
        {{ $character->getField('name') }}
    </h1>

    <div class="character-toolbar">
        <div class="character-toolbar-info">
            <span>{{ $character->getField('job') }}</span>
        </div>

        <div>
            @php

                if (!empty($_GET)) {
                    $url = $character->getPermalink() . '&sheet=1';
                } else {
                    $url = $character->getPermalink() . '?sheet=1';
                }
            @endphp
            <a href="{{ $url }}">Fiche de personnage</a>
            @if ($currentUserId == $authorId || $isAdmin)
                | <a href="/my-desktop/character-edit?&id={{ $character->ID }}">Editer</a>
            @endif
        </div>
    </div>

    <div class="column-text character-section">

        <div style="break-inside: avoid;">
            <div style="position: relative">
                @if ($character->getField('illustration'))
                    <img style="" class="main-illustration" src="{{ $character->getField('illustration')['url'] }}" data-modal />
                @endif

                @if ($character->getField('birth') || $character->getField('astral_sign'))
                    <div class="" style="
                        position: absolute;
                        bottom:0;
                        width:100%;
                        font-size: 0.7rem;
                        border: solid 1px #000;
                        padding: 0.5rem;
                        background-color: #fffd
                    ">
                        @if ($character->getField('birth'))
                            <div>Naissance : {{ $character->getField('birth') }}</div>
                        @endif
                        @if ($character->getField('astral_sign'))
                            <div>{{ $character->getField('astral_sign') }}</div>
                        @endif
                    </div>
                @endif
            </div>


            @if($character->hasSheet())
                <div class="mt-4">
                    {{-- <h2>Caractéristiques</h2> --}}
                    <div id="character-attributes-graph" style="height:300px; border: solid 1px #000; padding: 0 1rem"></div>
                    <script>
                        const characterSheet = {!! $character->getSheetJson() !!}
                        const characterAttributes = characterSheet.attributes;
                    </script>
                </div>
            @endif
        </div>


        @if ($character->getField('description'))
            <h2>Description</h2>
            {!! $character->getField('description') !!}
        @endif
    </div>

    @if (is_array($character->getField('address')) && count($character->getField('address')['markers']))
        <div>
            <h2>Adresse</h2>

            <div class="map" id="map"
                style="width: 100%; height:500px; position: relative; border: solid 1px #000 "></div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    let lat = {{ $character->getField('address')['lat'] }};
                    let lon = {{ $character->getField('address')['lng'] }};
                    var map = L.map('map').setView([lat, lon], 18);
                    let tileLayer = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
                    L.tileLayer(tileLayer, {
                        maxZoom: 20,
                    }).addTo(map);

                    var marker = L.marker([lat, lon]).addTo(map);
                    marker.bindPopup('<span>{{ $character->getField('address')['markers'][0]['label'] }}</span>')
                        .openPopup();
                });
            </script>
        </div>
    @endif




    @if ($character->getField('background'))
        <div class="column-text character-section">
            <h2>Background</h2>
            {!! $character->getField('background') !!}
        </div>
    @endif


    @if ($character->getField('communication'))
        <div class="column-text character-section">
            <h2>Façon de parler en société</h2>
            {!! $character->getField('communication') !!}
        </div>
    @endif

    @if ($character->getField('typical-sentences'))
        <div class="character-section character-section">
            <h2>Phrases typiques</h2>
            {!! $character->getField('typical-sentences') !!}
        </div>
    @endif


    @if ($character->getField('typical-items'))
        <div class="character-section">
            <h2>Objets spécifiques</h2>
            {!! $character->getField('typical-items') !!}
        </div>
    @endif



    @if ($character->getField('home'))
        <div class="character-section character-section--home">
            <h2>Lieu de vie</h2>
            {!! $character->getField('home') !!}
        </div>
    @endif


    @if ($character->getField('work'))
        <div class="column-text character-section">
            <h2>Lieu de travail</h2>
            {!! $character->getField('work') !!}
        </div>
    @endif

    @if (!empty($character->getCharacters()))
        <div class="character-section">
            @include('partials.singular.section-characters', [
                'characters' => $character->getCharacters(),
            ])
        </div>
    @endif

    @if (!empty($character->getPlaces()))
        <div class="character-section">
            @include('partials.singular.section-places', [
                'places' => $character->getPlaces(),
            ])
        </div>
    @endif



@endsection
