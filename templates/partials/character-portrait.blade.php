@php
    $illustration = $character->getField('illustration');
    $illustration = $illustration['url'] ?? get_theme_file_uri('assets/images/portrait-default.jpg');
@endphp
<span class="character-portrait" style="background-image: url({{$illustration}})"></span>