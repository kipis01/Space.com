<?php include_once '../resources/php/functions.php' ?>
<nav id="navbar">
    <ul>
        <li class="logo"><img src="/img/Logo.png" width="50px" alt="logo"></li>
        <li><a href="/news">{{__('messages.News')}}</a></li>
        <li><a href="/wiki">{{__('messages.Wiki')}}</a></li>
        <li><a href="/forum">{{__('messages.Forum')}}</a></li>
        <li><a href="/lang/en">EN</a></li>
        <li><a href="/lang/lv">LV</a></li>
        @if (isset(Auth::user()->Username))
        <li class="nav-right droppable">
            <a href="/user/{{Auth::user()->id}}">
                {{Auth::user()->Username}}
                <img src="/Users/{{Auth::user()->id}}/{{findpfp('Users/' . Auth::user()->id)}}" alt="PFP" width="30px">
                <span class="dopdown-icon">&#9662;</span>
            </a>
            <ul class="dropdown">
                <li><a href="/user/{{Auth::user()->id}}">{{__('messages.Profile')}}</a></li>
                <li><a href="/settings/{{Auth::user()->id}}">{{__('messages.Settings')}}</a></li>
                <li><a href="/user">{{__('messages.Users')}}</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <!--<a onclick="this.closest('form').submit();" href="#">Sign out</a>
                        <input type="Submit" value="Sign out" style="background-color:black; border:0; color:silver; font-weight:bold; padding:0px; margin:0px;">-->
                        <button style="
                        background: none!important;
                        border: none;
                        padding: 10!important;
                        color:silver;
                        font-weight:bold;
                        cursor: pointer;">Sign Out</button>
                    </form>
                </li>
            </ul>
        </li>
        @else
            <li class="nav-right"><a href="/login">Sign in</a></li>
        @endif
    </ul>
</nav>
<span class="navbar-buffer"></span>
