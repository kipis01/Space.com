<!DOCTYPE html>
<html>
    <head>
        <title>{{$article->Title}}</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/wiki.css">
    </head>
    <body>
        <x-navbar/>
        <div id="main" class="center">
            @for ($i = $article->Version; $i > 0; $i--)
            <h3>Version {{$i}}, poster: <?php foreach ($users as $user) {
                if($user["Version"] == $i)
                    echo $user['user']['Username'];
            } ?></h3>
                <iframe src="/wiki/{{$article->id}}/v{{$i}}" frameborder="1"></iframe>
            @endfor
        </div>
    </body>
</html>
