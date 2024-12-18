@extends('layouts/common/with-right-column')

@section('page-title')
    Accueil
@endsection

@section('page-content')

{{wp_forge()->sidebar->render('home-top')}}

<h1 class="section-title-1">Les dernières informations</h1>
<div class="articles-list">
    @foreach($articles as $article)
        <div class="card-article {{$article->getField('is_published') ? 'published' : 'unpublished'}}">
            @if($article->getField('title'))
                <h1 class="article-title">
                    {{$article->getField('title')}}
                </h1>
            @endif

            @if($article->getField('publication_subtitle'))
                <div class="banner" style="column-span: all; margin-bottom: 1rem;">
                    {!!$article->getField('publication_subtitle')!!}

                    {{-- if can edit, link to admin edition page) --}}
                    @if(current_user_can('administrator'))
                        <a href="{{home_url('/wp-admin/post.php?post='.$article->getId().'&action=edit')}}"><i class="fas fa-pencil-alt"></i></a>
                    @endif



                </div>
            @endif

            @if($article->getField('illustration'))
                <div class="illustration" style="float: left; background-image: url({{$article->getField('illustration')['url']}})"></div>
            @endif

            @if($article->getField('illustration'))
                <div>
            @else
                <div style="column-count: 3;">
            @endif

                <div>
                    {!!$article->getContent()!!}
                </div>
            </div>

        </div>
    @endforeach
</div>

@endsection
