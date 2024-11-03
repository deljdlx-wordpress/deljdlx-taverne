@php
use Deljdlx\WPTaverne\Models\Scenario;
use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPTaverne\Models\Character;


// ===========================================================
if(isset($_POST['name'])) {
    $place = Place::saveFromForm();
    // redirect to edit page
    wp_redirect('/my-desktop/place-edit?id='.$place->getId());
    die();
}


if(isset($_GET['publish'])) {
    wp_update_post([
        'ID' => $_GET['id'],
        'post_status' => 'publish'
    ]);
}
if(isset($_GET['draft'])) {
    wp_update_post([
        'ID' => $_GET['id'],
        'post_status' => 'draft'
    ]);
}

// ===========================================================

$postId = null;
$scenario = new Scenario();
$relatedCharacterIds = [];
$relatedPlaceIds = [];
$relatedResourceIds = [];


$action = '?';

$characters = Character::getByOptions([
    'post_type' => 'character',
    'numberposts' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
    'post_status' => 'any',
]);

if(isset($_GET['id'])) {
    $postId = $_GET['id'];
    $action = '?id='.$postId;
    $scenario->loadById($postId);

    $characterPosts = $scenario->getField('characters');
    if(is_array($characterPosts)) {
        foreach($characterPosts as $post) {
            $relatedCharacterIds[] = $post->ID;
        }
    }

    $placePosts = $scenario->getField('places');
    if(is_array($placePosts)) {
        foreach($placePosts as $post) {
            $relatedPlaceIds[] = $post->ID;
        }
    }

    $resourcePosts = $scenario->getField('resources');
    if(is_array($resourcePosts)) {
        foreach($resourcePosts as $post) {
            $relatedResourceIds[] = $post->ID;
        }
    }
}

@endphp


@extends('layouts/common/no-columns')

@section('page-title')
    Edit {{the_title()}}
@endsection


@php
acf_form_head();
@endphp

@section('page-content-all')
    <form method="post" action="{{$action}}" class="place-form" enctype='multipart/form-data'>
        <div class="content-container">
            <div class="content">

                <input type="hidden" name="post_id" value="{{$scenario->getId()}}" />

                <fieldset>
                    <h2>Titre du scénario</h2>
                    <input type="text" name="name" class="input input-bordered input-primary w-full" value="{{$scenario->getTitle()}}" />
                </fieldset>

                <fieldset>
                    <h2>Description</h2>
                    @php
                    $fieldName = 'description';
                    $initial_content = $scenario->getContent();
                    $editor_id = $fieldName;

                    // Options pour l'éditeur
                    $editor_settings = array(
                        'textarea_name' => $editor_id, // Nom de la zone de texte
                        'media_buttons' => true, // Affiche les boutons pour ajouter des médias
                        'textarea_rows' => 10, // Nombre de lignes visibles
                        'teeny' => false, // Utilise la version simplifiée de l'éditeur
                        'quicktags' => true // Affiche les boutons de mise en forme rapide (mode texte)
                    );

                    // Affiche l'éditeur
                    wp_editor($initial_content, $editor_id, $editor_settings);
                    @endphp

                </fieldset>



                <fieldset>
                    <h2>Illustration</h2>
                    <input type="file" name="illustration" />
                    @php
                        if ($scenario->getField('illustration')) {
                            echo '<img style="height: 200px" class="illustration" src="' . $scenario->getField('illustration')['url'] . '" />';
                        }
                    @endphp
                </fieldset>

                <fieldset>
                    <h2>Personnages associés</h2>

                    @include('partials.form.relationship', [
                        'type' => 'character',
                        'name' => 'characters[]',
                        'values' => $relatedCharacterIds
                    ])
                </fieldset>

                <fieldset>
                    <h2>Lieux associés</h2>

                    @include('partials.form.relationship', [
                        'type' => 'jdlx_tav_place',
                        'name' => 'places[]',
                        'values' => $relatedPlaceIds
                    ])
                </fieldset>

                <fieldset>
                    <h2>Ressources associées</h2>

                    @include('partials.form.relationship', [
                        'type' => 'jdlx_tav_resource',
                        'name' => 'resources[]',
                        'values' => $relatedResourceIds
                    ])
                </fieldset>

            </div>

            <div class="menu-right">
                <div style="display: flex; gap: 0.5rem; flex-direction: column">
                    <button class="btn btn-sm" href="?">Enregistrer</button>
                    @if($scenario->getId())
                        @if($scenario->getStatus() != 'publish')
                            <a class="btn btn-sm" href="?publish=1&id={{$scenario->getId()}}">Publier</a>
                        @else
                            <a class="btn btn-sm" href="?draft=1&id={{$scenario->getId()}}">Brouillon</a>
                        @endif
                        @endif
               </div>
            </div>
        </div>
    </form>
@endsection
