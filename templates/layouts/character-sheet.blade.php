@extends('layouts/common/empty')
@section('page-title')
    Mon bureau
@endsection

@section('body-content')


{{-- 2 column div with tailwind --}}
<div x-data="application" class="skill-tree-editor">

    @include('partials.skilltree.viewer')

    <div style="display: none">
        <input id="skillTreeId" value="{{$skillTree->ID}}" type="hidden">
        <input id="skillTreePermalink" value="{{$skillTree->getPermalink()}}" type="hidden">
        <div id="skill-tree"></div>
    </div>
</div>


@endsection
