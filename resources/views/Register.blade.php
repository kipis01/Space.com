<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/login.css">
        <script>
            window.onload = function(){
                taken_usernames = [
                @foreach ($usernames as $i)
                    "{{$i->Username}}",
                @endforeach
                ];//TODO:Implement with ajax?
                action = '{{action([App\Http\Controllers\UserController::class, 'store'])}}';
                nickname = document.getElementById("nickname");
                pass = document.getElementById("pass");
                pass2 = document.getElementById("passRep");
                warn1 = [document.getElementById("nickname"), document.getElementById("warn1")];
                warn2 = [document.getElementById("passRep"), document.getElementById("warn2")];
                warn3 = document.getElementById("warn3");
            }
        </script>
        <script src="/js/auth.js"></script>
    </head>
    <body>
        <x-navbar/>
        <section id="registration">
            <form method="POST" onsubmit="return false;" id="register" class="center">
                @csrf
                <div id="fields">
                    <label for="nickname">{{__('messages.Choose a nickname')}}: </label>
                    <input type="text" name="nickname" id="nickname" oninput="checkInput()">
                    <br><span id="warn1"></span><br>
                    <label for="pass">{{__('messages.Choose a password')}}: </label>
                    <input type="password" name="pass" id="pass" oninput="checkInput()">
                    <br>
                    <label for="passRep">{{__('messages.Repeat the password')}}</label>
                    <input type="password" name="passRep" id="passRep" oninput="checkInput()">
                    <br><span id="warn2"></span>
                </div>
                <input type="submit" value="Register" onclick="submition()"><br>
                <span id="warn3"></span>
            </form>
        </section>
    </body>
</html>
