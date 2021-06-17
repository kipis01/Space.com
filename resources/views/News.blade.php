<!DOCTYPE html>
<html>
    <head>
        <title>News</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/news.css">
    </head>
    <body>
        <x-navbar/>
        <div id="main" class="center">
            <form method="GET" action="{{route('newsSearch')}}">
                <input type="text" name="search" id="search">
                <input type="submit" value="Search">
            </form>
            @if (isset(Auth::user()->role) && (Auth::user()->role == 'Editor' || Auth::user()->role == 'Admin'))
                <p><a href="/news/new">Write a new article!</a></p>
            @endif
            @foreach ($articles as $article)
                <div class="article flex">
                    <div class="img">
                        <img src="/news_data/{{$article['id']}}/{{$pics[$article['id']]}}" alt="Article image">
                    </div>
                    <div class="data center">
                        <div class="center">
                            <h2><a href="/news/{{$article['id']}}">{{$article['Title']}}</a></h2>
                            <h3>Posted at:</h3>
                            <h4>{{explode('T', $article['created_at'])[0]}} {{explode('.', explode('T', $article['created_at'])[1])[0]}}</h4>
                            <h4>Author: {{$article['user']['Username']}}</h4>
                            <h4>Views: {{$article['Views']}}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </body>
</html>
