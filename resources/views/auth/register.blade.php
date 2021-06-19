<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/login.css">
        <script>
            $(document).ready(function () {
                $('#name').on('change', checkNick);
            });

            function checkNick(){
                $.ajax({
                    type: "GET",
                    url: "{{route('checkNick')}}",
                    data: {nick: $('#name').val()},
                    success: function (response) {
                        if(response){
                            $('#name').css('background-color', 'white');
                            $('#warn1').text('');
                        }else{
                            $('#name').css('background-color', 'red');
                            $('#warn1').text('{{__('messages.The username is already taken!')}}');
                        }
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }

            function checkInput(){
                if ($('#password').val() != $('#pass2').val())
                    warning($('#warn2'), 1, "The passwords don't match");
                else warning($('#warn2'));
            }
        </script>
        <script src="/js/common.js"></script>
    </head>
    <body>
        <x-navbar/>
        <section id="registration">
            <form method="POST" id="register" class="center" action="{{ route('register') }}">
                @csrf
                <div id="fields">
                    <label for="email">{{__('messages.E-mail')}}:</label>
                    <input type="email" name="email" id="email" required="required"><br>
                    <label for="name">{{__('messages.Choose a nickname')}}: </label>
                    <input type="text" name="name" id="name" required="required" oninput="checkInput()">
                    <br><span id="warn1"></span><br>
                    <label for="password">{{__('messages.Choose a password')}}: </label>
                    <input type="password" name="password" id="password" required="required" oninput="checkInput()"><br>
                    <label for="passRep">{{__('messages.Repeat the password')}}</label>
                    <input type="password" name="pass2" id="pass2" required="required" oninput="checkInput()">
                    <br><span id="warn2"></span>
                </div>
                <input type="submit" value="Register"><br>
            </form>
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </section>
    </body>
</html>
