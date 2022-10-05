@extends('layouts.app')

@section('content')  
  @php 
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

    function likedByPostOwner($likes, $post_id, $post_user_id) {
      foreach($likes as $like){
        if($like->like == "like"){
          if($like->like_post_id == $post_id &&
             $like->like_user_id == $post_user_id ){
            return true; 
      }}}
      return false;
    }
 
    function breakdownLikeReview($likes, $post_id){ 
      $like_count = 0;
      $love_count = 0;
      $wow_count = 0;
      $sad_count = 0;
      $angry_count = 0;
      foreach($likes as $like){
        if($like->like_post_id == $post_id){
          switch($like->like){
            case "like":
                  $like_count++;
                  break;
            case "love":
                  $love_count++;
                  break;
            case "wow":
                  $wow_count++;
                  break;
            case "sad":
                  $sad_count++;
                  break;
            case "angry": 
                  $angry_count++;
                  break;
          } 
        }
      }
      
      return [
        'like' => $like_count,
        'love' => $love_count,
        'wow' => $wow_count,
        'sad' => $sad_count,
        'angry' => $angry_count,
        'total' =>($like_count+$love_count+$wow_count+$sad_count+$angry_count),
      ];
    }
  @endphp

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
                  {{-- <div class='col col-sm-4'><span >Following: <strong>{{$numFollowers}}</strong></span></div> --}}
                  {{-- <div class='col col-sm-4'><span>Followers: <strong>{{$numFollowings}}</strong></span></div> --}} 
                  <div class='col col-sm-4 dropdown-center dropup'> 
                      <span >Following: </span>
                      <button class="btn dropdown-no-of-following" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{$users_i_follow->count()}}</button> 
                      <ul class="dropdown-menu dropdown-menu-dark dropdown-followings">
                        @foreach($users_i_follow as $user_i_follow)
                        <li><a class="dropdown-item" href="#">{{$user_i_follow->name}}</a></li>
                        @endforeach 
                      </ul> 
                  </div> 

                  <div class='col col-sm-4 dropdown-center dropup'>
                    <span>Followers: </strong></span>
                    <button class="btn dropdown-no-of-follower" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{$users_follow_me->count()}}</button> 
                      <ul class="dropdown-menu dropdown-menu-dark dropdown-followers ">
                        @foreach($users_follow_me as $user_follow_me)
                        <li><a class="dropdown-item" href="#">{{$user_follow_me->name}}</a></li>
                        @endforeach 
                      </ul> 
                  </div>
                </div>
            </div>  
        </div>  
    </div>   
  </div> 

  <div class="container-xl">  
    <div class="row justify-content-center">   
      <div class="col-md-2 left-hand-col" style="background-color:white;">
        <div class="mt-5">
          <img class="rounded-circle" style="height:30px; width:auto; max-width:30px; margin-right:8px; display:inline-block;"  
               src="/storage/{{ $profile->image }}"  
          ><span class="text-danger">{{  $user->name }}</span>
        </div> 
        
        <hr class="solid my-1" style="width:100%;">

        <div class="mt-4 row">
          <div class="col-md-2 ps-0">
            {{-- <ion-icon class="mt-1" name="people-sharp" style="font-size:24px; color:rgb(24, 183, 236)"></ion-icon> --}}
            <i class="fa-solid fa-user-group mt-2" 
              style="font-size:18px; color:rgb(24, 183, 236)"></i>
          </div>
          <div class="col-md-10 ps-0">
            {{-- <button type="button" class="btn btn-sm " style="color:black; font-size:14px;">My Followings</button> --}}
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.search_following') }}">My Followings
              <span class="badge rounded-pill bg-info">
                {{ $users_i_follow->count() }}
              </span>
            </a>
          </div>
        </div>
        
        <div class="mt-2 row">
          <div class="col-md-2 ps-0">
            <ion-icon class="mt-1" name="person-add-sharp" style="font-size:24px; color:rgb(24, 183, 236);"></ion-icon>
            {{-- <i class="fa-solid fa-user-plus"></i> --}}
          </div>
          <div class="col-md-10 ps-0">
            {{-- <button type="button" class="btn btn-sm " style="color:black; font-size:14px;">Requests Sent</button> --}}
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.request_sent') }}">Requests Sent
              <span class="badge rounded-pill bg-info ">
                {{ $users_request_sent->count() }}
              </span>
            </a>
          </div>
        </div>  
        
        <div class="mt-2 row">
          <div class="col-md-2 ps-0">
            <ion-icon class="mt-1" name="people-sharp" style="font-size:24px; color:blue;"></ion-icon>
          </div>
          <div class="col-md-10  ps-0">
            {{-- <button type="button" class="btn btn-sm " style="color:black; font-size:14px;">My Followers</button> --}}
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.search_follower') }}">My Followers
              <span class="badge rounded-pill bg-info">
                {{ $users_follow_me->count() }}
              </span>
            </a>
          </div>
        </div> 
        
        <div class="mt-2 row">
          <div class="col-md-2 ps-0">
            <ion-icon class="mt-1" name="person-add-sharp" style="font-size:24px; color:blue;"></ion-icon>
          </div>
          <div class="col-md-10 ps-0" >
            {{-- <button type="button" class="btn btn-sm " style="color:black; font-size:14px;">Friends Requests</button> --}}
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.request_received') }}">Requests Received
              <span class="badge rounded-pill bg-danger">
                {{ $users_request_received->count() }}
              </span>
            </a>
          </div>
        </div> 
         
      </div>

      <div class="col-md-8"  style="background-color:whitesmoke">   
            <div class="row mb-5">
                <div class="card profile-image-container col-md-1" 
                    style="background-image:url('/storage/{{ $profile->back_image }}'); 
                           border-style:none; border-radius: 10px;
                           background-size:cover;">
                    <img class="img-fluid rounded-circle mx-auto mt-1 profile-image"  
                        style="height:40px; width:auto; max-width:40px; 
                              --animate-duration: 2s; "  
                        data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"
                      src="/storage/{{ $profile->image }}" alt="">   
                </div>
                <div class="card col-md-11"  
                    style="background-color: rgb(250, 250, 246); border-radius:10px;">
                    <div class="card-body"> 
                        <a class="post-input-prompt nav-link animate__animated animate__bounceInRight " 
                          onmouseover="sayHi()"
                          onmouseout="sayBye()"
                          href="{{ route('post.create')}}">Wanna Post Something, 
                          <span style="font-weight: bold;">{{ $user->name }}</span>?</a>
                    </div> 
                </div> 
            </div>   

            <div class="mt-0">
              <audio controls id="back_music" style="display:inline-block; height: 16px;"> 
                <source src="{{ url('music/avamaxmaybeurdproblem.mp3') }}" type="audio/mpeg">
                Your browser does not support the audio element.
              </audio>

              <a >Corporate Video</a>
              <i class="play-stop-icon fa-solid fa-circle-play fa-lg" 
                onclick="onClickCorpVideo()"
                style="color:cornflowerblue;"></i>
              <video class="corporate-video-clip pt-0 mt-0" width="640" height="480" controls  autoplay loop muted 
                style="display:none;"
              > 
                <source src="{{ url('video/ATOMDisplay.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>

              <script>
                var audio = document.getElementById("back_music");
                audio.volume = 0.1;

                function onClickCorpVideo(){ 
                  if($('.play-stop-icon').hasClass('fa-circle-play')){
                    $('.corporate-video-clip').css('display','block'); 
                    $('.play-stop-icon').removeClass('fa-circle-play');
                    $('.play-stop-icon').addClass('fa-pause');
                  }else{
                    $('.corporate-video-clip').css('display','none'); 
                    $('.play-stop-icon').removeClass('fa-pause');
                    $('.play-stop-icon').addClass('fa-circle-play');
                  } 
                };

              </script>
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
                  <div class="ind-post-area row mb-3" style="background-color:rgb(240, 255, 255); border-radius:8px;">
                  @else
                  <div class="ind-post-area row mb-3" style="background-color:rgb(224, 255, 255); border-radius:8px;">
                  @endif
                      <div class="mb-1 row ms-2 mt-2 me-0 pe-0" > 
                          <div class="col-4"> 
                            <img class="rounded-circle" style="height:30px; width:auto; max-width:30px; margin-right:8px; display:inline-block;"  
                              src="/storage/{{ $post->profile_image }}"
                            ><span class="text-danger">{{ $post->user_name }}</span>
                          </div>  

                          <div class="col-2 mt-1 ">Posted: {{ calcDateTimeDiff_2_Day_Hour_Min($post->created_at) }} </div>
                          {{-- <div class="col-2 mt-1 " >Updated: {{ calcDateTimeDiff_2_Day_Hour_Min($post->updated_at) }} </div>  --}}
                          <div class="col-5"></div>
                          <div class="col-1 pe-0 me-0"> 
                            <div class="dropdown-center">
                              <button class="btn " type="button" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-lg fa-ellipsis-h" aria-hidden="true"></i>
                              </button>
                              <ul class="dropdown-menu ">
                                @if ($post->user_id == $user->id)
                                  <li><a class="dropdown-item" 
                                        href="{{ route('post.edit', $post->id) }}">Edit This Post</a></li>
                                  <li><a class="dropdown-item" 
                                        href="{{ route('post.destroy', $post->id) }}">Delete This Post</a></li> 
                                @else
                                <li><a class="dropdown-item" 
                                      href="#">Hide This Post</a></li>
                                <li><a class="dropdown-item" 
                                      href="#">Report This Post</a></li> 
                                @endif
                              </ul>
                            </div> 
                          </div>

                          <hr class="solid" style="width:97%;">
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
                              @if(strstr($post->url,'<iframe') && strstr($post->url,'</iframe>'))
                              <a class="post-title">{{ $post->caption }}</a>
                              {!! $post->url !!}
                              @elseif(strstr($post->url, "www.youtube.com") && strstr($post->url, "embed"))
                                <a class="post-title">{{ $post->caption }}</a> 
                                  <iframe width="640" height="360" src={{$post->url}}>
                                  </iframe>
                              @else
                                <a class="post-title" 
                                   href="{{ $post->url }}">{{ $post->caption }}</a>
                              @endif 
                              <div class="post-content">{{ $post->content }} 
                              </div>
                            </div>  
                          @else
                            <div class="col-12">  
                              <a style="text-decoration: none !important;" 
                                href="{{ $post->url }}">{{ $post->caption }}</a> 
                              <div class="post-content">{{ $post->content }}</div>
                            </div>  
                          @endif
                        </div>
                        
                        {{-- <hr class="solid" style="margin-left: 10px; width:100%;"> --}}
                        @if ($post->user_id == $user->id)
                          {{-- Replaced by 3-dot menu  }}
                          {{-- <div class="pt-3"> 
                              <a class="p-2" href="{{ route('post.edit', $post->id) }}">   
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                <span class="glyphicon glyphicon-user" style="margin-right: 10px">Edit</a>
                              <a href="{{ route('post.destroy', $post->id) }}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span class="glyphicon glyphicon-user" style="margin-right: 10px">Delete</a> 
                          </div>  --}}
                          {{-- <hr class="solid" style="margin-left: 10px; width:100%;"> --}}
                        @endif
                          <hr class="solid" style="width:97%;">
                          <div class="container-fluid row" id="showing-images">
                            @if ($post->images != null)
                              @foreach (json_decode($post->images) as $image)   
                                <img class="post-preview-image image-fluid col-sm-4 col-md-3 mt-2 mb-1"
                                  style="width:20%; height:auto; object-fit: contain;" 
                                  src="storage/{{$image}}"  
                                  alt="{{$post->id}}"
                                  @if ($post->image) 
                                    onclick="postImageOnClick_Carousel({{$post->images}}, {{$loop->index}})"
                                  @else
                                    onclick="postImgOnClick2(event)"
                                  @endif
                                >  
                              @endforeach 
                            @endif
                          </div> 
                      </div>  

                      <div class="container post-review-data ms-2">
                        <?php 
                          $like_array = breakdownLikeReview($likes_on_post, $post->id);
                        ?>
                        @if($like_array['total']>0)
                          @if($like_array['like']>0)
                          {{-- <i class="fa-regular fa-thumbs-up"></i> --}}
                            <i class="fa-solid fa-lg fa-thumbs-up" style="color:green;"></i>
                            <a>{{ $like_array['like'] }}</a>
                          @endif
                          @if($like_array['love']>0)
                            <i class="fa-solid fa-lg fa-heart" style="color:red;"></i>
                            <a>{{ $like_array['love'] }}</a>
                          @endif
                          @if($like_array['wow']>0)
                            <i class="fa-solid fa-lg fa-face-surprise" style="color:purple;"></i>
                            <a>{{ $like_array['wow'] }}</a>
                          @endif
                          @if($like_array['sad']>0)
                            <i class="fa-solid fa-lg fa-face-sad-cry" style="color:blue;"></i>
                            <a>{{ $like_array['sad'] }}</a>
                          @endif
                          @if($like_array['angry']>0)
                            <i class="fa-solid fa-lg fa-face-angry" style="color:black;"></i>
                            <a>{{ $like_array['angry'] }}</a>
                          @endif
                        @endif
                      </div> 

                      <div class="container post-review-panel pb-1 pt-1" 
                           style="background-color: white; border-radius:8px;">
                        <div class="row text-center align-items-center"> 
                          <div class="col dropup-center dropup  " style="color:gray; font-size:16px;">
                              <i class="post-like-icon-{{ $post->id }} fa fa-thumbs-up fa-xl" aria-hidden="true"  
                              style="color:grey; --fa-animation-duration: 1s;"></i> 
                              <button class="btn" type="button" 
                                {{-- onmouseover="onMouseOverLike({{ $post->id }})"
                                onmouseout="onMouseOutLike({{ $post->id }})" --}}
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                Like
                              </button>
                              @if(likedByPostOwner($likes_on_post, $post->id, $post->user_id)) 
                              <script> 
                                $('.post-like-icon-'+{{$post->id}}).addClass('fa-beat'); 
                                $('.post-like-icon-'+{{$post->id}}).css("color","green");
                              </script> 
                              @endif
                               
                              <div class="dropdown-menu dropdown-menu--{{ $post->id }}"> 
                                <div class="dropdown-item dropdown-item-like-{{ $post->id }}">  
                                  <a class="dropdown-item-like-thumb-{{ $post->id }} mx-2"
                                    style="text-decoration: none;"  method = "GET" 
                                    href="{{ route('like.update', [
                                      'like_post_id' => $post->id,
                                      'like_user_id' => $user->id,
                                      'like'  => 'like',
                                      ]) }}">
                                    <i class="fa-solid fa-thumbs-up fa-beat" 
                                      data-bs-placement="left"  
                                      data-bs-toggle="tooltip"  
                                      data-bs-custom-class="custom-tooltip"
                                      data-bs-title="Like It!"
                                      style="color:green;font-size:24px; --fa-animation-duration: 1s;"></i>
                                  </a>
                                  <a class="dropdown-item-like-heart-{{ $post->id }} mx-2" 
                                    style="text-decoration: none;"
                                    href="{{ route('like.update', [
                                      'like_post_id' => $post->id,
                                      'like_user_id' => $user->id,
                                      'like'  => 'love',
                                      ]) }}">
                                    <i class="fa-solid fa-heart fa-beat"  
                                      data-bs-placement="left"  
                                      data-bs-toggle="tooltip"  
                                      data-bs-custom-class="custom-tooltip" 
                                      data-bs-title="Love It!"  
                                      style="color:red; font-size:24px; --fa-animation-duration: 0.5s;"></i>
                                  </a>
                                  <a class="dropdown-item-like-surprice-{{ $post->id }} mx-2"
                                    style="text-decoration: none;"
                                    href="{{ route('like.update', [
                                      'like_post_id' => $post->id,
                                      'like_user_id' => $user->id,
                                      'like'  => 'wow',
                                      ]) }}">
                                    <i class="fa-solid fa-face-surprise fa-beat"  
                                      data-bs-placement="left"  
                                      data-bs-toggle="tooltip"  
                                      data-bs-custom-class="custom-tooltip"
                                      data-bs-title="WOW!"
                                      style="color:purple;font-size:24px; --fa-animation-duration: 1.5s;"></i>
                                  </a> 
                                  <a class="dropdown-item-like-sad-{{ $post->id }} mx-2"
                                    style="text-decoration: none;"
                                    href="{{ route('like.update', [
                                      'like_post_id' => $post->id,
                                      'like_user_id' => $user->id,
                                      'like'  => 'sad',
                                      ]) }}">
                                    <i class="fa-solid fa-face-sad-cry fa-beat" 
                                      data-bs-placement="left"  
                                      data-bs-toggle="tooltip"  
                                      data-bs-custom-class="custom-tooltip"
                                      data-bs-title="Sad"
                                      style="color:blue;font-size:24px; --fa-animation-duration: 2s;"></i>
                                  </a>
                                  <a class="dropdown-item-like-angry-{{ $post->id }} mx-2"
                                    style="text-decoration: none;"
                                    href="{{ route('like.update', [
                                      'like_post_id' => $post->id,
                                      'like_user_id' => $user->id,
                                      'like'  => 'angry',
                                      ]) }}">
                                    <i class="fa-solid fa-face-angry fa-beat" 
                                      data-bs-placement="left"  
                                      data-bs-toggle="tooltip"  
                                      data-bs-custom-class="custom-tooltip"
                                      data-bs-title="Angry"
                                      style="color:black;font-size:24px; --fa-animation-duration: 2.5s;"></i>
                                  </a>   
                                </div>
                              </div>
                            </div>    

                          <div class="col" style="color:gray; font-size:16px;">
                            <i class="post-comment-icon-{{ $post->id }} fa fa-commenting-o fa-xl" 
                               aria-hidden="true" style="color:gray;"></i> 
                              <button class="btn btn-comment-on-{{ $post->id }}" type="button"  
                                onclick="commentCollapse('collapseComment-'+{{ $post->id }})" 
                                {{-- onmouseover="onMouseOverComment({{ $post->id }})"
                                onmouseout="onMouseOutComment({{ $post->id }})" --}}
                                data-bs-toggle="collapse"  
                                data-bs-target="#collapseComment-{{ $post->id }}" 
                                aria-expanded="false"  
                                aria-controls="collapseComment-{{ $post->id }}">
                                Comment
                              </button>   
                          </div>  
                          
                          <div class="col dropdown" 
                            style="color:gray; font-size:16px; --fa-animation-duration: 3s;">
                            <i class="post-share-icon-{{ $post->id }} fa fa-share fa-xl" 
                               aria-hidden="true" style="color:gray;"></i> 
                              <button class="btn dropdown-toggle" type="button"  
                                data-bs-toggle="dropdown" aria-expanded="false" 
                                {{-- onmouseover="onMouseOverShare({{ $post->id }})"
                                onmouseout="onMouseOutShare({{ $post->id }})" --}}
                                style="color:gray; font-size:16px;">
                                Share
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ $post->url }}">
                                  <i class="fa fa-xl fa-facebook-official" style="color:blue;" aria-hidden="true"></i>
                                  Share on Facebook
                                </a></li>
                                <li><a class="dropdown-item" href="http://twitter.com/share?text={{ $post->caption }}&url={{ $post->url }}"> 
                                  <i class="fa fa-xl fa-twitter-square" style="color:cornflowerblue" aria-hidden="true"></i>
                                  Tweet it!
                                </a></li>
                                
                                {{-- <li><a class="dropdown-item" href="https://telegram.me/share"> --}}
                                <li><a class="dropdown-item" href="https://telegram.me/share/url?url={{ $post->url }}&text={{ $post->caption }}">
                                  {{-- https://telegram.me/share/url?url=<URL>&text=<TEXT> --}}
                                  <i class="fa fa-xl fa-telegram" style="color:cornflowerblue" aria-hidden="true"></i>
                                  Share to Telegram
                                </a></li>
                                <li><a class="dropdown-item" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $post->url }}">
                                  <i class="fa fa-xl fa-linkedin-square" aria-hidden="true"></i>
                                  Share to LinkedIn
                                </a></li>
                                <li><a class="dropdown-item" href="whatsapp://send?text={{$post->caption}} {{ $post->url }}">
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

                        {{-- Collapse Content for Comment Button --}}
                        <div class="collapse row " id="collapseComment-{{ $post->id }}"> 
                          <div class="col-md-1 card" 
                            style="display:flex; border-style:none;
                                   justify-content:right; 
                                   background-image:url('/storage/{{ $profile->back_image }}'); 
                                   background-size:cover;">  
                            <img class="rounded-circle mt-1" style="height:30px; width:auto; max-width:30px; "  
                              src="/storage/{{ $profile->image }}"
                            >
                          </div>
                          <div class="col-md-11 card-body" > 
                            <form enctype="multipart/form-data" method="POST">
                              @csrf
                              <textarea class="form-control" type="text" 
                                style="resize: none;"
                                placeholder="Write your comment here..."
                                name="post-comment" id="post-comment" rows="1"></textarea>
                            </form>
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
  
        <div id="carouselImageView" 
             class="carousel slide"  
             data-bs-ride="true" data-wrap="false"> 
        </div>        

        {{-- <img class="modal-content" id="img01"> --}}
        {{-- <div id="caption"></div> --}}
      </div>   

      <script> 
          function commentCollapse(commentAreaId){  
            $("#"+commentAreaId).collapse("toggle");
          }

          const modal = document.getElementById("myModal");

          function postImgOnClick(e){ 
            var img_class=".img-thumbnail-"+e.target.alt;
            $(img_class).attr("src", e.target.src);
            postImgOnClick2(e); 
          }

          function postImageOnClick_Carousel(imgArray,idx){    
            const outerContainer = document.querySelector('#carouselImageView'); 

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
              tmpBtn.setAttribute('data-bs-target', '#carouselImageView');
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
              // tmpImg.classList.add('modal-content');
              tmpImg.classList.add('d-block');
              tmpImg.classList.add('w-100');   
              tmpImg.setAttribute('src',"/storage/"+imgArray[i]);  
              tmpImg.setAttribute('max-height', '90vh'); 
              divItem.appendChild(tmpImg); 
              divContainer.appendChild(divItem);      
              
              var btnSpan;
              var btnPrev = document.querySelector('.carousel-control-prev');
              if(btnPrev != null) btnPrev.remove();
              btnPrev = document.createElement('button'); 
              btnPrev.setAttribute('class','carousel-control-prev'); 
              btnPrev.setAttribute('type','button');
              btnPrev.setAttribute('data-bs-target','#carouselImageView');
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
              btnNext.setAttribute('data-bs-target','#carouselImageView');
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

          // Get the <span> element that closes the modal
          var span = document.getElementsByClassName("close")[0];

          //When the user clicks on <span> (x), close the modal
          span.onclick = function() {  
            modal.style.display = "none"; 
          }
      </script>
        
      <div class="col-md-2 right-hand-col" style="background-color:white;"> 
          
        <div class="weather-container mt-5"  style="position: fixed;"> 
            <div class="weather-form" style="position:sticky;"> 
              <form>
                <input class="city-input" type="text" placeholder="Find a city" size="15"  autofocus>
                <button type="submit">Go</button>
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

        <div class="mt-5" style="display:none;">
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

      </div>  
    </div>  
  </div>
@endsection
