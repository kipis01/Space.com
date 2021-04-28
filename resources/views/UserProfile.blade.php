<!DOCTYPE html>
<html>
    <head>
        <?php include_once '../resources/php/functions.php' ?>
        <x-resources/>
        <link rel="icon" href="/Users/{{$profile[0]->id}}/{{findpfp("Users/".$profile[0]->id)}}">
        <link rel="stylesheet" href="/css/users.css">
    </head>
    <body>
        <x-navbar/>
        <div id="panel">
            <div class="flex">
                <div id="profile-card">
                    <img src="/Users/{{$profile[0]->id}}/{{findpfp("Users/".$profile[0]->id)}}" alt="Profile picture" width="400px" class="center">
                    <h1 class="center">{{$profile[0]->Username}}</h1>
                </div>
                <div id="profile-info">
                    <h1>Member since: {{$profile[0]->created_at}}</h1>
                    <h1>Role: {{$profile[0]->Role}}</h1>
                    <p><a href="/settings/{{$profile[0]->id}}">Edit profile</a></p>
                </div>
            </div>
            @if ($forumPosts != [] || $forumComments != [])
                <div id="forum">
                    <h1 class="center">Forum contributions</h1>
                    @if ($forumPosts != [])
                        <h3 class="center">Forum posts</h3>
                        @foreach ($forumPosts as $i)
                            <div class="box center flex">
                                @if ($i->HasAttachments)
                                    <div class="center"><img src="/forum_data/{{$i->id}}/{{getFirstAtt("forum_data/$i->id")}}" alt="main media" width="300px"></div>
                                @endif
                                <div class="center">
                                    <h3><a href="/forum/{{$i->id}}">{{$i->Title}}</a></h3>
                                    <p>Posted: {{$i->Date}}</p>
                                    <p>{{$i->Message}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if ($forumComments != [])
                        <h3 class="center">Forum interactions</h3>
                        @foreach ($forumComments as $i)<!--id, Post, Date, Message, HasAttachments-->
                            <div class="box center flex">
                                @if ($i->HasAttachments)
                                    <div class="center"><img src="/forum_data/{{$i->Post}}/{{$i->id}}/{{getFirstAtt("forum_data/$i->Post/$i->id")}}" alt="main media" width="300px"></div>
                                @endif
                                <div class="center">
                                    <p><a href="/forum/{{$i->Post}}#{{$i->id}}">Posted: {{$i->Date}}</a></p>
                                    <p>{{$i->Message}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    </body>
</html>
