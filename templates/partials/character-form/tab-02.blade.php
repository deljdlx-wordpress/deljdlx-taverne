@php
use Deljdlx\WPTaverne\Models\Place;

$relatedPlaceIds = [];

foreach($character->getPlaces() as $place) {
    $relatedPlaceIds[] = $place->ID;
}


@endphp

<input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Lieux" />
<div role="tabpanel" class="tab-content p-10">

    <fieldset>
        <h2>Lieux associés</h2>
        @include('partials.form.relationship', [
            'type' => 'jdlx_tav_place',
            'name' => 'places[]',
            'values' => $relatedPlaceIds,
        ])
    </fieldset>



    <fieldset>
        <h2>Lieu de vie</h2>
        <p>Pour créer des sous parties, utilisez les titres de niveau 3 (h3).</p>
        @include('partials.character-form.magic-form', [
            'variable' => 'home'
        ])
        @php
        $fieldName = 'home';
        $initial_content = $character->getField($fieldName);
        $editor_id = $fieldName;
        $editor_settings = array(
            'textarea_name' => $editor_id, // Nom de la zone de texte
            'media_buttons' => true, // Affiche les boutons pour ajouter des médias
            'textarea_rows' => 30, // Nombre de lignes visibles
            'teeny' => false, // Utilise la version simplifiée de l'éditeur
            'quicktags' => true // Affiche les boutons de mise en forme rapide (mode texte)
        );
        wp_editor($initial_content, $editor_id, $editor_settings);
        @endphp
    </fieldset>
    <fieldset>
        <h2>Lieu de travail</h2>
        <p>Pour créer des sous parties, utilisez les titres de niveau 3 (h3).</p>
        @include('partials.character-form.magic-form', [
            'variable' => 'work'
        ])
        @php
        $fieldName = 'work';
        $initial_content = $character->getField($fieldName);
        $editor_id = $fieldName;
        $editor_settings = array(
            'textarea_name' => $editor_id, // Nom de la zone de texte
            'media_buttons' => true, // Affiche les boutons pour ajouter des médias
            'textarea_rows' => 30, // Nombre de lignes visibles
            'teeny' => false, // Utilise la version simplifiée de l'éditeur
            'quicktags' => true // Affiche les boutons de mise en forme rapide (mode texte)
        );
        wp_editor($initial_content, $editor_id, $editor_settings);
        @endphp
    </fieldset>
</div>