<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
                crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/animejs@3.0.1/lib/anime.min.js"></script>

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
            html {line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        {{-- <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style> --}} 
        
        <title>YUYONGXUE-Eureka!</title>
        {{-- <link rel="icon" href="{{ url('images/archimedes.webp') }}">  --}}
        <link rel="icon" href="{{ url('images/YUYX_S.jpg') }}"> 
     
         <!-- Scripts -->
         @vite(['resources/sass/app.scss', 'resources/js/app.js'])
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
         
         <script type="text/javascript" src="{{ asset('js/welcome.js')}}"></script>   
    </head> 

    {{-- <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
                crossorigin="anonymous"></script>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <link
              rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />
     
        <meta name="csrf-token" content="{{ csrf_token() }}">
     
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet"> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>    
     
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
     
        <title>{{ "Eureka!" }}</title> 
    
        <link rel="icon" href="{{ url('images/archimedes.webp') }}">
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <script src="https://kit.fontawesome.com/84806e9d1b.js" crossorigin="anonymous"></script>
    
        <!-- Google Fonts --> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato&family=Open+Sans:wght@500;600&family=Poppins&family=Roboto:wght@400;500&display=swap" 
                rel="stylesheet">
         
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 
    
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" 
                crossorigin="anonymous"></script>  
    
        
        <!-- css file -->
        <link rel="stylesheet" type="text/css" href="{{ 'css/app.css' }}"> 
        <link rel="stylesheet" type="text/css" href="{{ 'css/emojis.css' }}"> 
        <link rel="stylesheet" type="text/css" href="{{ 'css/weather.css' }}">
        <link rel="stylesheet" type="text/css" href="{{ 'css/radio.css' }}"> 
        <link rel="stylesheet" type="text/css" href="{{ 'css/modal.css' }}"> 
        <link rel="stylesheet" type="text/css" href="{{ 'css/profile.css' }}"> 
    
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        
        <script type="text/javascript" src="{{ asset('js/profile.js')}}"></script> 
        
    </head> --}}

    <body class="antialiased"> 
        <div class="relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 ">
            <div class="fixed px-6 py-4 sm:block"> 
                {{-- <img src="/images/archimedes.webp" style="width: 30px;border-radius:18px;"> --}}
                <img src="/images/YUYX_S.jpg" style="width: 30px;border-radius:18px;">
                <label style="color:rgb(231, 72, 228); font-size: 30px;" > 
                    Eureka!
                </label><br>
                <label class="one-line-text animate__animated animate__animated"
                    style="color:rgb(40, 7, 161); font-size: 18px;">
                    A place to share anything interesting.
                </label>
            </div>
            @if (Route::has('login'))
                <div class=" fixed top-0 right-0 px-6 py-8 sm:block">  
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif              
            
            <div class="max-w-6xl mx-auto mt-8 sm:px-6 lg:px-8"> 
                {{-- <h1>Eureka!</h1> --}}
                <div class="mt-8 overflow-hidden "> 
                    <canvas class="fireworks " style="background-color:#e2e8f0"></canvas>
                </div>
                
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">  
                    <svg id="elnxPkeo3yD1" 
                        xmlns="http://www.w3.org/2000/svg" class="title"
                        xmlns:xlink="http://www.w3.org/1999/xlink" 
                        viewBox="0 0 651 102" 
                        shape-rendering="geometricPrecision" 
                        text-rendering="geometricPrecision">
                        <text dx="0" dy="0" font-family="&quot;elnxPkeo3yD1:::Lato&quot;" font-size="32" font-weight="200" transform="translate(32 88.927486)" fill="#20809a" stroke-width="0"><tspan y="0" font-weight="300" stroke-width="0"><![CDATA[
                        Eureka! Migrating from Heroku to AWS...
                        ]]></tspan></text>
                        {{-- <style><![CDATA[
                        @font-face {font-family: 'elnxPkeo3yD1:::Lato';font-style: normal;font-weight: 700;src: url(data:font/ttf;charset=utf-8;base64,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) format('truetype');}
                        ]]></style> --}}
                        </svg>
                </div> 

                {{-- <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold  sub-title"><a href="https://laravel.com/docs" class="underline text-gray-900 dark:text-white">Documentation</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm sub-content">
                                    Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold  sub-title"><a href="https://laracasts.com" class="underline text-gray-900 dark:text-white">Laracasts</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm sub-content">
                                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold sub-title"><a href="https://laravel-news.com/" class="underline text-gray-900 dark:text-white ">Laravel News</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm sub-content">
                                    Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white  sub-title">Vibrant Ecosystem</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm sub-content">
                                    Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="underline">Forge</a>, <a href="https://vapor.laravel.com" class="underline">Vapor</a>, <a href="https://nova.laravel.com" class="underline">Nova</a>, and <a href="https://envoyer.io" class="underline">Envoyer</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing" class="underline">Cashier</a>, <a href="https://laravel.com/docs/dusk" class="underline">Dusk</a>, <a href="https://laravel.com/docs/broadcasting" class="underline">Echo</a>, <a href="https://laravel.com/docs/horizon" class="underline">Horizon</a>, <a href="https://laravel.com/docs/sanctum" class="underline">Sanctum</a>, <a href="https://laravel.com/docs/telescope" class="underline">Telescope</a>, and more.
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center text-sm  sm:text-left">
                        <div class="flex items-center">
                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 footer-icon">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>

                            <a href="https://laravel.bigcartel.com" class="ml-1 underline" >
                                Shop
                            </a>

                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 footer-icon">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>

                            <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                                Sponsor
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div> --}}
                
            </div>
        </div>


        <script>
            
$(function(){ 
    animeJS_effect(); 

    animated_effect_on_component('.title', "animate__fadeInLeft animate__slower animate__infinite")
    animated_effect_on_component(".underline","animate__backInDown animate__slower");
    animated_effect_on_component(".sub-title","animate__heartBeat animate__slower animate__infinite");
 
    //footer-icon text-gray-400
    delay_animated_effect().then(after_delay_animated_effect).then(final_animated_effect);
}); 

function delay_animated_effect() {
    return new Promise(function(resolve, reject) { 
        setTimeout(function(){
            animated_effect_on_component(".footer-icon", "animate__backInUp  animate__slower");
            resolve("Promise worked!");
            reject("Promise missed.");
        }, 5000); 
    });
 }

 function after_delay_animated_effect(){ 
    // alert("After");
    add_remove_class_to_component(".sub-content", "animate__heartBeat", "add");   
 }
 
 function final_animated_effect(){  
    // alert("Final");
    add_remove_class_to_component(".sub-title", "animate__infinite", "remove");   
 }

function animated_effect_on_component(component, effects){ 
    $(component).addClass("animate__animated " + effects);
}

function add_remove_class_to_component(component, class_name, is_add_or_remove){ 
    if(is_add_or_remove == "add"){
        $(component).addClass(class_name);
    }else if (is_add_or_remove == "remove"){
        $(component).removeClass(class_name);
    }
}

function animeJS_effect()
{
    window.human = false;

    var canvasEl = document.querySelector('.fireworks');
    var ctx = canvasEl.getContext('2d');  
    var numberOfParticules = 50;
    var pointerX = 0;
    var pointerY = 0;
    var tap = ('ontouchstart' in window || navigator.msMaxTouchPoints) ? 'touchstart' : 'mousemove';
    var colors = ['#FF1461', '#18FF92', '#5A87FF', '#FBF38C'];

    
    function setCanvasSize() { 
        canvasEl.width = window.innerWidth;
        canvasEl.height = window.innerHeight/2; 
        canvasEl.style.width = window.innerWidth + 'px';
        canvasEl.style.height = window.innerHeight/2 + 'px';
       // canvasEl.getContext('2d').scale(2, 2);
    }

    function updateCoords(e) {
        pointerX = e.clientX || e.touches[0].clientX;
        pointerY = e.clientY || e.touches[0].clientY; 
    }

    function setParticuleDirection(p) {
        var angle = anime.random(0, 360) * Math.PI / 180;
        var value = anime.random(50, 180);
        var radius = [-1, 1][anime.random(0, 1)] * value;
        return {
            x: p.x + radius * Math.cos(angle),
            y: p.y + radius * Math.sin(angle)
        }
    }

    function createParticule(x,y) {
        var p = {};
        p.x = x;
        p.y = y;
        p.color = colors[anime.random(0, colors.length - 1)];
        p.radius = anime.random(16, 32);
        p.endPos = setParticuleDirection(p);
        p.draw = function() {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, 2 * Math.PI, true);
            ctx.fillStyle = p.color;
            ctx.fill();
        }
        return p;
    }

    function createCircle(x,y) {
        var p = {};
        p.x = x;
        p.y = y;
        p.color = '#FFF';
        p.radius = 0.1;
        p.alpha = .5;
        p.lineWidth = 6;
        p.draw = function() {
            ctx.globalAlpha = p.alpha;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, 2 * Math.PI, true);
            ctx.lineWidth = p.lineWidth;
            ctx.strokeStyle = p.color;
            ctx.stroke();
            ctx.globalAlpha = 1;
        }
        return p;
    }

    function renderParticule(anim) {
        for (var i = 0; i < anim.animatables.length; i++) {
            anim.animatables[i].target.draw();
        }
    }

    function animateParticules(x, y) {
        var circle = createCircle(x, y);
        var particules = [];
        for (var i = 0; i < numberOfParticules; i++) {
            particules.push(createParticule(x, y));
        }
        anime.timeline()
        .add({
            targets: particules,
            x: function(p) { return p.endPos.x; },
            y: function(p) { return p.endPos.y; },
            radius: 0.1,
            duration: anime.random(1200, 1800),
            easing: 'easeOutExpo',
            update: renderParticule
        })
        .add({
            targets: circle,
            radius: anime.random(80, 160),
            lineWidth: 0,
            alpha: {
                value: 0,
                easing: 'linear',
                duration: anime.random(600, 800),  
            },
            duration: anime.random(1200, 1800),
            easing: 'easeOutExpo',
            update: renderParticule,
            offset: 0
        });
    }

    var render = anime({
        duration: Infinity,
        update: function() {
            ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);
        }
    });

    document.addEventListener(tap, function(e) {
        window.human = true;
        render.play();
        updateCoords(e);
        animateParticules(pointerX, pointerY);
    }, false);

    var centerX = window.innerWidth;
    var centerY = window.innerHeight * 5;

    function autoClick() {
        if (window.human) return;
        animateParticules(
            anime.random(centerX-50, centerX+50), 
            anime.random(centerY-50, centerY+50)
        );
        anime({duration: 200}).finished.then(autoClick);
    } 

    autoClick();
    setCanvasSize();
    window.addEventListener('resize', setCanvasSize, false);   
}
 
        </script>

    </body>
</html>
