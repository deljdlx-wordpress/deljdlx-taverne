{{wp_forge()->sidebar->render('menu-right-top')}}

<div class="menu-right__item">
    <h2>Scénarios</h2>
    <ul>
        @php
        foreach ($scenarios as $scenario) {
            echo '<li><a href="'.$scenario->getPermalink().'">'.$scenario->post_title.'</a></li>';
        }
        @endphp
    </ul>
</div>




<div class="menu-right__item">
    <h2>Personnages</h2>
    <ul>
        @foreach($playerCharacters as $character)
            <li>
                @php
                    if(current_user_can('edit_post', $character->ID)) {
                        echo '<a title="Editer" href="'.home_url().'/my-desktop/character-edit?id='.$character->ID.'"><i class="fas fa-edit"></i></a>';
                    }
                @endphp
                <a href="{{$character->getPermaLink()}}">{{$character->getField('name')}}</a>
            </li>
        @endforeach
    </ul>
</div>


<div class="menu-right__item">
    <h2>Pnj</h2>
    <ul>
        @foreach($npcCharacters as $character)
            <li>
                @php
                    if(current_user_can('edit_post', $character->ID)) {
                        echo '<a title="Editer" href="'.home_url().'/my-desktop/character-edit?id='.$character->ID.'"><i class="fas fa-edit"></i></a>';
                    }
                @endphp
                <a href="{{$character->getPermaLink()}}">{{$character->getField('name')}}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="menu-right__item">
    <h2>Organisations</h2>
    <ul>

        @foreach($organizations as $organization)
            <li>
                @php
                    if(current_user_can('edit_post', $organization->ID)) {
                        echo '<a title="Editer" href="'.home_url().'/my-desktop/organization-edit?id='.$organization->ID.'"><i class="fas fa-edit"></i></a>';
                    }
                @endphp
                <a href="{{$organization->getPermaLink()}}">{{$organization->post_title}}</a>
            </li>
        @endforeach
    </ul>
</div>


<div class="menu-right__item">
    <h2>Lieux</h2>
    <ul>

        @foreach($places as $place)
            <li>
                @php
                    if(current_user_can('edit_post', $place->ID)) {
                        echo '<a title="Editer" href="'.home_url().'/my-desktop/place-edit?id='.$place->ID.'"><i class="fas fa-edit"></i></a>';
                    }
                @endphp
                <a href="{{$place->getPermaLink()}}">{{$place->post_title}}</a>
            </li>
        @endforeach
    </ul>
</div>


{{wp_forge()->sidebar->render('menu-right-bottom');}}