<!DOCTYPE html>
<html>
    <head>
        <title>{{$article['Title']}}</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/news.css">
        <?php include_once '../resources/php/functions.php' ?>
    </head>
    <body>
        <x-navbar/>
        <div id="main" class="center">
            @if (isset(Auth::user()->id) && (Auth::user()->id == $article['Author'] || Auth::user()->role == 'Admin'))
                <h5><a href="/news/edit/{{$article['id']}}">Edit this article</a></h5>
            @endif
            <h1 class="center">{{$article['Title']}}</h5>
            <img src="/news_data/{{$article['id']}}/{{$xml->head->pic}}" class="artpic" alt="Main article picture">
            <h3>{{$xml->head->text}}</h3>
            <?php
                for($i = 1, $elem = 'd'.$i; $i <= $xml->head->elementc; $i++, $elem = 'd'.$i){
                    switch ($xml->xpath("content/$elem/type")[0]){
                        case 'p':
                            $a = $xml->xpath("content/$elem/a")[0];
                            echo ($a<0?'':'<p>').$xml->xpath("content/$elem")[0].($a>0||$a==-2?' ':'</p>');
                            //0-close all, 1-close begin, -1-close end, -2-leave open
                            break;
                        case 'a':
                            $href = $xml->xpath("content/$elem/href")[0];
                            echo '<a href="'.$xml->xpath("content/$elem/href")[0].'">'.$xml->xpath("content/$elem")[0].'</a>';
                            break;
                        case 'img':
                            echo '<img src="/news_data/'.$article['id'].'/'.$xml->xpath("content/$elem")[0].'" class = "artpic" alt="'.$xml->xpath("content/$elem/alt")[0].'"><br>';
                    }
                }
            ?>
            <div id="comments">
                @if (isset(Auth::user()->id))
                    <form method="POST" onsubmit="/news/{{$article['id']}}">
                        @csrf
                        <label for="message">Comment: </label>
                        <textarea name="message" id="message" cols="80" rows="2" required="required"></textarea>
                        <input type="submit">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    </form>
                @endif
                @foreach ($comments as $comment)
                    <div class="comment flex">
                        <div>
                            <a href="/User/{{$comment['Author']}}">
                                <p>{{$comment['user']['Username']}}</p>
                                <img width="100" src="/Users/{{$comment['Author']}}/{{findpfp("Users/".$comment['Author'])}}" alt="Profile pic">
                            </a>
                        </div>
                        <div>
                            <p>{{$comment['Message']}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
