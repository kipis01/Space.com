<!DOCTYPE html>
<html>
    <head>
        <title>{{$post[0]->Title}}</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/forum-thread.css">
        <?php
            function getAtt($dir){
                $files = scandir($dir);
                $files = array_diff($files, ['.', '..']);
                $att = array();
                foreach ($files as $i)
                    if (str_contains($i, '.'))
                        array_push($att, $i);
                return $att;
            }
        ?>
    </head>
    <body>
        <x-navbar/>
        <section id="main" class="thread">
            <h2 class="title center">{{$post[0]->Title}}</h2>
            <p class="right">At: {{$post[0]->Date}}</p>
            <p>By: {{$post[0]->Username}}</p>
            <p class="message">{{$post[0]->Message}}</p>
            @if ($post[0]->HasAttachments)
                @foreach (getAtt('forum_data/' . $post[0]->id) as $i)
                    <img src= "/forum_data/{{$post[0]->id}}/{{$i}}" alt="image">
                @endforeach
            @endif
        </section>
        <section id="comments">
            @if (count($thread) == 0)
                <h3 class="center">This post has no answers yet.</h3>
            @endif
            @foreach ($thread as $i)
                <div class="thread thread-comm">
                    <p class="right">At: {{$i->Date}}</p>
                    <p>By: {{$i->Username}}</p>
                    <p class="message">{{$i->Message}}</p>
                    @if ($i->HasAttachments)
                        @foreach (getAtt('forum_data/' . $post[0]->id . "/$i->id") as $k)
                            <img src= "/forum_data/{{$post[0]->id}}/{{$i->id}}/{{$k}}" alt="image">
                        @endforeach
                    @endif
                </div>
            @endforeach
        </section>
    </body>
</html>
