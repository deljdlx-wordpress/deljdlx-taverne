@php
$currentUserId = get_current_user_id();
$isAdmin = current_user_can('administrator');


$characterData = json_decode(
    $character->getField('json'),
    true,
);

if(!$characterData) {
    $filename = get_theme_file_path('resources/characters/default.json');
    $characterData = json_decode(file_get_contents($filename), true);
}
$characterName = $characterData['characterName'] ?? 'Character Name';
$characterAge = $characterData['characterAge'] ?? 32;
$characterProfession = $characterData['characterProfession'] ?? 'profession';

$skills = [];
foreach($characterData['cols'] as $col) {
    foreach($col['clusters'] as $cluster) {
        foreach($cluster['skills'] as $name => $skill) {
            $skills[$name] = $skill['value'];
        }
    }
}





@endphp

@extends('layouts/common/with-right-column')
@section('page-title')
    Fiche de personnage : {{$character->getField('name')}}
@endsection

@section('page-content')



<section class="page character-sheet" x-data="application">
    <header>
        <div class="portrait"></div>
        <div class="character-infos">
            <h1 class="character-name"><input x-model="characterName"  @keyup="save()"/></h1>
            <p class="character-info"><input class="character-age" x-model="characterAge"  @keyup="save()"/> ans</p>
            <p class="character-info"><input class="character-profession"x-model="characterProfession"  @keyup="save()"/></p>
            <p class="character-info">Points de vie : <span x-text="50 + attributes.constitution * 10"></span></p>
        </div>
        <div class="pv-container"></div>

        <div class="character-attributes">
                <div class="character-attribute">
                    <span class="character-attribute-name">Perception</span>
                    <input onfocus="this.select()" x-model="attributes.perception" class="character-attribute-value" @keyup="save()">
                </div>
                <div class="character-attribute">
                    <span class="character-attribute-name">Force</span>
                    <input onfocus="this.select()" x-model="attributes.force" class="character-attribute-value" @keyup="save()">
                </div>
                <div class="character-attribute">
                    <span class="character-attribute-name">Agilité</span>
                    <input onfocus="this.select()" x-model="attributes.agilite" class="character-attribute-value" @keyup="save()">
                </div>
                <!-- <div class="character-attribute">
                    <span class="character-attribute-name">Volonté</span>
                    <span class="character-attribute-value">0</span>
                </div> -->
                <div class="character-attribute">
                    <span class="character-attribute-name">Constitution</span>
                    <input onfocus="this.select()" x-model="attributes.constitution" class="character-attribute-value" @keyup="save()">
                </div>
                <div class="character-attribute">
                    <span class="character-attribute-name">Charisme</span>
                    <input onfocus="this.select()" x-model="attributes.charisme" class="character-attribute-value" @keyup="save()">
                </div>
            </div>


    </header>

    <main>
        <div>
            Points de compétence utilisés : <input x-model="getSkillPointsCount()"/>
        </div>
        <div class="skills-container">

            <template x-for="col in cols" :key="col">
                <div class="col">
                    <template x-for="cluster in col.clusters" :key="cluster.name">
                        <div class="skill-cluster">
                            <h3>
                                <span x-text="cluster.name " class="cluster-name"></span>
                                <span x-text="cluster.details" class="cluster-details"></span>
                                <span x-text="cluster.bonus()" class="cluster-bonus"></span>
                            </h3>
                            <ul>
                                <template x-for="skill in cluster.skills" :key="skill.name">
                                    <li class="skill">
                                        <span x-text="skill.name" class="skill-name"></span>
                                        <!-- <span x-text="skill.value" class="skill-value"></span> -->
                                        <input @keyup="save()" onfocus="this.select()" type="number" x-model="skill.value" class="skill-value">
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>
            </template>
    </main>
</section>

















<script>

    const data = {
        save: function() {
            // fetch with post
            console.log('save');
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    characterName: this.characterName,
                    characterAge: this.characterAge,
                    characterProfession: this.characterProfession,
                    attributes: this.attributes, 
                    cols: this.cols,

                }),
            };
            fetch('?sheet=1&action=save', options)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                });
        },

        getSkillPointsCount: function() {
            let count = 0;
            for (let col of this.cols) {
                for (let clusterName in col.clusters) {
                    let cluster = col.clusters[clusterName];
                    for (let skillName in cluster.skills) {
                        let skill = cluster.skills[skillName];
                        console.log(skill.value)
                        count += parseInt(skill.value);
                    }
                }
            }
            return count;
        },
        characterName: '{{$characterName}}',
        characterAge: '{{$characterAge}}',
        characterProfession: '{{$characterProfession}}',
        attributes: <?php echo json_encode($characterData['attributes']); ?>,
        cols: [
            {
                clusters: {
                    'combat': {
                        name: 'Combat',
                        details: '(AG+FO+PE)/2',
                        bonus() {
                            return Math.floor((
                                parseInt(reactiveData.attributes.agilite) +
                                parseInt(reactiveData.attributes.force) +
                                parseInt(reactiveData.attributes.perception)
                            / 2));
                        },
                        skills: {
                            'mains-nue': { name: 'Mains nues', value: <?php echo $skills['mains-nue'] ?? 0; ?> },
                            'armes-blanches': { name: 'Armes blanches', value: <?php echo $skills['armes-blanches'] ?? 0; ?> },
                            'armes-de-poing': { name: 'Armes de poing', value: <?php echo $skills['armes-de-poing'] ?? 0; ?> },
                            'armes-de-jets': { name: 'Armes de jets', value: <?php echo $skills['armes-de-jets'] ?? 0; ?> },
                            'fusils': { name: 'Fusils', value: <?php echo $skills['fusils'] ?? 0; ?> },
                            'armes-lourdes': { name: 'Armes lourdes', value: <?php echo $skills['armes-lourdes'] ?? 0; ?> },
                        },
                    },
                    'discretion': {
                        name: 'Discrétion',
                        details: 'AG+(PE/2)',
                        bonus() {
                            return Math.floor((
                                parseInt(reactiveData.attributes.agilite) +
                                parseInt(reactiveData.attributes.perception) / 2
                            ));
                        },
                        skills: {
                            'infiltration': { name: 'Infiltration', value: <?php echo $skills['infiltration'] ?? 0; ?> },
                            'filature': { name: 'Filature', value: <?php echo $skills['filature'] ?? 0; ?> },
                            'crochetage': { name: 'Crochetage', value: <?php echo $skills['crochetage'] ?? 0; ?> },
                            'vol-a-la-tire': { name: 'Vol à la tire', value: <?php echo $skills['vol-a-la-tire'] ?? 0; ?> },
                            'triche': { name: 'Triche', value: <?php echo $skills['triche'] ?? 0; ?> },
                        },
                    },
                    'physique': {
                        name: 'Physique',
                        details: '(AG+CO+FO)/3',
                        bonus() {
                            return Math.floor((
                                parseInt(reactiveData.attributes.agilite) +
                                parseInt(reactiveData.attributes.force) +
                                parseInt(reactiveData.attributes.constitution)
                            ) / 3);
                        },
                        skills: {
                            'sprint': { name: 'Sprint', value: <?php echo $skills['sprint'] ?? 0; ?> },
                            'escalade': { name: 'Escalade', value: <?php echo $skills['escalade'] ?? 0; ?> },
                            'nage': { name: 'Nage', value: <?php echo $skills['nage'] ?? 0; ?> },
                            'saut': { name: 'Saut', value: <?php echo $skills['saut'] ?? 0; ?> },
                        },
                    },
                },
            },
            {
                clusters: {
                    'technique': {
                        name: 'Technique',
                        details: 'PE',
                        bonus() {
                            return parseInt(reactiveData.attributes.perception);
                        },
                        skills: {
                            'mecanique': { name: 'Mécanique', value: <?php echo $skills['mecanique'] ?? 0; ?> },
                            'electronique': { name: 'Electronique', value: <?php echo $skills['electronique'] ?? 0; ?> },
                            'medecine': { name: 'Médecine', value: <?php echo $skills['medecine'] ?? 0; ?> },
                            'explosifs': { name: 'Explosifs', value: <?php echo $skills['explosifs'] ?? 0; ?> },
                        },
                    },
                    'artisanat': {
                        name: 'Artisanat',
                        details: '(PE+AG)/2',
                        bonus() {},
                        skills: {
                            'cuisine': { name: 'Cuisine', value: <?php echo $skills['cuisine'] ?? 0; ?> },
                            'couture': { name: 'Couture', value: <?php echo $skills['couture'] ?? 0; ?> },
                            'forge': { name: 'Forge', value: <?php echo $skills['forge'] ?? 0; ?> },
                            'bricolage': { name: 'Bricolage', value: <?php echo $skills['bricolage'] ?? 0; ?> },
                        },
                    },
                },
            },
            {
                clusters: {
                    'social': {
                        name: 'Social',
                        details: 'CH',
                        bonus() {
                            return parseInt(reactiveData.attributes.charisme);
                        },
                        skills: {
                            'negociation': { name: 'Négociation', value: <?php echo $skills['negociation'] ?? 0; ?> },
                            'intimidation': { name: 'Intimidation', value: <?php echo $skills['intimidation'] ?? 0; ?> },
                            'bluff': { name: 'Bluff', value: <?php echo $skills['bluff'] ?? 0; ?> },
                            'seduction': { name: 'Séduction', value: <?php echo $skills['seduction'] ?? 0; ?> },
                            'psychologie': { name: 'Psychologie', value: <?php echo $skills['psychologie'] ?? 0; ?> },
                        },
                    },
                },
            },
            {
                clusters: {
                    'survie': {
                        name: 'Survie',
                        details: 'CO+PE',
                        bonus() {
                            return parseInt(reactiveData.attributes.constitution) + parseInt(reactiveData.attributes.perception);
                        },
                        skills: {
                            'orientation': { name: 'Orientation', value: <?php echo $skills['orientation'] ?? 0; ?> },
                            'premiers-secours': { name: 'Premiers secours', value: <?php echo $skills['premiers-secours'] ?? 0; ?> },
                            'survie-en-milieu-hostile': { name: 'Survie en milieu hostile', value: <?php echo $skills['survie-en-milieu-hostile'] ?? 0; ?> },
                            'connaissance-du-milieu-urbain': { name: 'Connaissance du milieu urbain', value: <?php echo $skills['connaissance-du-milieu-urbain'] ?? 0; ?> },
                            'pistage': { name: 'Pistage', value: <?php echo $skills['pistage'] ?? 0; ?> },
                            'dressage': { name: 'Dressage', value: <?php echo $skills['dressage'] ?? 0; ?> },
                        },
                    },
                    'culture': {
                        name: 'Culture',
                        details: '(PE+CH)/2',
                        bonus() {
                            return Math.floor((
                                parseInt(reactiveData.attributes.perception) +
                                parseInt(reactiveData.attributes.charisme)
                            ) / 2);
                        },
                        skills: {
                            'histoire': { name: 'Histoire', value: <?php echo $skills['histoire'] ?? 0; ?> },
                            'geographie': { name: 'Géographie', value: <?php echo $skills['geographie'] ?? 0; ?> },
                            'langues': { name: 'Langues', value: <?php echo $skills['langues'] ?? 0; ?> },
                            'chimie': { name: 'Chimie', value: <?php echo $skills['chimie'] ?? 0; ?> },
                            'biologie': { name: 'Biologie', value: <?php echo $skills['biologie'] ?? 0; ?> },
                            'esoterisme': { name: 'Esotérisme', value: <?php echo $skills['esoterisme'] ?? 0; ?> },
                            'astrologie': { name: 'Astrologie', value: <?php echo $skills['astrologie'] ?? 0; ?> },
                            'antropologie': { name: 'Antropologie', value: <?php echo $skills['antropologie'] ?? 0; ?> },
                        },
                    },
                },
            }
        ]
    }

    let reactiveData = null;


    document.addEventListener('alpine:init', () => {

        console.log('%ccharacter-sheet.blade.php :: 307 =============================', 'color: #f00; font-size: 1rem');
        console.log("apine init");

        reactiveData = Alpine.reactive(data);

        // Alpine.data('application', () => (reactiveData))
        // Alpine.data('application', () => (data))
        Alpine.data('application', () => (reactiveData))
    });

    </script>




@endsection
