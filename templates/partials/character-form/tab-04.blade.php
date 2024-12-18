@php
$relatedCharacterIds = [];

foreach($character->getCharacters() as $related) {
    $relatedCharacterIds[] = $related->ID;
}

@endphp

<input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Trivia" />
<div role="tabpanel" class="tab-content p-10">

    <fieldset>
        <h2>Personnages associés</h2>
        @include('partials.form.relationship', [
            'type' => 'character',
            'name' => 'characters[]',
            'values' => $relatedCharacterIds
        ])
    </fieldset>



    <fieldset>
        <h2>Signe astrologique</h2>

        @include('partials.character-form.magic-form', [
            'variable' => 'astral_sign'
        ])


        <input class="input input-bordered input-primary w-full" type="text" name="astral_sign" value="{{$character->getField('astral_sign')}}" />
    </fieldset>

    <fieldset>
        <h2>Phrases typiques</h2>
        <p>Pour créer des sous parties, utilisez les titres de niveau 3 (h3).</p>
        @include('partials.character-form.magic-form', [
            'variable' => 'typical-sentences'
        ])
        @php
        $fieldName = 'typical-sentences';
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
        <h2>Objects caractéristiques</h2>
        <p>Pour créer des sous parties, utilisez les titres de niveau 3 (h3).</p>
        @include('partials.character-form.magic-form', [
            'variable' => 'typical-items'
        ])
        @php
        $fieldName = 'typical-items';
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