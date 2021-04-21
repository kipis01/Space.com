<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/login.css">
        <script>
            var taken_usernames = [
            @foreach ($usernames as $i)
                "{{$i->Username}}",
            @endforeach
            ];
            function check(){
                let nickname = document.getElementById("nickname").value, pass = document.getElementById("pass").value, pass2 = document.getElementById("passRep").value;
                if (nickname != "" && !taken_usernames.includes(nickname) && pass != '' && pass == pass2){
                    document.getElementById("form").action = '{{action([App\Http\Controllers\UserController::class, 'store'])}}'
                    document.getElementById("form").submit();
                }//TODO: Add error messages
            }
        </script>
    </head>
    <body>
        <x-navbar/>
        <section id="register">
            <form method="POST" onsubmit="return false;" id="form">
                @csrf
                <label for="nickname">Choose a nickname: </label>
                <input type="text" name="nickname" id="nickname"><br>
                <label for="pass">Choose a password: </label>
                <input type="password" name="pass" id="pass"><br>
                <label for="passRep">Repeat the password</label>
                <input type="password" name="passRep" id="passRep">
                <input type="submit" onclick="check()">
            </form>
        </section>
    </body>
</html>
