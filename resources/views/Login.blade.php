<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/login.css">
        <script>
            function check(){
                if (document.getElementById("nickname").value != '' && document.getElementById("pass").value != ''){
                    document.getElementById("form").action = ''/*'action([App\Http\Controllers\UserController::class, 'login'])'*/;
                    document.getElementById("form").submit();
                }
            }
        </script>
    </head>
    <body>
        <x-navbar/>
        <section id="login">
            <form method="POST" onsubmit="return false;" id="form">
                @csrf
                <label for="nickname">Username: </label>
                <input type="text" name="nickname" id="nickname"><br>
                <label for="pass">Password: </label>
                <input type="password" name="pass" id="pass"><br>
                <input type="submit" onclick="check()">
            </form>
            <h1>Don't have an accound? <a href="/authenticate/register">Click here to register</a></h1>
        </section>
    </body>
</html>
