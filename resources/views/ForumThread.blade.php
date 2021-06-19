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
            <p class="right">{{__('messages.At')}}: {{$post[0]->created_at}}</p>
            <p>{{__('messages.By')}}: {{$post[0]->Username}}</p>
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
                <div class="thread thread-comm" id="{{$i->id}}">
                    <p class="right">At: {{$i->created_at}}</p>
                    <p>By: {{$i->Username}}</p>
                    <p class="message">{{$i->Message}}</p>
                    @if ($i->HasAttachments)
                        @foreach (getAtt('forum_data/' . $post[0]->id . "/$i->id") as $k)
                            <img class="content" src= "/forum_data/{{$post[0]->id}}/{{$i->id}}/{{$k}}" alt="image">
                        @endforeach
                    @endif
                </div>
            @endforeach
            @if (isset(Auth::user()->id))
                <div class="center">
                    <form method="POST" onsubmit="forum/{{$post[0]->id}}" enctype="multipart/form-data">
                        @csrf
                        <label for="message">{{__('messages.Message')}}</label>
                        <textarea id="message" name="message" required="required"></textarea><br>
                        <label for="file1">{{__('messages.1st picture')}}:</label>
                        <input name="file1" type="file" id="file1"><br>
                        <label for="file2">{{__('messages.2nd picture')}}:</label>
                        <input name="file2" type="file" id="file2"><br>
                        <label for="file3">{{__('messages.3rd picture')}}:</label>
                        <input name="file3" type="file" id="file3"><br><br>
                        <input type="submit">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    </form>
                </div>
            @endif
        </section>
    </body>
</html>
