@php
use Deljdlx\WPTaverne\Models\ScenarioEvent;



@endphp

@extends('layouts/common/default')
@section('page-title')
    {{$pageTitle}}
@endsection

@section('page-content')


<section>
    {{-- display events timeline with daisy ui --}}
    <h1>{!!$pageTitle!!}</h1>

    <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical">

        @php
            $odd = true;
        @endphp
        @foreach($sortedEvents as $date => $events)
            @php
                $odd = !$odd;
                $classTextAlign = $odd ? 'pr-5 timeline-start md:text-end' : 'pl-5 timeline-end';

                $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                $months = [
                    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ];

                $fullTextDate = $days[date('N', strtotime($date)) - 1] . ' ' . date('d', strtotime($date)) . ' ' . $months[date('m', strtotime($date)) - 1] . ' ' . date('Y', strtotime($date));

            @endphp
            <li class="timeline-block">
                <div class="timeline-middle">
                    {{--  <img src="{{get_theme_file_uri('assets/images/timeline-dot.svg')}}" width="20px" height="20px"> --}}
                    <span class="moon-phase" data-date="{{$date}}">{{$date}}</span>
                </div>

                <div class="timeline-start mb-10 {{$classTextAlign}}">
                    <time class="timeline-date">
                        {{ $fullTextDate }}
                    </time>

                    @foreach($events as $event)
                        <div class="timeline-event">
                            <div class="timeline-event-title">{{ $event['title'] }}</div>
                            {{-- apply the_post filter, display content, --}}
                            <div class="timeline-event-content">{!! apply_filters('the_content', $event['content']) !!}</div>
                        </div>
                    @endforeach
                </div>
                <hr />
            </li>
        @endforeach

    </ul>

</section>


@endsection
