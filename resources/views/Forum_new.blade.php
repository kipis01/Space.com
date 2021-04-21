<!DOCTYPE html>
<html>
    <head>
        <title>New thread</title>
        <x-resources/>
        <link rel="stylesheet" src="/css/forum-form.css">
    </head>
    <body>
        <x-navbar/>
        <section id="creator">
            <form method="POST" action= "{{action([App\Http\Controllers\ForumController::class, 'store'])}}">
                @csrf
                <!--TODO:Finish this-->
            </form>
        </section>
    </body>
</html>
