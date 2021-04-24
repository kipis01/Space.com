<?php
function findpfp($dir){
    $files = scandir($dir);
    foreach ($files as $i)
        if (Str::startsWith($i, 'pfp'))
            return $i;
}
?>
<nav id="navbar">
    <ul>
        <li class="logo"><img src="/img/Logo.png" width="50px"></li>
        <li><a href="/news">News</a></li>
        <li><a href="/wiki">Wiki</a></li>
        <li><a href="/forum">Forum</a></li>
        @if (isset(Auth::user()->Username))
        <li class="nav-right droppable">
            <a href="/user/{{Auth::user()->id}}">
                {{Auth::user()->Username}}
                <img src="/Users/{{Auth::user()->id}}/{{findpfp('Users/' . Auth::user()->id)}}" alt="PFP" width="30px">
                <span class="dopdown-icon">&#9662;</span>
            </a>
            <ul class="dropdown">
                <li><a href="/user/{{Auth::user()->id}}">Profile</a></li>
                <li><a href="/settings">Settings</a></li><!--TODO:Add this-->
                <li><a href="/logout">Sign out</a></li>
            </ul>
        </li>
        @else
            <li class="nav-right"><a href="/authenticate">Sign in</a></li>
        @endif
    </ul>
</nav>
<span class="navbar-buffer"></span>