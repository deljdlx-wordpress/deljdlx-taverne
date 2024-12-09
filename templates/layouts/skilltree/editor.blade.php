@extends('layouts/common/empty')
@section('page-title')
    Mon bureau
@endsection

@section('body-content')






{{-- 2 column div with tailwind --}}
<div x-data="application" class="skill-tree-editor">


    <div>

        <h1 class="flex items-baseline">
            <a href="{{ get_home_url() }}/my-dektop"><i class="fas fa-home"></i></a>

            <span>Arbre de compétences</span>
            <a href="{{ $skillTree->getPermalink() }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </h1>

        <div class="flex items-stretch gap-1">
            <input id="skill-tree-name" name="skill-tree-name" type="text" class="input input-bordered input-sm" placeholder=""  value="{{$skillTree->post_title}}"/>
            <button id="save-trigger" class="btn btn-primary btn-sm">Enregistrer</button>
        </div>


        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-3 p-2" style="border: solid 2px #f0f; min-height: 300px">
                <div id="skill-tree"></div>

                <div>
                    <input id="skillTreeId" value="{{$skillTree->ID}}" type="hidden">
                    <input id="skillTreePermalink" value="{{$skillTree->getPermalink()}}" type="hidden">
                </div>
            </div>



            <div class="col-span-3 p-2" style="border: solid 2px #f0f; min-height: 300px">
                <template x-if="selectedNode">
                    <template x-if="selectedNode.id !== 'root'">
                        <form id="skill-editor">
                            <h2>Informations</h2>
                            {{-- <textarea style="width: 100%; height: 400px;" x-model="JSON.stringify(selectedNode, null , 4)"></textarea> --}}
                                <fieldset>
                                    <label class="input input-bordered flex items-center gap-2">
                                        Nom :
                                        <input x-on:input="updateSelectedNode" x-model="selectedNode.text" name="name" type="text" class="grow" placeholder="" />
                                    </label>
                                </fieldset>

                                <fieldset>
                                    <label>
                                        Illustration :
                                    </label>
                                    <input id="imageUploader" x-on:input="updateSelectedNode" name="image" type="file" class="grow" placeholder="" />
                                    <div id="imagePreview" style="display: none"></div>
                                </fieldset>


                                <template x-if="selectedNode.data.illustration">
                                    <fieldset>
                                        <img :src="selectedNode.data.illustration"/>
                                    </fieldset>
                                </template>


                                <fieldset>
                                    <label>
                                        Description :
                                    </label>
                                    <div>
                                        <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.description" name="description" class="quill textarea textarea-bordered w-full grow"></textarea>
                                    <div>
                                </fieldset>

                                <fieldset>
                                    <label class="input input-bordered flex items-center gap-2">
                                        Code :
                                        <input x-on:input="updateSelectedNode" x-model="selectedNode.data.code" name="code" type="text" class="grow" placeholder="" />
                                    </label>
                                </fieldset>

                                {{-- <template x-if="selectedNode.type === 'attribute'">

                                </template> --}}

                                {{-- <template x-if="selectedNode.type === 'cluster' || selectedNode.type === 'skill' || selectedNode.type === 'perk'"> --}}

                                <fieldset>
                                    <label>
                                        Valeur :
                                    </label>
                                    <div>
                                        {{-- <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.value" name="value" class="textarea textarea-bordered w-full grow"></textarea> --}}
                                        <div class="code" data-field-name="value" data-lines="1"></div>
                                    <div>
                                </fieldset>

                                <fieldset>
                                    <label>
                                        Modificateurs :
                                    </label>
                                    <div>
                                        {{-- <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.modifiers" name="modifiers" class="textarea textarea-bordered w-full grow"></textarea> --}}
                                        <div class="code" data-field-name="modifiers" data-lines="10"></div>
                                    <div>
                                </fieldset>
                        </form>
                    </template>
                </template>
            </div>

            <div class="col-span-6 p-2" style="border: solid 2px #f0f; min-height: 300px">
                @include('partials.skilltree.viewer')
            </div>
        </div>
    </div>

</div>



<script>

// const skillForm = document.querySelector('#skill-editor');
// const skillNameInput = skillForm.querySelector('input[name="skill-name"]');
// const skillCodeInput = skillForm.querySelector('input[name="skill-code"]');


</script>







@endsection
