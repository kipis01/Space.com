<!DOCTYPE html>
<html>
    <head>
        <?php include_once '../resources/php/functions.php' ?>
        <title>Settings for {{$user[0]->Username}}</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/users.css">
        <?php //Need to add in client side checks ?>
        <script>
            function deleteAcc(){
                if (prompt("Are you sure, that you wish to delete your account? To proceed, type in 'Yes'") == 'Yes'){
                    window.location.replace('{{action([App\Http\Controllers\UserController::class, 'destroy'], $user[0]->id)}}');
                }
            }
        </script>
    </head>
    <body>
        <x-navbar/>
        <div id="panel">
            <form action="{{action([App\Http\Controllers\UserController::class, 'update'], $user[0]->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex">
                    <div class="center">
                        <img src="/Users/{{$user[0]->id}}/{{findpfp("Users/".$user[0]->id)}}" alt="Profile picture" width="400px" class="center">
                        <label for="pfp">{{__('messages.Select a file to change the profile picture')}}:</label>
                        <input type="file" id="pfp" name="pfp">
                    </div>
                    <div class="center">
                        <h3 class="center">{{$user[0]->Username}}</h3>
                        <label for="nickname">{{__('messages.Change username')}}</label>
                        <input type="text" id="nickname" name="nickname"><br><br>
                        @if (Auth::user()->id == $user[0]->id)
                            <label for="pass1">{{__('messages.Change password')}}</label>
                            <input type="password" id="pass1" name="pass1"><br>
                            <label for="pass2">{{__('messages.Repeat the new password')}}</label>
                            <input type="password" id="pass2" name="pass2">
                        @endif
                        @if (Auth::user()->role == 'Admin')
                            <label for="role">User role: </label>
                            <select id="role" name="role">
                                <option {{($user[0]->Role == "Admin") ? "selected" : ""}}>Admin</option>
                                <option {{($user[0]->Role == "Editor") ? "selected" : ""}}>Editor</option>
                                <option {{($user[0]->Role == "User") ? "selected" : ""}}>User</option>
                            </select>
                        @endif
                    </div>
                </div>
                <div class="center">
                    <label for="pass">{{__('messages.To make changes, enter your password')}}: </label>
                    <input type="password" id="pass" name="pass">
                    <input type="submit">
                </div>
            </form>
            <div id="delete", class="center">
                <h2>{{__('messages.Delete this account')}}:</h2>
                <button onclick="deleteAcc()">{{__('messages.DELETE')}}</button>
            </div>
        </div>
    </body>
</html>
