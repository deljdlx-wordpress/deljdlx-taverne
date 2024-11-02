<div>

    {!!wp_forge()->menu->render('location_header', function($item) {
        // dump($item);
        return sprintf('
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="%s">%s</a>
            </li>
            ',
            $item->url,
            $item->title,
        );
    })!!}

</div>


<div class="banner">

    <span>
        <a href="{{ home_url() }}">Accueil</a>

        &nbsp;|&nbsp;<a href="{{ home_url() }}/timeline">Timeline</a>
        &nbsp;|&nbsp;<a href="{{ home_url() }}/board">Mind map</a>


        @if(is_user_logged_in())
            &nbsp;|&nbsp;<a href="{{ home_url() }}/my-dektop/calendar">Calendrier</a>
        @endif
    </span>
    <span>
        @if(!is_user_logged_in())
            <a href="{{ home_url() }}/sign-up">S'inscrire</a>&nbsp;|&nbsp;
            <a href="{{ home_url() }}/sign-in">Se connecter</a>
        @else
            <a href="{{ home_url() }}/my-dektop">Mon bureau</a>
            &nbsp;|&nbsp;<a href="{{ home_url() }}/sign-out">Se déconnecter</a>
        @endif
    </span>
</div>