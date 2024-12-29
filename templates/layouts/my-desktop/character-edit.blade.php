@php
use Deljdlx\WPTaverne\Models\Character;

if(isset($_POST['name'])) {
    $post = Character::saveFromForm();
    // redirect to edit page
    wp_redirect('/my-desktop/character-edit?id='.$post->ID);
    die();
}



@endphp


@extends('layouts/common/no-columns')

@section('page-title')
    Edit {{the_title()}}
@endsection


@section('page-content-all')





    {{-- <button class="btn" onclick="my_modal_1.showModal()">open modal</button> --}}
    <dialog id="magic-modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="text-lg font-bold">Magie !</h3>
            <div class="magic-content"></div>
            <div class="modal-action">
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button data-variable="" class="btn btn-success magic-accept">Accepter</button>
                <button data-variable="" class="btn btn-error magic-refuse">Refuser</button>
            </form>
            </div>
        </div>
    </dialog>





    <form id="ai-form" style="display: none">
        <div id="ai-response" style="height: 300px; border: solid 1px; padding: 1rem"></div>
        <input id="prompt" class="input input-bordered input-primary w-full" />
    </form>

    <script>

        /*

        document.querySelector('#character-generate-trigger').addEventListener('click', (e) => {
        // document.querySelector('#ai-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const prompt = document.querySelector('#prompt').value;

            fetch('/wp-json/taverne/v1/character/generate-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    key: document.querySelector('input[name="ai_chat_id"]').value,
                    job: document.querySelector('input[name="job"]').value,
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.querySelector('#ai-response').innerHTML = data.response;
                const characterData = data.characterData;

                document.querySelector('input[name="name"]').value = characterData.name;
                document.querySelector('input[name="mbti"]').value = characterData.mbti;

                document.querySelector('input[name="birth"]').value = characterData.birth;

                document.querySelector('input[name="job"]').value = characterData.job;
                document.querySelector('.acf-field-address input[type=text]').value = characterData.address;

                document.querySelector('input[name="astral_sign"]').value = characterData.astral_sign;


                // set wp editor content
                tinymce.get('description').setContent(characterData.description);
                tinymce.get('background').setContent(characterData.background);
                tinymce.get('communication').setContent(characterData.communication);

                tinymce.get('home').setContent(characterData.home);
                tinymce.get('work').setContent(characterData.work);


                let typicalSentences = characterData['typical-sentences'];
                let typicalSentencesContent = '';
                for (let i = 0; i < typicalSentences.length; i++) {
                    typicalSentencesContent += '<p>' +  typicalSentences[i] + '</p>';
                }
                tinymce.get('typical-sentences').setContent(typicalSentencesContent);

                let typicalItems = characterData['typical-items'];
                let typicalItemsContent = '';
                for (let i = 0; i < typicalItems.length; i++) {
                    typicalItemsContent += '<p>' +  typicalItems[i] + '</p>';
                }
                tinymce.get('typical-items').setContent(typicalItemsContent);
            });
        });

        */

    </script>


    <form id="character-edit-form" method="post" action="{{$action}}" class="character-form" enctype='multipart/form-data'>
        <div class="content-container">
            <div class="content">
                @if($character->ID)
                    <h1>Modifier {{$character->getField('name')}}</h1>
                @else
                    <h1>Création d'un nouveau personnage <button class="btn btn-primary" id="character-generate-trigger">Magie tout générer</button></h1>
                @endif

                <input type="hidden" name="post_id" value="{{$character->ID}}" />
                <input type="hidden" name="ai_chat_id" value="{{$chatId}}" />

                <div role="tablist" class="tabs tabs-bordered" style="margin-bottom: 1rem">
                    @include('partials.character-form.tab-00', ['character' => $character])
                    @include('partials.character-form.tab-01', ['character' => $character])
                    @include('partials.character-form.tab-02', ['character' => $character])
                    @include('partials.character-form.tab-04', ['character' => $character])
                    @include('partials.character-form.tab-03', ['character' => $character])
                </div>
            </div>

            <div class="menu-right">
                <div style="display: flex; gap: 0.5rem; flex-direction: column">
                    <button class="btn btn-sm" href="?">Enregistrer</button>


                    @if($character->ID)
                        <a class="btn btn-sm" href="{{
                            $character->getPermalink()
                        }}" target="_blank"
                        >Voir la fiche</a>
                    @endif

                    @if($character->ID && $character->status != 'publish')
                        <a class="btn btn-sm" href="?publish=1&id={{$character->ID}}">Publier</a>
                    @endif
                    @if($character->ID && $character->status == 'publish')
                        <a class="btn btn-sm" href="?draft=1&id={{$character->ID}}">Brouillon</a>
                    @endif
                </div>

                <x-right-menu />


            </div>
        </div>
    </form>
@endsection
