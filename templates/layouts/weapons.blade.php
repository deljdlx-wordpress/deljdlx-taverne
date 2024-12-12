@php
$json = '
[
    {
        "name": "Couteau de chasse",
        "description": "Un couteau robuste pour le combat rapproché.",
        "type": "cac",
        "price": 50,
        "damage": 20,
        "range": 1,
        "accuracy": 90,
        "area": "-",
        "fireRate": 0,
        "magazine": 0,
        "weight": 1.0
    },
    {
        "name": "Machette",
        "description": "Une arme de mêlée efficace, idéale pour couper et trancher.",
        "type": "cac",
        "price": 70,
        "damage": 25,
        "range": 1,
        "accuracy": 85,
        "area": "-",
        "fireRate": 0,
        "magazine": 0,
        "weight": 2.0
    },
    {
        "name": "Poing américain",
        "description": "Un outil de combat rapproché discret mais efficace.",
        "type": "cac",
        "price": 30,
        "damage": 15,
        "range": 1,
        "accuracy": 95,
        "area": "-",
        "fireRate": 0,
        "magazine": 0,
        "weight": 0.5
    },
    {
        "name": "Fusil de chasse calibre 12",
        "description": "Une arme à feu fiable pour la chasse ou le combat.",
        "type": "légère",
        "price": 150,
        "damage": 50,
        "range": 20,
        "accuracy": 70,
        "area": "-",
        "fireRate": 1,
        "magazine": 4,
        "weight": 3.5
    },
    {
        "name": "Revolver .44",
        "description": "Une arme puissante avec un faible nombre de munitions.",
        "type": "légère",
        "price": 200,
        "damage": 45,
        "range": 25,
        "accuracy": 75,
        "area": "-",
        "fireRate": 1,
        "magazine": 6,
        "weight": 2.0
    },
    {
        "name": "Fusil laser",
        "description": "Une arme à énergie standard émettant des faisceaux précis.",
        "type": "energie",
        "price": 600,
        "damage": 55,
        "range": 75,
        "accuracy": 85,
        "area": "-",
        "fireRate": 1.5,
        "magazine": 10,
        "weight": 4.5
    },
    {
        "name": "Lance-roquettes",
        "description": "Une arme lourde conçue pour infliger des dégâts massifs.",
        "type": "lourde",
        "price": 800,
        "damage": "120",
        "range": 100,
        "accuracy": 60,
        "area": "8m",
        "fireRate": 0.5,
        "magazine": 1,
        "weight": 12.0
    },
    {
        "name": "Lance-flammes",
        "description": "Idéal pour le combat rapproché avec des ennemis en groupe.",
        "type": "lourde",
        "price": 500,
        "damage": 120,
        "range": 5,
        "accuracy": 70,
        "area": "4m",
        "fireRate": 2,
        "magazine": 10,
        "weight": 15.0
    },
    {
        "name": "Grenade à fragmentation",
        "description": "Une grenade explosive causant des dégâts de zone.",
        "type": "lancer",
        "price": 100,
        "damage": 60,
        "range": 10,
        "accuracy": 60,
        "area": "4m",
        "fireRate": 0,
        "magazine": 1,
        "weight": 0.5
    },
    {
        "name": "Grenade IEM",
        "description": "Une grenade explosive causant des dégâts de zone.",
        "type": "lancer",
        "price": 150,
        "damage": 80,
        "range": 10,
        "accuracy": 60,
        "area": "8m",
        "fireRate": 0,
        "magazine": 1,
        "weight": 0.5
    },
    {
        "name": "Super Masse",
        "description": "Une arme à énergie pour le combat rapproché, propulsée par un noyau de fusion.",
        "type": "energie",
        "price": 400,
        "damage": 80,
        "range": 1,
        "accuracy": 80,
        "area": "-",
        "fireRate": 0.5,
        "magazine": 0,
        "weight": 12.0
    },
    {
        "name": "Super Poing",
        "description": "Une arme à énergie pour le corps à corps, dotée d\'un mécanisme percutant dévastateur alimenté par un noyau de fusion.",
        "type": "cac",
        "price": 350,
        "damage": 75,
        "range": 1,
        "accuracy": 85,
        "area": "-",
        "fireRate": 1,
        "magazine": 0,
        "weight": 3.0
    },
    {
        "name": "Positolet laser",
        "description": "Une arme légère à énergie, parfaite pour les tirs précis.",
        "type": "energie",
        "price": 350,
        "damage": 40,
        "range": 50,
        "accuracy": 85,
        "area": "-",
        "fireRate": 1.5,
        "magazine": 12,
        "weight": 3.0
    },
    {
        "name": "Sniper longue portée",
        "description": "Une arme idéale pour les tirs précis à grande distance.",
        "type": "légère",
        "price": 500,
        "damage": 80,
        "range": 200,
        "accuracy": 90,
        "area": "-",
        "fireRate": 0.5,
        "magazine": 5,
        "weight": 6.0
    },
    {
        "name": "Mitrailleuse lourde",
        "description": "Une arme lourde à cadence de tir élevée, idéale pour neutraliser plusieurs ennemis.",
        "type": "lourde",
        "price": 700,
        "damage": 55,
        "range": 75,
        "accuracy": 65,
        "area": "-",
        "fireRate": 6,
        "magazine": 200,
        "weight": 12.0
    },
    {
        "name": "Stimpacks",
        "description": "Des médicaments qui restaurent la santé.",
        "type": "-",
        "price": 100,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "-",
        "weight": 0.5
    },
    {
        "name": "Roquette",
        "description": "Roquette explosive, idéale pour les cibles lourdes.",
        "type": "munition",
        "price": 200,
        "damage": "120",
        "range": "-",
        "accuracy": "-",
        "area": "8m",
        "fireRate": "-",
        "magazine": "1",
        "weight": 5
    },
    {
        "name": "Armure de cuir",
        "description": "Armure légère en cuir pour une protection de base",
        "type": "armure",
        "price": 250,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "-",
        "weight": 3,
        "armor": 5
    },
    {
        "name": "Armure de cuir renforcée de plaques",
        "description": "Armure en cuir renforcée de plaques métalliques pour une protection supplémentaire.",
        "type": "armure",
        "price": 350,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "-",
        "weight": 5,
        "armor": 10
    },
    {
        "name": "Armure de combat",
        "description": "Armure de combat faite d\'alliage de métal pour une protection avancée.",
        "type": "armure",
        "price": 500,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "-",
        "weight": 8,
        "armor": 20
    },
    {
        "name": "Armure de combat lourde",
        "description": "Armure de combat avancée pour une protection maximale",
        "type": "armure",
        "price": 800,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "-",
        "weight": 15,
        "armor": 30
    },
    {
        "name": "Cellules à microfusion",
        "description": "Cellules à microfusion pour alimenter les armes à énergie.",
        "type": "munition",
        "price": 200,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "60",
        "weight": 5
    },
    {
        "name": "Munitions de fusil de chasse",
        "description": "Munitions pour fusil de chasse calibre 12.",
        "type": "munition",
        "price": 100,
        "damage": "-",
        "range": "-",
        "accuracy": "-",
        "area": "-",
        "fireRate": "-",
        "magazine": "20",
        "weight": 1
    },
    {
        "name": "Munitions pour revolver .44",
        "description": "Munitions pour revolver .44.",
        "type": "munition",
        "price": 100,
        "magazine": "24",
        "weight": 1
    }
]

';

$data = json_decode($json, true);


@endphp

@extends('layouts/common/empty')


@section('page-title')
    Armes
@endsection


@section('body-content')

<section>
    {{-- table of $data --}}
    <table class="table table-compact datatable">
        {{-- table-zebra --}}
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Type</th>
                <th>Prix</th>
                <th>Dégâts</th>
                <th>Armure</th>
                <th>Portée</th>
                {{-- <th>Précision</th> --}}
                <th>Zone</th>
                {{-- <th>Cadence</th> --}}
                <th>Chargeur</th>
                <th>Poids</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $weapon)
                <tr>
                    <td>{{$weapon['name'] ?? '-'}}</td>
                    <td>{{$weapon['description'] ?? '-'}}</td>
                    <td>{{$weapon['type'] ?? '-'}}</td>
                    <td>{{$weapon['price'] ?? '-'}}</td>
                    <td>{{$weapon['damage'] ?? '-'}}</td>
                    <td>{{$weapon['armor'] ?? '-'}}</td>
                    <td>{{$weapon['range'] ?? '-'}}</td>
                    {{-- <td>{{$weapon['accuracy'] ?? '-'}}</td> --}}
                    <td>{{$weapon['area'] ?? '-'}}</td>
                    {{-- <td>{{$weapon['fireRate'] ?? '-'}}</td> --}}
                    <td>{{$weapon['magazine'] ?? '-'}}</td>
                    <td>{{$weapon['weight'] ?? '-'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>


<script>


    document.addEventListener('DOMContentLoaded', function() {
        let table = new DataTable('.datatable', {
            paging: false,
        });
    });




    // datatable on".datatable"
    // document.addEventListener('DOMContentLoaded', function() {
    //     var tables = document.querySelectorAll('.datatable');
    //     tables.forEach(function(table) {
    //         $(table).DataTable();
    //     });
    // });

    // document.addEventListener('DOMContentLoaded', function() {
    //     $('.datatable').DataTable( {
    //         paging: false,
    //         scrollY: 400
    //     });
    // });

</script>


@endsection
