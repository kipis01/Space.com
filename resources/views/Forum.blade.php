<!DOCTYPE html>
<html>
    <head>
        <title>Forum</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/forum.css">
        <?php include_once '../resources/php/functions.php' ?>
    </head>
    <body>
        <x-navbar/><!-- :message='$message' -->
        <section id="forum-content">
            <h1 class="title center">Space forum</h1>
            @if (count($posts) == 0)
                <h3 class="title center">The forum is empty, be the first to contribute!</h3>
            @endif
            @foreach ($posts as $i)
                <div class="thread">
                    <h3><a href = "/forum/{{$i->id}}">{{$i->Title}}</a></h3>
                    <p>By: {{$i->Username}}</p>
                    <p>Started at: {{$i->Date}}</p>
                    @if ($i->HasAttachments)
                        <img src="forum_data/{{$i->id}}/{{getFirstAtt("forum_data/$i->id")}}" alt="thread img">
                    @endif
                </div>
            @endforeach
        </section>
    </body>
</html>
