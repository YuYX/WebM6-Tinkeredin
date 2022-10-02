<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
            crossorigin="anonymous"></script>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS only -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" 
          crossorigin="anonymous">  --}}

    <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
  
    <!-- css file -->
    <link rel="stylesheet" type="text/css" href="{{'resources/css/app.css'}}"> 
    <link rel="stylesheet" type="text/css" href="{{ 'css/weather.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ 'css/radio.css' }}"> 
    <link rel="stylesheet" type="text/css" href="{{ 'css/modal.css' }}"> 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- !!!Following 3 libraries make Dropdown working again. --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>    

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ "Eureka!" }}</title> 

    <link rel="icon" href="{{ url('images/archimedes.webp') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/84806e9d1b.js" crossorigin="anonymous"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" 
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" 
            crossorigin="anonymous"></script> --}}

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" 
            crossorigin="anonymous"></script>  

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    
    <script type="text/javascript" src="{{ asset('js/profile.js')}}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/weather.js')}}"></script> --}}
    
</head>

<body>    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" 
            style="display:flex; background-color: #d8e7f2;"> 
            
            <div class="container"> 
                <img src="/images/archimedes.webp" style="width: 30px;border-radius:18px;">
                <a style="color:rgb(231, 72, 228); font-size: 30px;" 
                    class="navbar-brand animate__animated animate__rotateInDownLeft animate__slower animate__repeat-3"   
                    href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }}  --}} 
                    Eureka!
                </a> 

                <label class="one-line-text"
                    style="color:rgb(40, 7, 161); font-size: 18px;">
                    A place to share anything interesting.
                </label> 
                 
                @auth
                <form class="mx-5 user-search-form" 
                        action="{{ route('search', ['search_for'=>'user-search']) }}" method="GET">
                    @csrf
                    <input class="user-search" name="user-search" type="text" autofocus
                        style="background-color: rgba(19, 243, 243, 0.849); border-radius:4px;"
                        placeholder="Search for an user" aria-label="Search">
                    <button class="btn btn-outline-success mx-auto" 
                        type="submit">Search
                    </button> 
                </form>
                @endauth

                <button class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" 
                        aria-expanded="false" 
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> 

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    {{-- <ul class="navbar-nav me-auto">
                        
                    </ul> --}}

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else 
                            {{-- <li class="nav-item">
                                <a class="nav-link" 
                                href="{{ route('post.create')}}">Create post</a>
                            </li>    --}}
                            
                            {{-- @if(isset($post))
                            <li class="nav-item">
                                <a class="nav-link" 
                                href="{{ route('post.edit', $post)}}">Edit post</a>
                            </li>  
                            @endif   --}}

                            {{-- <li class="nav-item">
                                <a class="nav-link" 
                                href="">Delete post</a>
                            </li>  --}}
                            
                            <li class="nav-item">
                                <a class="nav-link" 
                                href="{{ '/profile' }}">Home</a>
                            </li> 

                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li> --}}

                            {{-- Somehow the dropdown is not working? --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle"  
                                    href="#" role="button" 
                                    data-bs-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false" 
                                    v-pre>
                                    <span style="color:blue;font-weight:bold;">{{ Auth::user()->name }}</span>
                                </a> 

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div> 
</body>
</html>
