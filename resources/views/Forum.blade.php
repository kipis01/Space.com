<!DOCTYPE html>
<html>
    <head>
        <title>Forum</title>
        <link rel="icon" href="/img/Logo.png">
        <link rel="stylesheet" href="/css/default.css">
        <link rel="stylesheet" href="/css/forum.css">
        <?php
            function getFirstAtt($id){
                $files = scandir("forum_data/$id");
                foreach ($files as $i)
                    if ($i[0] == '1')
                        return $i;
            }
        ?>
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
                    <h3>{{$i->Title}}</h3>
                    <p>By: {{$i->Username}}</p>
                    <p>Started at: {{$i->Date}}</p>
                    @if ($i->HasAttachments)
                        <img src="forum_data/{{$i->id}}/{{getFirstAtt($i->id)}}" width="100px" alt="thread img">
                    @endif
                </div>
            @endforeach
        </section>
    </body>
</html>
