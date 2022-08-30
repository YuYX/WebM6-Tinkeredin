@extends('layouts.app')

@section('content')  

  <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Welcome to My Profile Page</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> 
    
    <div class="offcanvas-body profile-sidebar">    
        <div class="card cardeffect sticky-top " 
            style="background-color:beige;" > 
              
                <img class="rounded card-img-top mb-5" 
                src="/storage/{{ $profile->back_image }}" alt=""> 
                <div class="mx-auto">
                    <img class="rounded-circle card-img-overlay mx-auto" 
                        width="120" height="120"
                        src="/storage/{{ $profile->image }}" alt="">  
                </div> 
                
            <div class="card-body" style="text-align: center">
                <strong>{{$user->name}}</strong><br>
                <div class="pt-3">{{ $profile->description }}</div>
                <div class="pt-3"> 
                    <a href="/profile/edit">Edit profile</a>
                </div>
                <span>You have <strong>{{$numPosts}}</strong> posts</span>
            </div>  
        </div>  
    </div>  
 
    {{-- <div class="api">
        <div class="container">🌞 An OpenWeather API key is needed due to Copyrights issue.
        </div>
      </div> --}}
      {{-- <section class="top-banner">
        <div class="weather-container"> 
          <form>
            <input type="text" placeholder="Search for a city" autofocus>
            <button type="submit">SUBMIT</button>
            <span class="msg"></span>
          </form>
        </div>
      </section> --}} 
      {{-- <section class="ajax-section">
        <div class="weather-container">
          <ul class="cities"></ul>
        </div>
      </section>  --}}
  </div>

  {{-- <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    Button with data-bs-target
  </button> --}}

  <div class="container">  
    <div class="row justify-content-center"> 
        {{-- <div class="col-md-3 profile-sidebar">    
            <div class="card cardeffect sticky-top " 
                style="background-color:beige;" > 
                  
                    <img class="rounded card-img-top mb-5" 
                    src="/storage/{{ $profile->back_image }}" alt=""> 
                    <div class="mx-auto">
                        <img class="rounded-circle card-img-overlay mx-auto" 
                            width="120" height="120"
                            src="/storage/{{ $profile->image }}" alt="">  
                    </div> 
                    
                <div class="card-body" style="text-align: center">
                    <strong>{{$user->name}}</strong><br>
                    <div class="pt-3">{{ $profile->description }}</div>
                    <div class="pt-3"> 
                        <a href="/profile/edit">Edit profile</a>
                    </div>
                    <span>You have <strong>{{$numPosts}}</strong> posts</span>
                </div>  
            </div>  
        </div>  --}}
 
      <div class="col-md-9">   
            <div class="row mb-5">
                <div class="card col-md-1">
                    <img class="rounded-circle mx-auto  profile-image"  
                        width="40" height="40" 
                        data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"
                    src="/storage/{{ $profile->image }}" alt="">   
                </div>
                <div class="card col-md-11">
                    <div class="card-body"> 
                        <a class="nav-link" href="{{ route('post.create')}}">Start a post</a>
                    </div> 
                </div> 
            </div>

            @foreach ($posts as $post) 
            <div class="card mb-3" style="background-color:lightcyan">
                <div class="mb-5 row pt-2">
                    <h5>{{ $post->caption }}</h5>
                    <h6>{{ $post->content }}</h6>

                    <div class="pt-3"> 
                        <a href="{{ route('post.edit', $post->id) }}">Edit</a>
                        <a href="{{ route('post.destroy', $post->id) }}">Delete</a> 
                    </div>

                    <hr class="solid" style="margin-left:20px; width:95%;">
                    <a href="/post/{{$post->id}}">
                        <img src="/storage/{{$post->image}}" class="w-100">
                    </a>
                </div>  
            </div>
            @endforeach
      </div> 
        
      <div class="col-md-2 right-hand-col">
        <div>
            <div class="radio-item">
              <label class="radio-container radio-text">Left
                <input id="offcanvas-start" type="radio" checked="checked" name="radio" 
                onclick="apply_offcanvas_location('offcanvas-start')">
                <span class="checkmark"></span>
              </label>
            </div>
            <div class="radio-item">
              <label class="radio-container radio-text">Right
                <input id="offcanvas-end"  type="radio" name="radio" 
                onclick="apply_offcanvas_location('offcanvas-end')">
                <span class="checkmark"></span>
              </label> 
            </div>  
            <div class="radio-item">
              <label class="radio-container radio-text">Top
                <input id="offcanvas-top"  type="radio" name="radio" 
                onclick="apply_offcanvas_location('offcanvas-top')">
                <span class="checkmark"></span>
              </label>
            </div> 
            <div class="radio-item">
              <label class="radio-container radio-text">Bottom
                <input id="offcanvas-bottom"  type="radio" name="radio" 
                onclick="apply_offcanvas_location('offcanvas-bottom')">
                <span class="checkmark"></span>
              </label>
            </div> 
        </div> 
          
        {{-- <div> --}}
          <div class="weather-container" > 
            <div class="weather-form" style="position: relative;"> 
              <form>
                <input class="city-input" type="text" placeholder="Search for a city" autofocus>
                <button type="submit">SUBMIT</button>
                <span class="msg"></span>
              </form>
            </div>  

            <div class="weather-details" style="position: fixed;">
              <ul class="cities"></ul> 
            </div> 
          </div>  
        {{-- </div>  --}}
      </div>  
    </div>
  </div>
@endsection
