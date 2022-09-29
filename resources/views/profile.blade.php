@extends('layouts.app')

@section('content')  
  <?php 
    $no_post_loaded = 0;
    $no_post = 0; 

    function calcDateTimeDiff_2_Day_Hour_Min($timestamp)
    {
                              $time_diff = floor( (time()-strtotime($timestamp))/60 );
                              $time_diff_in_min = $time_diff;
                              if($time_diff<60){
                                $time_duration = $time_diff."m";
                              }else{
                                $time_diff = floor( $time_diff_in_min/(60) );
                                if($time_diff<24){
                                  $time_duration = $time_diff."h";
                                }else{
                                  $time_diff = floor( $time_diff_in_min/(60*24) );
                                  $time_duration = $time_diff."d";
                                }
                              }   
                              return($time_duration);
    }

  ?>

  <div class="offcanvas offcanvas-start" 
      data-bs-scroll="true" 
      data-bs-backdrop="true"  
      tabindex="-1" 
      id="offcanvasExample" 
      aria-labelledby="offcanvasExampleLabel">
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
                
                <div class="pt-1">{{ $profile->description }}</div>
                <div class="pt-1"> 
                    <a href="/profile/edit">Edit profile</a>
                </div>
                <span>You have <strong>{{$numPosts}}</strong> posts</span> 
                <hr style="width:100%;">
                <div class="row justify-content-md-center">
                  <div class='col col-sm-4'><span >Following: <strong>{{$numFollowers}}</strong></span></div>
                  <div class='col col-sm-4'><span>Followers: <strong>{{$numFollowings}}</strong></span></div>
                </div>
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
                <div class="card profile-image-container col-md-1">
                    <img class="img-fluid rounded-circle mx-auto mt-1 profile-image"  
                        style="height:40px; width:auto; max-width:40px;" {{-- width="40" height="40"   --}}
                        data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"
                    src="/storage/{{ $profile->image }}" alt="">   
                </div>
                <div class="card col-md-11">
                    <div class="card-body"> 
                        <a class="nav-link" href="{{ route('post.create')}}">Wanna Post Something, <span style="font-weight: bold;">{{ $user->name }}</span>?</a>
                    </div> 
                </div> 
            </div>  

            {{-- Only show the first 20 posts. --}}
            {{-- How to implement that it can automatically load the subsequent 10 posts
               once user scrolled to the bottom?  --}}
            
            @if($no_post_loaded<1)
              @foreach ($posts as $post) 
                <?php $no_post = $no_post+1; ?>
                @if($no_post<=20)
                  <?php $no_post_loaded = $no_post_loaded + 1; ?>
                  @if($post->user_id == $user->id)
                  <div class="ind-post-area row mb-3" style="background-color:lightcyan; border-radius:8px;">
                  @else
                  <div class="ind-post-area row mb-3" style="background-color:rgb(200, 255, 255); border-radius:8px;">
                  @endif
                      <div class="mb-1 row pt-2" > 
                          <div class="col-3"> 
                            <img class="rounded-circle" style="height:30px; width:auto; max-width:30px; margin-right:8px; display:inline-block;"  
                              {{-- src="/storage/{{ $profile->image }}"  --}}
                              src="/storage/{{ $post->profile_image }}"
                            ><span class="text-danger">{{ $post->user_name }}</span>
                          </div> 
                          {{-- <div class="col-2 mt-1 text-danger "> {{ $user->name }} </div> --}}
                          {{-- <div class="col-2 mt-1 text-danger "> {{ $post->user_name }} </div> --}}  

                          <div class="col-2 mt-1 ">Created: {{ calcDateTimeDiff_2_Day_Hour_Min($post->created_at) }} </div>
                          {{-- <div class="col-2 mt-1 " >Updated: {{ calcDateTimeDiff_2_Day_Hour_Min($post->updated_at) }} </div>  --}}
                          <hr class="solid" style="margin-left: 10px; width:100%;">
                          <div class="row">
                          @if ($post->image)
                            <div class="col-2">
                              @if ($post->user_id == $user->id)
                              <a href="/post/{{$post->id}}"> 
                                <img class="img-thumbnail img-thumbnail-{{$post->id}} mx-auto mt-2" 
                                  src="/storage/{{$post->image}}" >
                              </a>  
                              @else
                                <img class="img-thumbnail img-thumbnail-{{$post->id}} mx-auto mt-2" 
                                  src="/storage/{{$post->image}}" >
                              @endif
                            </div> 
                            <div  class="col-10"> 
                              {{-- <h5>{{ $post->caption }}</h5> --}}
                              <a style="font-size:18px; text-decoration: none !important;" href="{{ $post->url }}">{{ $post->caption }}</a>
                              <h6>{{ $post->content }}</h6>
                            </div>  
                          @else
                            <div   class="col-12">  
                              <a style="text-decoration: none !important;" href="{{ $post->url }}">{{ $post->caption }}</a> 
                              <h6>{{ $post->content }}</h6>
                            </div>  
                          @endif
                        </div>
                        
                        {{-- <hr class="solid" style="margin-left: 10px; width:100%;"> --}}
                        @if ($post->user_id == $user->id)
                          <div class="pt-3"> 
                              <a class="p-2" href="{{ route('post.edit', $post->id) }}">   
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                <span class="glyphicon glyphicon-user" style="margin-right: 10px">Edit</a>
                              <a href="{{ route('post.destroy', $post->id) }}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span class="glyphicon glyphicon-user" style="margin-right: 10px">Delete</a> 
                          </div> 
                          <hr class="solid" style="margin-left: 10px; width:100%;">
                        @endif
                          <div class="container-fluid row" id="showing-images">
                            @if ($post->images != null)
                              @foreach (json_decode($post->images) as $image)   
                                <img class="post-preview-image image-fluid col-sm-4 col-md-3 mt-2 mb-1"
                                  style="width:20%; height:auto; object-fit: contain;" 
                                  src="storage/{{$image}}"  
                                  alt="{{$post->id}}"
                                  @if ($post->image)
                                    {{-- onclick="postImgOnClick(event)" --}}
                                    onclick="postImageOnClock_Carousel({{$post->images}}, {{$loop->index}})"
                                  @else
                                    onclick="postImgOnClick2(event)"
                                  @endif
                                >  
                              @endforeach 
                            @endif
                          </div> 
                      </div>  
                      <div class="container pb-2 pt-2" style="background-color: rgb(180, 249, 249); border-radius:8px;">
                        <div class="row text-center align-items-center">
                          <div class="col" style="color:gray; font-size:16px;">
                            <i class="fa fa-thumbs-o-up fa-xl" aria-hidden="true" style="color:darkcyan;"></i>
                            <span class="glyphicon glyphicon-user" style="margin-right: 10px">Like
                          </div>
                          <div class="col" style="color:gray; font-size:16px;">
                            <i class="fa fa-commenting-o fa-xl" aria-hidden="true" style="color:darkcyan;"></i>
                            <span class="glyphicon glyphicon-user" style="margin-right: 10px">Comment
                          </div>
                          <div class="col dropdown" style="color:gray; font-size:16px;">
                            <i class="fa fa-share fa-xl" aria-hidden="true" style="color:darkcyan;"></i>
                            {{-- <span class="glyphicon glyphicon-user " style="margin-right: 10px">Share --}}
                              <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                              style="color:gray; font-size:16px;">
                                Share
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="https://www.facebook.com/dialog/share">
                                  <i class="fa fa-xl fa-facebook-official" style="color:blue;" aria-hidden="true"></i>
                                  Share on Facebook
                                </a></li>
                                <li><a class="dropdown-item" href="https://twitter.com/intent/tweet">
                                  <i class="fa fa-xl fa-twitter-square" style="color:cornflowerblue" aria-hidden="true"></i>
                                  Tweet it!
                                </a></li>
                                <li><a class="dropdown-item" href="https://telegram.me/share">
                                  <i class="fa fa-xl fa-telegram" style="color:cornflowerblue" aria-hidden="true"></i>
                                  Share to Telegram
                                </a></li>
                                <li><a class="dropdown-item" href="https://www.linkedin.com/sharing/share-offsite/?url=https://css-tricks.com">
                                  <i class="fa fa-xl fa-linkedin-square" aria-hidden="true"></i>
                                  Share to LinkedIn
                                </a></li>
                                <li><a class="dropdown-item" href="whatsapp://send?text={{ $post->url }}}}">
                                  <i class="fa fa-xl fa-whatsapp" style="color:lightgreen" aria-hidden="true"></i>
                                  Share to WhatsUp
                                </a></li>
                                <li><a class="dropdown-item" href="weixin://dl/moments">
                                  <i class="fa fa-xl fa-weixin" style="color:lightgreen" aria-hidden="true"></i>
                                  Share to WeChat <span style="color:blue">微信</span>
                                </a></li> 
                              </ul>
                          </div>
                        </div>
                      </div> 
                  </div>
                @endif
              @endforeach 
            @endif
      </div>   

      <!-- The Modal -->
      <div id="myModal" class="modal"> 
        <span class="close">&times;</span>
  
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true" data-wrap="false">
         
        </div>        

        {{-- <img class="modal-content" id="img01"> --}}
        {{-- <div id="caption"></div> --}}
      </div>   

      <script> 
          const modal = document.getElementById("myModal");

          function postImgOnClick(e){ 
            var img_class=".img-thumbnail-"+e.target.alt;
            $(img_class).attr("src", e.target.src);
            postImgOnClick2(e); 
          }

          function postImageOnClock_Carousel(imgArray,idx){    
            const outerContainer = document.querySelector('#carouselExampleIndicators'); 

            var divIContainer = document.querySelector('.carousel-indicators');
            if(divIContainer != null) divIContainer.remove();
            divIContainer = document.createElement('div');//('carousel-indicators');
            divIContainer.setAttribute('class', 'carousel-indicators');
            // divIContainer.setAttribute('class', 'carousel-preview'); 

            var divContainer = document.querySelector('.carousel-inner');
            if(divContainer != null) divContainer.remove();
            divContainer = document.createElement('div'); //('carousel-inner');   
            divContainer.setAttribute('class', 'carousel-inner');   
 
            for(let i=0; i<imgArray.length; i++){
              var tmpBtn = document.createElement('button');
              tmpBtn.setAttribute('type', 'button');
              tmpBtn.setAttribute('data-bs-target', '#carouselExampleIndicators');
              tmpBtn.setAttribute('data-bs-slide-to', i);  
              if(i==idx) {
                tmpBtn.setAttribute('class', 'active'); 
                tmpBtn.setAttribute('aria-current', 'true');  
              }
              divIContainer.appendChild(tmpBtn);   

              var divItem = document.createElement('div');
              divItem.setAttribute('class', 'carousel-item');
              if(i==idx) divItem.classList.add('active');
              var tmpImg = document.createElement('img');
              tmpImg.classList.add('modal-content');
              tmpImg.classList.add('d-block');
              tmpImg.classList.add('w-100');   
              tmpImg.setAttribute('src',"/storage/"+imgArray[i]);  
              divItem.appendChild(tmpImg); 
              divContainer.appendChild(divItem);      
              
              var btnSpan;
              var btnPrev = document.querySelector('.carousel-control-prev');
              if(btnPrev != null) btnPrev.remove();
              btnPrev = document.createElement('button'); 
              btnPrev.setAttribute('class','carousel-control-prev'); 
              btnPrev.setAttribute('type','button');
              btnPrev.setAttribute('data-bs-target','#carouselExampleIndicators');
              btnPrev.setAttribute('data-bs-slide','prev');
              btnSpan = document.createElement('span');
              btnSpan.setAttribute('class', 'carousel-control-prev-icon');
              btnSpan.setAttribute('aria-hidden', 'true');
              btnPrev.appendChild(btnSpan);

              var btnNext = document.querySelector('.carousel-control-next');
              if(btnNext != null) btnNext.remove();
              btnNext = document.createElement('button'); 
              btnNext.setAttribute('class','carousel-control-next');
              btnNext.setAttribute('type','button');
              btnNext.setAttribute('data-bs-target','#carouselExampleIndicators');
              btnNext.setAttribute('data-bs-slide','next');
              btnSpan = document.createElement('span');
              btnSpan.setAttribute('class', 'carousel-control-next-icon');
              btnSpan.setAttribute('aria-hidden', 'true'); 
              btnNext.appendChild(btnSpan); 

              outerContainer.appendChild(divIContainer);
              outerContainer.appendChild(divContainer); 
              outerContainer.appendChild(btnPrev);
              outerContainer.appendChild(btnNext);          

            }   
            modal.style.display = "block";   
          }

            // var curModalImg = document.getElementById("img01"); 
          // function postImgOnClick2(e){   
          //   var curModalImg = document.querySelector('.modal-content');
          //   if(curModalImg == null){
          //     curModalImg = document.createElement('img'); 
          //     curModalImg.setAttribute('class','modal-content');
          //   }
          //   curModalImg.src = e.target.src; 
            
          //   var CurCaptionText = document.getElementById("caption");
          //   modal.style.display = "block";   
            
          //   modal.appendChild(curModalImg);
          // }

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
