<section class="section">
    <h2>Ressources associées</h2>
    <ul class="list">
    @foreach($resources as $resource)

        <li class="card card-place">
            <a href="{{$resource->getPermalink()}}">

                @if($resource->getField('illustration'))
                    <div class="illustration" style="background-image: url({{$resource->getField('illustration')['url']}})" class="illustration"></div>
                @else
                    <div class="illustration" style="background-image: url({{get_theme_file_uri('assets/images/resource-default.jpg')}})" class="illustration"></div>
                @endif

                <div class="name">{{ $resource->getTitle()}}</sdiv>
            </a>
        </li>
    @endforeach
    </ul>
</section>