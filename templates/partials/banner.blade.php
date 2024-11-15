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

    <span class="side-left">
        <a href="{{ home_url() }}/tav_documentation">Documentation</a>
        <a href="{{ home_url() }}/timeline">Timeline</a>
        <a href="{{ home_url() }}/mindmap">Mind map</a>
    </span>

    <span class="side-right">
        @if(!is_user_logged_in())
            <a href="{{ home_url() }}/sign-up">S'inscrire</a>
            <a href="{{ home_url() }}/sign-in">Se connecter</a>
        @else
            <a href="{{ home_url() }}/my-dektop">Mon bureau</a>
        @endif

        <span class="burger-trigger dashicons dashicons-menu"></span>

    </span>

</div>