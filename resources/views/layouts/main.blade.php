<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->    

        <title>TaskManager - @yield('title')</title>
        
        <link rel="stylesheet" href="/css/bootstrap.css"/>
        <link rel="stylesheet" href="/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="/css/style.css"/>
        <link rel="stylesheet" href="/css/signin.css"/>
        <link rel="stylesheet" href="/css/dashboard.css"/>
    </head>
    
    
    
    <body>

        <nav class="navbar navbar-dark bg-inverse navbar-full">
            <a class="navbar-brand" href="/tasks">TaskManager</a>
            <ul class="nav navbar-nav">
                @if(Auth::guest())
                <li class="nav-item"><a class="nav-link">Hello, Guest!</a></li>
                @else
                <li class="nav-item"><a class="nav-link">for {{Auth::user()->name}}</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav pull-xs-right">
                @if(Auth::guest())
                <li class="nav-item @yield('login')">
                    <a class="nav-link" href="/auth/login">Login <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item @yield('register')">
                    <a class="nav-link" href="/auth/register">Register &nbsp; </a>
                </li>
                @else
                <li class="nav-item @yield('logout')">
                    <a class="nav-link" href="/auth/logout">Logout &nbsp; </a>
                </li>
                @endif
            </ul>
        </nav>




        <div class="container-fluid">

            @yield('content')
            
        </div>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="/js/bootstrap.js"></script>
    </body>

</html>
