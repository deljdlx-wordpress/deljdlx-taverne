@php
if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = get_user_by('email', $email);
    
    if(!$user) {
        $user_id = wp_create_user($email, $password, $email);
        $user = get_user_by('id', $user_id);
        wp_set_current_user($user_id, $email);
        wp_set_auth_cookie($user_id);
        // do_action('wp_login', $email);
        wp_redirect(home_url());
        exit;
    }

    wp_redirect(home_url());
}

@endphp

@extends('layouts/common/with-right-column')
@section('page-title')
    Inscription
@endsection

@section('page-content')

<h1> Devenir rédacteur </h1>
    <form method="post" action="?">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"  class="input input-bordered"/>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password"  class="input input-bordered"/>
    </div>
    <button class="btn btn-primary" type="submit">Inscription</button>
</form>
@endsection
