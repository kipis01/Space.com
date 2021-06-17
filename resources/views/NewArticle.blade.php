<!DOCTYPE html>
<html>
    <head>
        <title>New article</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/news.css">
        <script>
            var counter = 0;
            $(document).ready(function(){
                $('#add').on('click', add);
                $('#remove').on('click', remove);
                counter = $('#count').val();
            });

            function add(){
                counter++;
                switch($('#type').val()){
                    case 'Text':
                        $('#form').append(
                            '<div id="'+counter+'" class="added">\
                                <textarea name="p'+counter+'"></textarea>\
                            </div>'
                        );
                        break;
                    case 'Link':
                        $('#form').append(
                            '<div id="'+counter+'" class="added">\
                                <label for="a'+counter+'">Link:</label>\
                                <input name="a'+counter+'">\
                                <textarea name="p'+counter+'"></textarea>\
                            </div>'
                        );
                        break;
                    case 'Image':
                        $('#form').append(
                            '<div id="'+counter+'" class="added">\
                                <input type="file" name="f'+counter+'">\
                                <label for="p'+counter+'">Alternative text:</label>\
                                <input name="p'+counter+'">\
                            </div>'
                        );
                        break;
                }
                $('#count').val(counter);
            }

            function remove(){
                if (counter != 0){
                    $('div#'+(counter)).remove();
                    counter--;
                    $('#count').val(counter);
                }
            }
        </script>
    </head>
    <body>
        <x-navbar/>
        <div id="main" class="center">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" id="form" action="{{isset($article)?"/news/edit/$article->id":route('newArticle')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="count" id="count" value="{{isset($xml)?$xml->head->elementc:0}}">
                <input type="submit"><br>
                <label for="main_title">Title</label>
                <input type="text" name="main_title" id="main_title" value="{{isset($article)?$article->Title:''}}"><br>
                @if (isset($xml))
                    <img src="/news_data/{{$article->id}}/{{$xml->head->pic}}" height="200px" alt="Main picture">
                @endif
                <label for="main_pic">Main article image: </label>
                <input type="file" name="main_pic" {{isset($article)?'':'required="required"'}}><br>
                <label for="main_text">Head text:</label>
                <textarea name="main_text" cols="50" rows="10" required="required">{{isset($xml)?$xml->head->text:''}}</textarea>

                @if (isset($xml))
                    <?php
                        for($i = 1, $elem = 'd'.$i; $i <= $xml->head->elementc; $i++, $elem = 'd'.$i){
                            echo '<div id="'.$i.'" class="added">';
                            switch ($xml->xpath("content/$elem/type")[0]){
                                case 'p':
                                    echo '<textarea name="p'.$i.'">'.$xml->xpath("content/$elem")[0].'</textarea>';
                                    break;
                                case 'a':
                                    echo '<label for"a'.$i.'">Link:</label><input name="a'.$i.'" value="'.$xml->xpath("content/$elem/href")[0].'"><textarea name="p'.$i.'">'.$xml->xpath("content/$elem")[0].'</textarea>';
                                    break;
                                case 'img':
                                    echo '<img src="/news_data/'.$article->id.'/'.$xml->xpath("content/$elem")[0].'" width="300px" alt="'.$xml->xpath("content/$elem/alt")[0].'">';
                                    echo '<input type="file" name="f'.$i.'"><label for="p'.$i.'>Alternative text:</label><input name="p'.$i.'">"';
                            }
                            echo '</div>';
                        }
                    ?>
                @endif
            </form>
            <div>
                <select id="type">
                    <option>Text</option>
                    <option>Link</option>
                    <option>Image</option>
                </select>
                <button id="add">Add</button>
                <button id="remove">Remove</button>
            </div>
        </div>
    </body>
</html>
