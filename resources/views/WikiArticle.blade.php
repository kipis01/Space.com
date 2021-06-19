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
            <p><a href="/wiki/{{$article->id}}">See previous versions</a>|<a href="/wiki/edit/{{$article->id}}">Edit this article</a></p>
            <h3>{{$article->Title}}</h3>
            <div id="stats">
                <img src="/wiki_data/{{$article->id}}/{{$xml->head->pic}}" alt="{{$article->Title}} main picture">
                @foreach ($xml->content->stats->children() as $i)
                    <div class="center">
                        @if ($i == 'hr')
                            <hr>
                        @else
                            <h5>{{$i->name}}</h5>
                            <p>{{$i->data}}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div id="article">
                @foreach ($xml->content->topics->children() as $topic)
                    @if (!count($topic->title))
                        <p>{{$topic}}</p>
                    @elseif (count($topic->title))
                        <h3>{{$topic->title}}</h3><hr>
                        @foreach ($topic->children() as $sub)
                            @if (count($sub->title))
                                <h5>{{$sub->title}}</h5>
                                <p>{{$sub}}</p>
                            @elseif ($sub->type == 'img')
                                <div class="img">
                                    <img src="/wiki_data/{{$article->id}}/{{$sub}}" alt="{{$sub->alt}}">
                                    <p>{{$sub->desc}}</p>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            <hr>
            <div class="ref">
                @foreach ($xml->content->references->children() as $reference)
                    <span>
                        <p><a href="{{$reference->href}}">{{$reference}}</a></p>
                    </span>
                @endforeach
            </div>
        </div>
    </body>
</html>
