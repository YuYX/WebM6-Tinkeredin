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
 
      <div class="col-md-1 left-hand-col">
        
      </div>

      <div class="col-md-8">   
            <div class="row mb-5">
                <div class="card col-md-1">
                    <img class="rounded-circle mx-auto mt-1 profile-image"  
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
            <div class="row mb-3" style="background-color:lightcyan; ">
                <div class="mb-1 row pt-2" >
                    <div class="col-1" style="display:block;">
                      <img class="rounded-circle mx-auto" width="24" height="24"
                        src="/storage/{{ $profile->image }}"> 
                    </div>
                    <div class="col-2 mt-1 text-danger "> {{ $user->name }} </div>
                    <div class="col-4 mt-1 ">Created: {{ $post->created_at }} </div>
                    <div class="col-4 mt-1 " >Updated: {{ $post->updated_at }} </div>
                    <hr class="solid mt-1" style="margin-left: 10px; width:100%;">
                    <div class="row">
                    @if ($post->image)
                      <div class="col-2">
                        <a href="/post/{{$post->id}}"> 
                          <img class="img-thumbnail img-thumbnail-{{$post->id}} mx-auto mt-2" 
                            src="/storage/{{$post->image}}" >
                        </a>  
                      </div> 
                      <div  class="col-10"> 
                        {{-- <h5>{{ $post->caption }}</h5> --}}
                        <a style="font-size:18px; text-decoration: none !important;" href="{{ $post->url }}">{{ $post->caption }}</a>
                        <h6>{{ $post->content }}</h6>
                      </div>  
                    @else
                      <div   class="col-12"> 
                        {{-- <h5>{{ $post->caption }}</h5> --}}
                        <a style="text-decoration: none !important;" href="{{ $post->url }}">{{ $post->caption }}</a>
                        <h6>{{ $post->content }}</h6>
                      </div>  
                    @endif
                  </div>
                  
                  {{-- <hr class="solid" style="margin-left:20px; width:95%;"> --}}
                    <div class="pt-3"> 
                        <a class="p-2" href="{{ route('post.edit', $post->id) }}">Edit</a>
                        <a href="{{ route('post.destroy', $post->id) }}">Delete</a> 
                    </div> 
                    <div class="container-fluid row" id="showing-images">
                        @foreach (json_decode($post->images) as $image)   
                          <img class="image-fluid col-sm-4 col-md-3 mt-2 mb-1"
                            style="width:20%; height:auto;" 
                            src="storage/{{$image}}"  
                            alt="{{$post->id}}"
                            @if ($post->image)
                            onclick="postImgOnClick(event)"
                            @else
                            onclick="postImgOnClick2(event)"
                            @endif
                          >  
                        @endforeach 
                    </div> 
                </div>  
            </div>
            @endforeach
      </div> 

      <!-- The Modal -->
      <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
      </div>  

      <script> 
          const modal = document.getElementById("myModal");

          function postImgOnClick(e){ 
            var img_class=".img-thumbnail-"+e.target.alt;
            $(img_class).attr("src", e.target.src);
            postImgOnClick2(e);
 
            // var curModalImg = document.getElementById("img01"); 
            // var CurCaptionText = document.getElementById("caption");
            // modal.style.display = "block";   
            // curModalImg.src = e.target.src; 
          }

          function postImgOnClick2(e){  
            // var img_class=".img-thumbnail-"+e.target.alt;
            // $(img_class).attr("src", e.target.src);
 
            var curModalImg = document.getElementById("img01"); 
            var CurCaptionText = document.getElementById("caption");
            modal.style.display = "block";   
            curModalImg.src = e.target.src; 
          }

          // Get the <span> element that closes the modal
          var span = document.getElementsByClassName("close")[0];

          //When the user clicks on <span> (x), close the modal
          span.onclick = function() { 
            modal.style.display = "none";
          }
      </script>
        
      <div class="col-md-3 right-hand-col">
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
          <div class="weather-container"  style="position: fixed;"> 
            <div class="weather-form" style="position:sticky;"> 
              <form>
                <input class="city-input" type="text" placeholder="Search for a city" autofocus>
                <button type="submit">SUBMIT</button>
                <span class="msg"></span>
              </form>
            </div>  

            <div class="weather-details" style="position: sticky;">
              <ul class="cities"></ul> 
            </div>  

            <div class="scroll-location" style="position: sticky;">
              <label>Location:</label>
              <label id="x-location">X</label>  
            </div>

          </div>  
        {{-- </div>  --}}
      </div>  
    </div>  
  </div>
@endsection
