<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/login.css">
    </head>
    <body>
        <x-navbar/>
        <section id="login">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('login') }}" id="form" class="center">
                @csrf
                <div id="fields">
                    <label for="email">{{__('messages.E-mail')}}: </label>
                    <input type="email" name="email" id="email" required="required"><br>
                    <label for="pass">{{__('messages.Password')}}: </label>
                    <input type="password" name="password" id="password" required="required">
                </div><br>
                <label for="remember_me">{{__('messages.Remember me')}}</label>
                <input id="remember_me" name="remember" type="checkbox">
                <input type="submit" name="login" value="Sign in">
            </form>
            <h1>{{__("messages.Don't have an count?")}} <a href="/register">{{__('messages.Click here to register')}}</a></h1>
        </section>
    </body>
</html>
