<!DOCTYPE html>
<html>
    <head>
        <title>New Wiki Article</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/wiki.css">
        <script>
            var stat = {{isset($xml)?count($xml->content->stats->children()):0}};
            var topic = {{isset($xml)?count($xml->content->topics->children()):1}}, smalltop = <?php
            if (isset($xml)){
                echo ('[null,null,');
                foreach ($xml->content->topics->children() as $i){
                    if (count($i->title)){
                        echo ((count($i->children())-1).',');
                    }
                }
                echo (']');
            }else{
            echo ('[]');} ?>, ref = {{isset($xml)?count($xml->content->references->children())-1:0}};

            $(document).ready(function () {
                $('#addStat').on('click', addStat);
                $('#remStat').on('click', remStat);
                $('#addTopic').on('click', addTopic);
                $('#remTopic').on('click', remTopic);
                $('#addRefference').on('click', addRef);
                $('#remRefference').on('click', remRef);
                for(let i = 2; i <= topic; i++){
                    $('#addSmallTopic'+i).on('click', addSmallTopic);
                    $('#remSmallTopic'+i).on('click', remSmallTopic);
                }
            });

            function addStat(){
                stat++;
                if ($('#stat').val() == 'Information'){
                    $('#statGroup').append(
                        '<div id="s'+stat+'">\
                            <label for="sname'+stat+'">Name:</label>\
                            <input name="sname'+stat+'">\
                            <label for="sdata'+stat+'">Data:</label>\
                            <input name="sdata'+stat+'">\
                        </div>'
                    );
                }else{
                    $('#statGroup').append(
                        '<div id="s'+stat+'">\
                            <input type="hidden" value="hr" name="shr'+stat+'">\
                            <p>devider</p>\
                        </div>'
                    );
                }
            }

            function remStat(){
                if (stat > 0){
                    $('#s'+stat).remove();
                    stat--;
                }
            }

            function addSmallTopic(e){
                var id = $(e.target).attr('class');
                if(smalltop[id] == null)
                    smalltop[id] = 0;
                smalltop[id]++;
                if ($('#select'+id).val() == 'Topic'){
                    $('#stg'+id).append(
                        '<div id="d'+id+'_'+smalltop[id]+'">\
                            <label for="smallTitle'+id+'_'+smalltop[id]+'">Title: </label>\
                            <input name="smallTitle'+id+'_'+smalltop[id]+'">\
                            <label for="smallText'+id+'_'+smalltop[id]+'">Text: </label>\
                            <textarea name="smallText'+id+'_'+smalltop[id]+'"></textarea>\
                        </div>'
                    );
                }else{
                    $('#stg'+id).append(
                    '<div id="d'+id+'_'+smalltop[id]+'">\
                        <input type="file" name="smallFile'+id+'_'+smalltop[id]+'">\
                        <label for="smallFileTitle'+id+'_'+smalltop[id]+'">File title</label>\
                        <input name="smallFileTitle'+id+'_'+smalltop[id]+'">\
                        <label for="smallFileAlt'+id+'_'+smalltop[id]+'">File alt</label>\
                        <input name="smallFileAlt'+id+'_'+smalltop[id]+'">\
                    </div>'
                    );
                }
                if($("#smallcount"+id) != null){
                    $("#smallcount"+id).val($("#smallcount"+id).val() + 1);
                }
            }

            function remSmallTopic(e){
                var id = $(e.target).attr('class');
                if(smalltop[id] == null || smalltop[id] < 1)
                    return;
                $('#d'+id+'_'+smalltop[id]).remove();
                smalltop[id]--;
                if($("#smallcount"+id) != null){
                    $("#smallcount"+id).val($("#smallcount"+id).val() - 1);
                }
            }

            function addTopic(){
                topic++;
                $('#topicGroup').append(
                    '<div id="tg'+topic+'">\
                        <label for="ttopic'+topic+'">Main title</label>\
                        <input name="ttopic'+topic+'">\
                        <div id="stg'+topic+'"></div>\
                            <select id="select'+topic+'">\
                                <option>Topic</option>\
                                <option>Image</option>\
                            </select>\
                            <button id="addSmallTopic'+topic+'" class="'+topic+'" type="button">Add</button>\
                            <button id="remSmallTopic'+topic+'" class="'+topic+'" type="button">Remove</button>\
                    </div>'
                );
                $('#addSmallTopic'+topic).on('click', addSmallTopic);
                $('#remSmallTopic'+topic).on('click', remSmallTopic);
            }

            function remTopic(){
                if (topic > 0){
                    $('#tg'+topic).remove();
                    topic--;
                }
            }

            function addRef(){
                ref++;
                $('#refGroup').append(
                    '<div id="refd'+ref+'">\
                        <label for="ref'+ref+'">Link: </label>\
                        <input name="ref'+ref+'">\
                        <label for="reft'+ref+'">Text: </label>\
                        <input name="reft'+ref+'">\
                    </div>'
                );
            }

            function remRef(){
                if (ref > 0){
                    $('#refd'+ref).remove();
                    ref--;
                }
            }
        </script>
    </head>
    <body>
        <x-navbar/>
        <div id="main" class="center">
            <form action="{{isset($article)?"/wiki/edit/$article->id":route('newWiki')}}" method="post" enctype="multipart/form-data">
                @csrf
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <input type="submit"><br>
                <label for="title">Title: </label>
                <input type="text" name="title" id="title" value="{{isset($article)?$article->Title:''}}"><br>
                @if (isset($xml))
                    <img src="/wiki_data/{{$article->id}}/{{$xml->head->pic}}" alt="Main pic" width="200px">
                @endif
                <label for="main_pic">Main picture: </label>
                <input type="file" name="main_pic" id="main_pic"><br>
                <textarea name="main_txt" id="main_txt" cols="30" rows="10">{{isset($xml)?$xml->content->topics->d1:''}}</textarea>
                <hr>
                <div>
                    <div id="statGroup">
                        <?php $i = 1; ?>
                        @if (isset($xml))
                        @foreach ($xml->content->stats->children() as $d)
                            <div id="s{{$i}}">
                                @if($d == 'hr')
                                    <input type="hidden" value="hr" name="shr{{$i}}">
                                    <p>devider</p>
                                @else
                                    <label for="sname{{$i}}">{{__('messages.Name')}}:</label>
                                    <input name="sname{{$i}}" value="{{$d->name}}">
                                    <label for="sdata{{$i}}">{{__('messages.Data')}}:</label>
                                    <input name="sdata{{$i}}" value="{{$d->data}}">
                                @endif
                            </div>
                            <?php $i++; ?>
                        @endforeach
                        @endif
                    </div>
                    <select id="stat">
                        <option>Information</option>
                        <option>Devider</option>
                    </select>
                    <button id="addStat" type="button">Add</button>
                    <button id="remStat" type="button">Remove</button>
                </div><hr>
                <div>
                    <div id="topicGroup">
                        <?php $i = 1; ?>
                        @if (isset($xml))
                        @foreach ($xml->content->topics->children() as $topic)
                            <div id="tg{{$i}}">
                                @if(isset($topic->title))
                                <label for="ttopic{{$i}}">{{__('messages.Main title')}}Main title</label>
                                <input name="ttopic{{$i}}" value="{{$topic->title}}">
                                <?php $k = 1; ?>
                                @foreach ($topic->children() as $subtopic)
                                    @if (count($subtopic->title))
                                        <div id="d{{$i}}_{{$k}}">
                                            <label for="smallTitle{{$i}}_{{$k}}">Title: </label>
                                            <input name="smallTitle{{$i}}_{{$k}}" value="{{$subtopic->title}}">
                                            <label for="smallText{{$i}}_{{$k}}">Text: </label>
                                            <textarea name="smallText{{$i}}_{{$k}}">{{$subtopic}}</textarea>
                                        </div>
                                        <?php $k++ ?>
                                    @elseif (count($subtopic->type))
                                        <div id="d{{$i}}_{{$k}}">
                                            <img src="/wiki_data/{{$article->id}}/{{$subtopic}}" alt="{{$subtopic->alt}}" width="200px">
                                            <input type="file" name="smallFile{{$i}}_{{$k}}">
                                            <label for="smallFileTitle{{$i}}_{{$k}}">{{__('messages.File title')}}</label>
                                            <input name="smallFileTitle{{$i}}_{{$k}}" value="{{$subtopic->desc}}">
                                            <label for="smallFileAlt{{$i}}_{{$k}}">{{__('messages.File alt')}}</label>
                                            <input name="smallFileAlt{{$i}}_{{$k}}" value="{{$subtopic->alt}}">
                                        </div>
                                        <?php $k++ ?>
                                    @endif
                                @endforeach
                                    <input type="hidden" name="smallcount{{$i}}" id="smallcount{{$i}}" value="{{$k-1}}">
                                    <select id="select{{$i}}">
                                        <option>Topic</option>
                                        <option>Image</option>
                                    </select>
                                    <button id="addSmallTopic{{$i}}" class="{{$i}}" type="button">Add</button>
                                    <button id="remSmallTopic{{$i}}" class="{{$i}}" type="button">Remove</button>
                                @endif
                            </div>
                            <?php $i++; ?>
                        @endforeach
                        @endif
                    </div>
                    <button id="addTopic" type="button">Add a topic</button>
                    <button id="remTopic" type="button">Remove a topic</button>
                </div><hr>
                <div>
                    <div id="refGroup">
                        @if (isset($xml))
                            <?php $i = 0; ?>
                            @foreach ($xml->content->references->children() as $reference)
                                <div id="refd{{$i}}">
                                    <label for="ref{{$i}}">{{__('messages.Link')}}: </label>
                                    <input name="ref{{$i}}" value="{{$reference->href}}">
                                    <label for="reft{{$i}}">{{__('messages.Text')}}: </label>
                                    <input name="reft{{$i}}" value="{{$reference}}">
                                </div>
                                <?php $i++; ?>
                            @endforeach
                        @endif
                    </div>
                    <button id="addRefference" type="button">{{__('messages.Add a reference')}}</button>
                    <button id="remRefference" type="button">{{__('messages.Remove a reference')}}</button>
                </div>
            </form>
        </div>
    </body>
</html>
