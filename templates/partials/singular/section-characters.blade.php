<section class="section">
    <h2>Personnages associés</h2>
    <ul class="list">
    @foreach($characters as $character)

        <li class="card card-place">
            <a href="{{$character->getPermalink()}}">

                @if($character->getField('illustration'))
                    <div class="illustration" style="background-image: url({{$character->getField('illustration')['url']}})" class="illustration"></div>
                @else
                    <div class="illustration" style="background-image: url({{get_theme_file_uri('assets/images/portrait-default.jpg')}})" class="illustration"></div>
                @endif

                <div class="name">{{ $character->getField('name')}}</sdiv>
            </a>
        </li>
    @endforeach
    </ul>
</section>