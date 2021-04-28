<!DOCTYPE html>
<html>
    <head>
        <title>Testing</title>
        <style>
            body{
                background-color: black;
                color:white;
            }
        </style>
    </head>
    <body>
        @if (isset($dump))
            <p><?php print_r($dump) ?></p>
        @else
            <p>Nothing in dump</p>
        @endif
        <hr>
        <p>
            @if (isset(Auth::user()->Username))
                {{Auth::user()->Username}}<br>
                {{Auth::user()->role}}
            @else
                No logon
            @endif
        </p>
    </body>
</html>
