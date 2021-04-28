<!DOCTYPE html>
<html>
    <head>
        <?php include_once '../resources/php/functions.php'; ?>
        <title>Users</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/users.css">
    </head>
    <body>
        <x-navbar/>
        <div id="panel">
            <h1 class="center">Users</h1>
            @if(count($users) == 0)
                <h3 class="center">There are no users!</h3>
            @endif
            @foreach ($users as $i)
                <div class="user flex center">
                    <div>
                        <img src="/Users/{{$i->id}}/{{findpfp("Users/$i->id")}}" alt="pfp" width="200px">
                    </div>
                    <div class="center">
                        <h3 class="center"><a href="/user/{{$i->id}}">{{$i->Username}}</a></h3>
                        <h5>Role: {{$i->Role}}</h5>
                        <p>User since: {{$i->created_at}}</p>
                        @if (Auth::user()->role == "Admin")
                            <p><a href="/settings/{{$i->id}}">Edit profile</a></p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </body>
</html>
