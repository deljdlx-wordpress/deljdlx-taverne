<section class="section">
    <h2>Personnages associés</h2>
    <div class="list characters-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    @foreach($characters as $character)

        <div class="card card-character">
            <a href="{{$character->getPermalink()}}">

                @if($character->getField('illustration'))
                    <div class="illustration" style="background-image: url({{$character->getField('illustration')['url']}})" class="illustration"></div>
                @else
                    <div class="illustration" style="background-image: url({{get_theme_file_uri('assets/images/portrait-default.jpg')}})" class="illustration"></div>
                @endif

                <div class="name">{{ $character->getField('name')}}</sdiv>
            </a>
        </div>
    @endforeach
    </div>
</section>