@extends('layouts/common/empty')
@section('page-title')
    Mon bureau
@endsection

@section('body-content')


@if(!$skilltreeId)
    <h1>Sélectionner un arbre de compétence</h1>
    <select class="select select-bordered w-full max-w-xs" id="skilltreeSelector">
        <option disabled selected>Sélectionner un arbre</option>

        @foreach($skilltrees as $skilltree)
            <option value="{{$skilltree->ID}}">{{$skilltree->post_title}}</option>
        @endforeach
    </select>

    <script>
        const skilltreeSelector = document.getElementById('skilltreeSelector');
        skilltreeSelector.addEventListener('change', (e) => {
            window.location.href = document.location + '&skilltree=' + e.target.value;
        });
    </script>



@else

    <div x-data="application" class="skill-tree-editor">



        <input id="character-id" value="{{ $character->ID }}" type="hidden">
        <input id="skilltree-id" value="{{ $skilltree->ID }}" type="hidden">


        @include('partials.skilltree.viewer')

        <div style="display: none">
            <input id="skillTreeId" value="{{$skilltree->ID}}">
            <input id="skillTreePermalink" value="{{$skilltree->getPermalink()}}">
            <div id="skill-tree"></div>
        </div>
    </div>
@endif


@endsection
