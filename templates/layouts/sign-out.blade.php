@php
// logout user
wp_logout();

@endphp

@extends('layouts/common/default')
@section('page-title')
    Déconnexion
@endsection

@section('page-content')
<h1> Vous êtes à présent déconnecté </h1>

@endsection
