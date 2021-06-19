<!DOCTYPE html>
<html>
    <head>
        <title>Wiki</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/wiki.css">
    </head>
    <body>
        <x-navbar/>
        <div id="main" class="center">
            <h2 class="center">Welcome to space.com wiki!</h2>
            <p><a href="/wiki/new">Create a new article!</a></p>
            <form method="GET" action="{{route('searchWiki')}}">
                <input type="text" name="search" id="search">
                <input type="submit" value="search">
            </form>
            <hr>
            <h4>Most popular articles</h4>
            @foreach ($articles as $article)
                <div class="article center">
                    <img src="/wiki_data/{{$article['id']}}/{{$pics[$article['id']]}}" alt="Main article picture">
                    <h2 class="title"><a href="/wiki/{{$article['id']}}/v{{$article['Version']}}">{{$article['Title']}}</a></h2>
                </div>
            @endforeach
        </div>
    </body>
</html>
