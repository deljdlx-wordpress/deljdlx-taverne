<section class="section">
    <h2>Lieux associés</h2>
    <ul class="list">
    @foreach($places as $place)

        <li class="card card-place">
            <a href="{{$place->getPermalink()}}">

                @if($place->getField('illustration'))
                    <div class="illustration" style="background-image: url({{$place->getField('illustration')['url']}})" class="illustration"></div>
                @else
                    <div class="illustration" style="background-image: url({{get_theme_file_uri('assets/images/place-default.webp')}})" class="illustration"></div>
                @endif

                <div class="name">{{ $place->getTitle()}}</sdiv>
            </a>
        </li>
    @endforeach
    </ul>
</section>