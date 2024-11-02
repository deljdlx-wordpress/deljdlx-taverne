@php
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
$place = new Place();
$relatedCharacters = [];
$relatedScenarioIds = [];

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
    $place->loadById($postId);

    $relatedCharacters = $place->getCharacters();
    $relatedScenarioIds = array_map(function($scenario) {
        return $scenario->getId();
    }, $place->getScenarios());

    $relatedScenarios = $place->getScenarios();
}





acf_form_head();
@endphp


@extends('layouts/common/no-columns')

@section('page-title')
    Edit {{the_title()}}
@endsection

@section('page-content-all')
    <form method="post" action="{{$action}}" class="place-form" enctype='multipart/form-data'>
        <div class="content-container">
            <div class="content">

                <input type="hidden" name="post_id" value="{{$place->getId()}}" />

                <fieldset>
                    <h2>Nom du lieu</h2>
                    <input type="text" name="name" class="input input-bordered input-primary w-full" value="{{$place->getTitle()}}" />
                </fieldset>

                <fieldset>
                    <h2>Description</h2>
                    @php
                    $fieldName = 'description';
                    $initial_content = $place->getContent();
                    $editor_id = $fieldName;

                    // Options pour l'éditeur
                    $editor_settings = array(
                        'textarea_name' => $editor_id, // Nom de la zone de texte
                        'media_buttons' => true, // Affiche les boutons pour ajouter des médias
                        'textarea_rows' => 50, // Nombre de lignes visibles
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
                        if ($place->getField('illustration')) {
                            echo '<img style="height: 200px" class="illustration" src="' . $place->getField('illustration')['url'] . '" />';
                        }
                    @endphp
                </fieldset>

                <fieldset>
                    <h2>Personnages associés</h2>

                    @include('partials.form.relationship', [
                        'type' => 'character',
                        'name' => 'characters[]',
                        'values' => array_map(function($character) {
                            return $character->getId();
                        }, $relatedCharacters)
                    ])
                </fieldset>

                <fieldset>
                    <h2>Adresse</h2>

                    @php
                    acf_form(array(
                        'post_id' => $place->getId() ?? 'new_post',
                        'post_title' => false,
                        'post_content' => false,
                        'fields' => array('address'),
                        // 'submit_value' => 'Créer un événement',
                        // no form tag
                        'form' => false,
                    ));
                    @endphp
                </fieldset>

                <fieldset>
                    <h2>Scénarios associés</h2>
                    @include('partials.form.relationship', [
                        'type' => 'jdlx_tav_scenario',
                        'name' => 'scenarios[]',
                        'values' => $relatedScenarioIds
                    ])
                </fieldset>


                <fieldset>
                    <h2>Galerie</h2>
                    @php
                        acf_form(array(
                            'post_id' => $place->getId() ?? 'new_post',
                            'post_title' => false,
                            'post_content' => false,
                            'fields' => array('gallery'),
                            'form' => false,
                        ));
                    @endphp



                </fieldset>






            </div>

            <div class="menu-right">
                <div style="display: flex; gap: 0.5rem; flex-direction: column">
                    <button class="btn btn-sm" href="?">Enregistrer</button>
                    @if($place->getId())
                        @if($place->getStatus() != 'publish')
                            <a class="btn btn-sm" href="?publish=1&id={{$place->getId()}}">Publier</a>
                        @else
                            <a class="btn btn-sm" href="?draft=1&id={{$place->getId()}}">Brouillon</a>
                       @endif
                    @endif
               </div>


               <x-right-menu />


            </div>
        </div>
    </form>
@endsection
