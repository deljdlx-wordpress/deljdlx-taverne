{{-- @dump($fields) --}}

<input checked="checked" type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Informations générales" />
<div role="tabpanel" class="tab-content">

    <fieldset>
        <h2>Nom</h2>

        @include('partials.character-form.magic-form', [
            'variable' => 'name'
        ])

        <input name="name" type="text" class="input input-bordered input-primary w-full" placeholder=""
            value="{{$character->getField('name')}}"
        />
    </fieldset>


    <fieldset>
        <h2>Profil MBTI</h2>
        <input name="mbti" type="text" class="input input-bordered input-primary w-full" placeholder=""
            value="{{$character->getField('mbti')}}"
        />
    </fieldset>



    <fieldset>

        <div class="form-control" style="width: 300px">
            <label class="label cursor-pointer">
                <h2>Personnage non joueur
                    <input type="checkbox" class="checkbox"
                        name="is_npc" value="1" {{$character->getField('is_npc') ? 'checked' : '' }}
                    />
                </h2>
            </label>
          </div>


        {{-- <h2>Personnage non joueur</h2>
        <label>
            <input type="checkbox" name="is_npc" value="1" @if(isset($fields['is_npc']) && $fields['is_npc'] == 1) checked="checked" @endif />
            Ce personnage est un PNJ
        </label> --}}
    </fieldset>

    <fieldset>
        <h2>Illustration</h2>
            <input name="illustration" type="file" class="file-input file-input-bordered w-full max-w-xs" />
            {{-- <input type="file" name="illustration" /> --}}
        @php
            if ($character->getField('illustration') && isset($character->getField('illustration')['url'])) {
                echo '<img class="illustration" src="' . $character->getField('illustration')['url'] . '" />';
            }
        @endphp
    </fieldset>

    <fieldset>
        <h2>Naissance</h2>
        @include('partials.character-form.magic-form', [
            'variable' => 'birth'
        ])
        <input name="birth" type="text" class="input input-bordered input-primary w-full" placeholder=""
            value="{{$character->getField('birth')}}"
        />
    </fieldset>

    <fieldset>
        <h2>Profession</h2>
        <input class="input input-bordered input-primary w-full" type="text" name="job" value="{{$character->getField('job')}}" />
    </fieldset>

    <fieldset>
        <h2>Adresse</h2>
        @include('partials.character-form.magic-form', [
            'variable' => 'address'
        ])
        @php

        acf_form_head();
        acf_form(array(
            'post_id' => $character->ID ?? 'new_post',
            'post_title' => false,
            'post_content' => false,
            'fields' => array('address'),
            // 'submit_value' => 'Créer un événement',
            // no form tag
            'form' => false,
        ));
        @endphp


        {{-- <textarea name="address">{{$fields['address'] ?? ''}}</textarea> --}}
    </fieldset>


    <fieldset>
        <h2>Description</h2>
        {{-- <div class="magic-form" style="display: flex">
            <label class="input input-bordered flex items-center gap-2" style="flex-grow:1">
                <input type="text" class="grow magic-prompt" placeholder="Magie !" id="description-prompt" data-variable="description"/>
            </label>
            <button class="btn btn-primary magic-trigger" data-variable="description">Magie !</button>
        </div> --}}

        @include('partials.character-form.magic-form', [
            'variable' => 'description'
        ])

        @php
            // Définit le contenu initial de l'éditeur
            $fieldName = 'description';
            $initial_content = $character->getField($fieldName);

            // Nom de l'éditeur (utilisé dans le formulaire pour récupérer la valeur)
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
</div>