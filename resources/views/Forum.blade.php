<!DOCTYPE html>
<html>
    <head>
        <title>Forum</title>
        <x-resources/>
        <link rel="stylesheet" href="/css/forum.css">
        <?php include_once '../resources/php/functions.php' ?>
    </head>
    <body>
        <x-navbar/><!-- :message='$message' -->
        <section id="forum-content">
            <h1 class="title center">Space forum</h1>
            <div class="center" id="forumform">
                @if (isset(Auth::user()->id))
                    <form method="POST" onsubmit="{{route('NewForumPost')}}" enctype="multipart/form-data">
                        @csrf
                        <label for="title">Title:</label>
                        <input id="title" name="title" required="required"><br><br>
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required="required"></textarea><br>
                        <label for="file1">1st picture:</label>
                        <input name="file1" type="file" id="file1"><br>
                        <label for="file2">2nd picture:</label>
                        <input name="file2" type="file" id="file2"><br>
                        <label for="file3">3rd picture:</label>
                        <input name="file3" type="file" id="file3"><br><br>
                        <input type="submit">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    </form>
                @endif
            </div>
            @if (count($posts) == 0)
                <h3 class="title center">The forum is empty, be the first to contribute!</h3>
            @endif
            @foreach ($posts as $i)
                <div class="thread">
                    <h3><a href = "/forum/{{$i->id}}">{{$i->Title}}</a></h3>
                    <p>By: {{$i->Username}}</p>
                    <p>Started at: {{$i->created_at}}</p>
                    @if ($i->HasAttachments)
                        <img src="forum_data/{{$i->id}}/{{getFirstAtt("forum_data/$i->id")}}" alt="thread img">
                    @endif
                </div>
            @endforeach
        </section>
    </body>
</html>
