@php
$days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

$today = new DateTime();
$today->setTimezone(new DateTimeZone('Europe/Paris'));
$day = $today->format('w');
$day = $days[$day];

$date = $today->format('d');

$month = $today->format('n');
$month = $months[$month - 1];

$year = $today->format('Y');

//1 edition per day since 1st january 1890
$editionNumber = $today->diff(new DateTime('1890-01-01'))->days + 1;

$saints = json_decode(file_get_contents(get_template_directory() . '/resources/saints.json'), true);

$dayWithout0 = ltrim($today->format('d'), '0');
$saint = $saints[$today->format('m')][$dayWithout0][0];
@endphp



<div class="edition-info">
    {{-- <span>
        {{ $saint }}
    </span>
    <span>
        {{ $day }} {{ $date }} {{ $month }} {{ $year }}
    </span> --}}
    <span>
        Edition n°{{ $editionNumber }}
    </span>

    @if(is_user_logged_in())
        <a href="{{ home_url() }}/sign-out" title="Disconnect">Déconnexion</a>
    @endif
</div>