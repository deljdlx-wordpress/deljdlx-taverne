@php

if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = get_user_by('email', $email);
    
    if($user) {
        // login
        $user_id = $user->ID;
        wp_set_current_user($user_id, $email);
        wp_set_auth_cookie($user_id);
        // do_action('wp_login', $email);

    }

    wp_redirect(home_url());
    exit;
}

@endphp

@extends('layouts/common/with-right-column')
@section('page-title')
    Connexion
@endsection

@section('page-content')
<h1> Identification </h1>
<form method="post" action="?">
    <div class="form-group">
        <label for="email">Email</label>
        <input  class="input input-bordered w-full max-w-xs" type="email" name="email" id="email" />
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input  class="input input-bordered w-full max-w-xs" type="password" name="password" id="password" />
    </div>
    <button class="btn btn-neutral" type="submit">Se connecter</button>
</form>
@endsection
