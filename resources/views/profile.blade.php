@extends('layouts.app')

@section('content')   

  @php 
    $no_post_loaded = 0;
    $no_post = 0; 
    $no_page = 0;
    $next_page = 1;

    function calcDateTimeDiff_2_Day_Hour_Min($timestamp){
      $time_duration = 0;
      $time_diff = floor( time()-strtotime($timestamp) );
      if($time_diff<60){
        $time_duration = $time_diff."s";
      }else{
        $time_diff = floor( $time_diff/60 );
        if($time_diff<60){
              $time_duration = $time_diff."m";
        }else{
              $time_diff = floor( $time_diff/60 );
          if($time_diff<24){
              $time_duration = $time_diff."h";
          }else{
            $time_diff = floor( $time_diff/24 );
            $time_duration = $time_diff."d";
          }
        }   
      }
      return($time_duration);
    }

    function likedByLoginUser($likes, $post_id, $post_user_id) {
      foreach($likes as $like){
        if($like->like == "like"){
          if($like->like_post_id == $post_id &&
             $like->like_user_id == $post_user_id ){
            return true; 
      }}}
      return false;
    }
    function likedByLoginUser2($likes, $post_id, $post_user_id) {
      foreach($likes as $like){ 
          if($like->like_post_id == $post_id &&
             $like->like_user_id == $post_user_id ){
            return $like->like;       
          }
      }
      return 'none';
    }

    function commentsCount4APost($comments, $post_id){
      $comment_count = 0;
      foreach ($comments as $comment) {
        if($comment->comment_post_id == $post_id){
          $comment_count++;
        }
      }
      if($comment_count>0){
        return "Comments: ". $comment_count;
      }else{
        return "";
      } 
    }
 
    function breakdownLikeReview($likes, $post_id){ 
      $like_count   = 0;
      $love_count   = 0;
      $laugh_count  = 0;
      $wow_count    = 0;
      $sad_count    = 0;
      $angry_count  = 0; 
      
      foreach($likes as $like){
        if($like->like_post_id == $post_id){ 
          switch($like->like){
            case "like":
                  $like_count++;
                  break;
            case "love":
                  $love_count++;
                  break;
            case "laugh":
                  $laugh_count++;
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
        'like'  => $like_count,
        'love'  => $love_count,
        'laugh' => $laugh_count,
        'wow'   => $wow_count,
        'sad'   => $sad_count,
        'angry' => $angry_count,
        'total' =>( $like_count +
                    $love_count +
                    $laugh_count +
                    $wow_count +
                    $sad_count +
                    $angry_count),
      ];
    }

    function makeLikeIconCount($like_array, $likes_on_post, $postId, $like_type,$iconClass, $color){
      $html_inner = "";
      if($like_array[$like_type]>0){
          $html_inner = 
            "<span class='dropdown like-count-in-type' display='flex'>" .
            "<i class='fa-solid fa-lg $iconClass' style='color:$color'></i>" .
            "<a type='button' style='text-decoration:none;' data-bs-toggle='dropdown'>".
            "&nbsp;".$like_array[$like_type]."&nbsp;&nbsp;</a>" .
            "<ul class='dropdown-menu dropdown-menu-dark dropdown-like-$like_type'>";

          foreach($likes_on_post as $like_on_post){
            if( ($like_on_post->like_post_id == $postId) &&
                ($like_on_post->like == $like_type) ) {
              $html_inner = $html_inner .
                "<li><a class='dropdown-item' href='#'>".
                $like_on_post->like_user_name . 
                "</a></li>";
            }
          } 
          $html_inner = $html_inner . "</ul></span>";
      } 
      return $html_inner;
    }

    function makeLikeIconsCount($likes_on_post, $post_id){ 

        $like_array = breakdownLikeReview($likes_on_post, $post_id); 
        
        $html_inner = "";
        // '<div class="container post-review-data ms-2">';
          if($like_array['total']>0){
            $html_inner = $html_inner . makeLikeIconCount($like_array,$likes_on_post,$post_id,"like","fa-thumbs-up","green") ;
            $html_inner = $html_inner . makeLikeIconCount($like_array,$likes_on_post,$post_id,"love","fa-heart","red");
            $html_inner = $html_inner . makeLikeIconCount($like_array,$likes_on_post,$post_id,"laugh","fa-face-grin-beam","deeppink");                        
            $html_inner = $html_inner . makeLikeIconCount($like_array,$likes_on_post,$post_id,"wow","fa-face-surprise","purple");                          
            $html_inner = $html_inner . makeLikeIconCount($like_array,$likes_on_post,$post_id,"sad","fa-face-sad-cry","blue");                         
            $html_inner = $html_inner . makeLikeIconCount($like_array,$likes_on_post,$post_id,"angry","fa-face-angry","black");
          }
          // $html_inner = $html_inner . '</div>';

      return $html_inner;
    }

    function makeLikeIcon2($likeType, $likeText, $postId, $userId, $iconClass, $color){
      $html_content = 
      "<a class='dropdown-item-like-thumb-$postId mx-2'
        style='text-decoration: none;'
        onclick=\"likeIcon_onClick('dropdown-item-like-thumb-$postId', '$postId', '$userId', '$likeType')\">
        <i class='fa-solid $iconClass fa-beat' 
          data-bs-placement='left'  
          data-bs-toggle='tooltip'  
          data-bs-custom-class='custom-tooltip'
          data-bs-title='$likeText'
          style='color:$color; font-size:24px; --fa-animation-duration: 1s;'></i>
      </a>"; 
      return $html_content;
    }

    function makeLikeIcon($likeType, $likeText, $postId, $userId, $iconClass, $color){
      $html_content = 
      "<a class='dropdown-item-like-thumb-$postId mx-2'
        style='text-decoration: none;'  method = 'GET' 
        href="
        .
        route('like.update',['like_post_id'  => $postId,
                             'like_user_id' => $userId,
                             'like'  => $likeType ] )
        .
        ">
        <i class='fa-solid $iconClass fa-beat' 
          data-bs-placement='left'  
          data-bs-toggle='tooltip'  
          data-bs-custom-class='custom-tooltip'
          data-bs-title='$likeText'
          style='color:$color; font-size:24px; --fa-animation-duration: 1s;'></i>
      </a>";
      return $html_content;
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
              
                <img class="rounded card-img-top mb-1" 
                {{-- src="/{{ $profile->back_image }}"  --}}
                src="{{Storage::disk('s3')->url($profile->back_image)}}" 
                alt=""> 
                {{-- src="/storage/{{ $profile->back_image }}" alt="">  --}}
                <div class="mx-auto">
                    <img class="rounded-circle card-img-overlay mx-auto" 
                        width="120" height="120"
                        src="{{Storage::disk('s3')->url($profile->image)}}" 
                        {{-- src="/{{ $profile->image }}"  --}}
                        alt="">  
                        {{-- src="/storage/{{ $profile->image }}" alt="">   --}}
                </div> 
                
            <div class="card-body" style="text-align: center">
                <strong>{{$user->name}}</strong><br>
                
                <div class="pt-1">{{ $profile->description }}</div>
                <div class="pt-1">  
                  <ul><li>
                    <a class="active" method="GET" href="{{ route('profile.edit') }}">Edit profile</a>
                  </li></ul>
                </div>
                {{-- <a href="/profile/edit">Edit profile</a> --}}
                <span>You have <strong>{{$numPosts}}</strong> posts</span> 
                <hr style="width:100%;">
                <div class="row justify-content-md-center"> 
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
 
  <div class="container-fluid">  
    <div class="row justify-content-center">   
      <div class="col-sm-3 col-md-3 left-hand-col px-4" style="background-color:white;">
        <div class="mt-5">
          <img class="rounded-circle" style="height:30px; width:auto; max-width:30px; margin-right:8px; display:inline-block;"  
               src="{{Storage::disk('s3')->url($profile->image)}}" 
               {{-- src="/{{ $profile->image }}"   --}}
               {{-- src="/storage/{{ $profile->image }}"   --}}
          ><span class="text-danger">{{  $user->name }}</span>
        </div> 
        
        <hr class="solid my-1" style="width:100%;">

        <div class="mt-4 row">
          {{-- <div class="col-sm-2 col-md-2 ps-0"> 
            <i class="fa-solid fa-user-group mt-2" 
              style="font-size:18px; color:rgb(24, 183, 236)"></i>
          </div> --}}
          <div class="col-sm-12 col-md-12 ps-0">
            <span>
              <i class="fa-solid fa-user-group mt-2" 
              style="font-size:18px; color:rgb(24, 183, 236)"></i>
            </span>
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.search_following') }}">My Followings
              <span class="badge rounded-pill bg-info">
                {{ $users_i_follow->count() }}
              </span>
            </a>
          </div>
        </div>
        
        <div class="mt-2 row">
          {{-- <div class="col-sm-2 col-md-2 ps-0">
            <ion-icon class="mt-1" name="person-add-sharp" style="font-size:24px; color:rgb(24, 183, 236);"></ion-icon> 
          </div> --}}
          <div class="col-sm-12 col-md-12 ps-0">
            <span>
              <ion-icon class="mt-1" name="person-add-sharp" style="font-size:24px; color:rgb(24, 183, 236);"></ion-icon> 
            </span>
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.request_sent') }}">Requests Sent
              <span class="badge rounded-pill bg-info ">
                {{ $users_request_sent->count() }}
              </span>
            </a>
          </div>
        </div>  
        
        <div class="mt-2 row">
          {{-- <div class="col-sm-2 col-md-2 ps-0">
            <ion-icon class="mt-1" name="people-sharp" style="font-size:24px; color:blue;"></ion-icon>
          </div> --}}
          <div class="col-sm-12 col-md-12 ps-0">
            <span>
              <ion-icon class="mt-1" name="people-sharp" style="font-size:24px; color:blue;"></ion-icon>
            </span>
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.search_follower') }}">My Followers
              <span class="badge rounded-pill bg-info">
                {{ $users_follow_me->count() }}
              </span>
            </a>
          </div>
        </div> 
        
        <div class="mt-2 row">
          {{-- <div class="col-sm-2 col-md-2 ps-0">
            <ion-icon class="mt-1" name="person-add-sharp" style="font-size:24px; color:blue;"></ion-icon>
          </div> --}}
          <div class="col-sm-12 col-md-12 ps-0" >
            <span>
              <ion-icon class="mt-1" name="person-add-sharp" style="font-size:24px; color:blue;"></ion-icon>
            </span>
            <a class = "btn ps-0 text-nowrap follow-status-search" method = "GET" 
              href="{{ route('search.request_received') }}">Requests Received
              <span class="badge rounded-pill bg-danger">
                {{ $users_request_received->count() }}
              </span>
            </a>
          </div>
        </div> 
         
      </div>

      <div class="col-sm-7 col-md-7 middle-col"  style="background-color:whitesmoke">   
            <div class="row mb-5" > 
                <div class="card profile-image-container col-sm-2 col-md-2" 
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" 
                    style="background-image:url({{Storage::disk('s3')->url($profile->back_image)}}); 
                           border-style:none; border-radius: 10px;
                           -webkit-background-size:cover;
                           -moz-background-size: color;
                           -o-background-size:cover;
                           background-size:cover;">
                    {{-- style="background-image:url('/{{ $profile->back_image }}'); 
                           border-style:none; border-radius: 10px;
                           background-size:cover;"> --}}
                    <img class="img-fluid rounded-circle mx-auto mt-1 profile-image"  
                        style="height:40px; width:auto; max-width:40px; 
                              --animate-duration: 2s; "  
                        data-bs-toggle="offcanvas" 
                        href="#offcanvasExample" 
                        role="button" 
                        aria-controls="offcanvasExample"
                        src="{{Storage::disk('s3')->url($profile->image)}}"
                        {{-- src="/{{ $profile->image }}"  --}}
                        alt=""> 
                      {{-- src="/storage/{{ $profile->image }}" alt="">    --}}
                </div>
                <div class="card col-sm-10 col-md-10"  
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
              <video class="corporate-video-clip pt-0 mt-0" width="100%" height="auto" controls  autoplay loop muted 
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

            {{-- Only show the first 30 posts. --}}
            {{-- How to implement that it can automatically load the subsequent 10 posts
               once user scrolled to the bottom?  --}}

            {{-- <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
            <script src="js/DisMojiPicker.js"></script> --}}
            
            {{-- Start of Include --}}

            {{-- @if($no_post_loaded<1)
              @foreach ($posts as $post) 
                <?php 
                  //$no_post = $no_post+1; 
                ?>
                @if($no_post<=30)
                  <?php 
                    //$no_post_loaded = $no_post_loaded + 1; 
                  ?>
                  @if($post->user_id == $user->id)
                    <div class="ind-post-area row mb-3" style="background-color:rgb(240, 255, 255); border-radius:8px;">
                  @else
                    <div class="ind-post-area row mb-3" style="background-color:rgb(224, 255, 255); border-radius:8px;">
                  @endif
                      <div class="mb-1 row ms-2 mt-2 me-0 pe-0" > 
                          <div class="col-4 dropdown dropdown-post-owner"> 
                            <img class="rounded-circle profile-image-4-post-{{$post->id}}" 
                              type="button" 
                              class="btn btn-primary dropdown-toggle" 
                              data-bs-toggle="dropdown" 
                              aria-expanded="false" 
                              data-bs-auto-close="outside"
                              style=" height:30px; 
                                      width:auto; 
                                      max-width:30px; 
                                      margin-right:8px;  
                                      display:inline-block;"  
                              src="/{{ $post->profile_image }}"
                              onmouseover="onMouseOverProfileImagePost({{ $post->id }})"
                              onmouseout="onMouseOutProfileImagePost({{ $post->id }})" 
                            ><span class="text-danger">{{ $post->user_name }}</span> 

                            <div class="dropdown-menu p-4">  
                              <div class="card cardeffect sticky-top " 
                                  style="background-color:honeydew;" >  
                                      <img class="rounded card-img-top mb-0" 
                                      src="/{{ $post->profile_back }}" alt=""> 
                                      <div class="mx-auto">
                                          <img class="rounded-circle card-img-overlay mx-auto" 
                                              width="120" height="auto"
                                              src="/{{ $post->profile_image }}" alt="">  
                                      </div> 
                                      
                                    <div class="card-body" style="text-align: center">
                                        <strong>{{$post->user_name}}</strong><br> 
                                        <div class="pt-1">{{ $post->profile_desc }}</div> 
                                    </div>  
                              </div>   
                            </div> 
                          </div>   

                          <div class="col-2 mt-1 ">Posted: {{ calcDateTimeDiff_2_Day_Hour_Min($post->created_at) }} </div> 
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
                            <div  class="col-12">   
                              @if(strstr($post->url,'<iframe') && strstr($post->url,'</iframe>')) 
                                <a class="post-title">{{ $post->caption }}</a>
                                {!! $post->url !!}
                              @elseif(strstr($post->url, "www.youtube.com") && strstr($post->url, "embed"))
                                <a class="post-title">{{ $post->caption }}</a> 
                                  <iframe width="640" height="360" src={{$post->url}}>
                                  </iframe>
                              @else
                                <a class="post-title" target="_blank" rel="noreferrer noopener"
                                   href="{{ $post->url }}">{{ $post->caption }}</a>
                              @endif 
                              <div class="post-content clearfix">
                                @if ($post->image)
                                <img class="col-md-6 float-md-start mb-1 me-md-2"
                                  src="/{{$post->image}}" >
                                @endif
                                {{ $post->content }} 
                              </div>
                            </div>   
                          </div>
                         
                        @if ($post->user_id == $user->id) 
                        @endif
                          <hr class="solid" style="width:97%;">
                          <div class="container-fluid row" id="showing-images">
                            @if ($post->images != null)
                              @foreach (json_decode($post->images) as $image)   
                                <img class="post-preview-image image-fluid col-sm-4 col-md-3 mt-2 mb-1"
                                  style="width:20%; height:auto; object-fit: contain; border-style:double; border-color:lightblue;" 
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
                      
                      <div class="container post-review-data-{{ $post->id }} ms-2">
                        {!! makeLikeIconsCount($likes_on_post,$post->id) !!}

                        <a class="btn float-end no-of-comment-4-{{ $post->id }}"  
                            onclick="commentCollapse('post-comment-list-'+{{ $post->id }})" 
                            data-bs-toggle="collapse" 
                            href=".post-comment-list-{{ $post->id }}" 
                            role="button" 
                            aria-expanded="false" 
                            aria-controls="post-comment-list-{{ $post->id }}">
                          {!! commentsCount4APost($comments_on_post,$post->id) !!}
                        </a>
                      </div> 

                      <div class="collapse post-comment-list-{{ $post->id }} ms-1 mb-1 mt-1" style="display:none;">
                        <div class="past-comment-list-{{ $post->id }}  ms-1 mb-1 mt-1">
                          @if($comments_on_post != null)
                            @foreach($comments_on_post as $comment)
                              @if($comment->comment_post_id == $post->id)
                              <div class=" row ms-1 mt-1 me-0 pe-0" style="display:flex;"> 
                                  <div class="card col-md-3 " 
                                      style="display:inline-block; background-color:rgb(240, 255, 255);">    
                                      <img class="img-fluid rounded-circle mt-1" 
                                          style="display:inline-block; height:24px; width:auto; max-width:30px; "  
                                          src="/{{ $comment->profile_image }}">
                                      <span class="text-danger" >
                                        {{ $comment->comment_user_name }}</span>
                                        <i class="fa fa-commenting-o" style="color:cornflowerblue;" aria-hidden="true"></i>
                                  </div>
                                  <div class="card col-md-9" 
                                        style="display:inline-block;  
                                                border-radius:8px; 
                                                border-style: groove;
                                                background-color:white;"> 
                                      {{$comment->comment}} 
                                  </div>
                              </div> 
                              @endif
                            @endforeach
                          @endif
                        </div>
 
                        <div class=" row ms-2 mt-1 collapseComment-{{ $post->id }}" >  
                          <div class="col-md-1 card" 
                              style="display:flex; border-style:none;
                                    justify-content:right; 
                                    background-image:url('/{{ $profile->back_image }}'); 
                                    background-size:cover;">   
                              <img class="img-fluid rounded-circle mx-auto mt-1" 
                                  style="height:30px; width:auto; max-width:30px; "  
                                src="/{{ $profile->image }}">
                          </div>
                          <div class="col-md-11 card-body" 
                            style="display:inline-block;"> 
                            <form class="form-floating form-post-comment-{{ $post->id }}" 
                                  enctype="multipart/form-data"   
                                  method="GET"> 
                                @csrf    
                                <input name="input-comment-post-id" class="input-comment-post-id" type="hidden" value={{ $post->id }}>
                                <input name="input-comment-user-id" class="input-comment-user-id" type="hidden" value={{ $user->id }}>
                                <input class="form-control" type="text" style="width:90%;display: inline-flex;" 
                                  id="post-comment-input-{{ $post->id }}"
                                  placeholder="Write your comment here" 
                                  name="input-comment" class="input-comment"> 

                                  <script>     

                                    var inputField4Comment = document.getElementById('post-comment-input-'+{{ $post->id }});
                                    inputField4Comment.addEventListener("keypress", function(event) { 
                                      if (event.key === "Enter") { 
                                        event.preventDefault();
                                        document.getElementById('btn-submit-comment-'+{{ $post->id }}).click();
                                      }
                                    });
                                  </script>
                                <label for="post-comment-input-{{ $post->id }}">Write your comment here</label>
                                <button class="btn btn-outline-secondary " 
                                        id="btn-submit-comment-{{ $post->id }}"
                                        style="display: inline-flex;"  
                                        onclick="comment_onSubmit(
                                          'form-post-comment-{{ $post->id }}', 
                                          'past-comment-list-{{ $post->id }}',
                                          'no-of-comment-4-{{ $post->id }}',
                                          'post-comment-input-{{ $post->id }}' )"
                                        type="button">Send</button> 
                            </form>
                          </div>   
                        </div>  

                      </div>

                    <div class="container post-review-panel pb-1 pt-1" style="background-color: white; border-radius:8px;">
                      <div class="row text-center align-items-center"> 
                        <div class="col dropdown-4-like dropup-center dropup  " 
                            style="color:gray; font-size:16px;">
                            <i class="post-like-icon-{{ $post->id }} fa fa-thumbs-up fa-xl" aria-hidden="true"  
                            style="color:grey; --fa-animation-duration: 1s;"></i> 
                            <button class="btn" type="button"  
                              data-bs-toggle="dropdown" 
                              aria-expanded="false">
                              Like
                            </button>  

                            @if( ($login_user_like = likedByLoginUser2($likes_on_post, $post->id, $user->id)) != 'none' )
                              <script>   
                                var cur_iconclass = 'fa-thumbs-up';
                                var cur_color = "gray";
                                if('{{$login_user_like}}' == 'like'){
                                  cur_iconclass = 'fa-thumbs-up';
                                  cur_color = 'green';
                                }else if('{{$login_user_like}}' == 'love'){
                                  cur_iconclass = 'fa-heart';
                                  cur_color = 'red';
                                }else if('{{$login_user_like}}' == 'wow'){
                                  cur_iconclass = 'fa-face-surprise';
                                  cur_color = 'purple';
                                }else if('{{$login_user_like}}' == 'sad'){
                                  cur_iconclass = 'fa-face-sad-cry';
                                  cur_color = 'blue';
                                }else if('{{$login_user_like}}' == 'laugh'){
                                  cur_iconclass = 'fa-face-grin-beam';
                                  cur_color = 'deeppink';
                                }else if('{{$login_user_like}}' == 'angry'){
                                  cur_iconclass = 'fa-face-angry';
                                  cur_color = 'black';
                                }

                                $('.post-like-icon-'+{{$post->id}}).removeClass(
                                  'fa-beat fa-thumbs-up fa-heart fa-face-sad-cry fa-face-grin-beam fa-face-angry fa-face-surprise'); 
                                 
                                $('.post-like-icon-'+{{$post->id}}).addClass(cur_iconclass);  
                                $('.post-like-icon-'+{{$post->id}}).addClass('fa-beat'); 
                                $('.post-like-icon-'+{{$post->id}}).css("color",cur_color);
                              </script> 
                            @endif
                               
                            <div class="dropdown-menu dropdown-menu--{{ $post->id }}"> 
                              <div class="dropdown-item dropdown-item-like-selection dropdown-item-like-{{ $post->id }}">    

                                {!! makeLikeIcon2('like','Like It!',$post->id,$user->id, "fa-thumbs-up","green") !!} 
                                {!! makeLikeIcon2('love','Lovely!',$post->id,$user->id, "fa-heart","red") !!} 
                                {!! makeLikeIcon2('laugh','Laugh',$post->id,$user->id, "fa-face-grin-beam","deeppink") !!} 
                                {!! makeLikeIcon2('wow','WOW!',$post->id,$user->id, "fa-face-surprise","purple") !!} 
                                {!! makeLikeIcon2('sad','So Sad!',$post->id,$user->id, "fa-face-sad-cry","blue") !!} 
                                {!! makeLikeIcon2('angry','Angry',$post->id,$user->id, "fa-face-angry", "black") !!}  
                              </div>
                            </div> 
                        </div>    

                        <div class="col dropdown-4-comment" style="color:gray; font-size:16px;">
                          <i class="post-comment-icon-{{ $post->id }} fa fa-commenting-o fa-xl" 
                             aria-hidden="true" style="color:gray;"></i> 
                            <button class="btn btn-comment-on-{{ $post->id }}" type="button"  
                              onclick="commentCollapse('post-comment-list-'+{{ $post->id }})"  
                              data-bs-toggle="collapse"   
                              data-bs-target=".post-comment-list-{{ $post->id }}" 
                              aria-expanded="false"  
                              aria-controls="post-comment-list-{{ $post->id }}">
                              Comment
                            </button>   
                        </div>  
                        
                        <div class="col dropdown dropdown-4-share" 
                          style="color:gray; font-size:16px; --fa-animation-duration: 3s;">
                          <i class="post-share-icon-{{ $post->id }} fa fa-share fa-xl" 
                             aria-hidden="true" style="color:gray;"></i> 
                            <button class="btn dropdown-toggle" type="button"  
                              data-bs-toggle="dropdown" aria-expanded="false"  
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
                               
                              <li><a class="dropdown-item" href="https://telegram.me/share/url?url={{ $post->url }}&text={{ $post->caption }}"> 
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
                    </div>    
                  </div>
                @endif
              @endforeach 
            @endif  --}}
            @Include('layouts.post')    
      </div>    
 
      <div class="posts-next-page-no" value={{ $next_page }} style="display: none;">{{ $next_page }}</div>

      <div id="myModal" class="modal"> 
        <span class="close">&times;</span>
  
        <div id="carouselImageView" 
             class="carousel slide"  
             data-bs-ride="true" data-wrap="false"> 
        </div>   
      </div>    
        
      <div class="col-sm-2 col-md-2 right-hand-col" style="background-color:white;"> 
          
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

  
  <script> 
    function commentCollapse(commentAreaId){  
      // $("#"+commentAreaId).collapse("toggle");   
      if($("."+commentAreaId).css('display') != 'none'){
        $("."+commentAreaId).css('display', 'none');
      }else{
        $("."+commentAreaId).css('display', 'block');
      }
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
          tmpImg.setAttribute('src',"https://yuyongxue-s3-bucket.s3.ap-southeast-1.amazonaws.com/"+imgArray[i]); 
          // tmpImg.setAttribute('src',"/"+imgArray[i]);  
          // tmpImg.setAttribute('src',"/storage/"+imgArray[i]);  
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

    function getTextWidth(text, font) {
      // re-use canvas object for better performance
      const canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
      const context = canvas.getContext("2d");
      context.font = font;
      const metrics = context.measureText(text);
      return metrics.width;
  }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    //When the user clicks on <span> (x), close the modal
    span.onclick = function() {  
      modal.style.display = "none"; 
    }
  </script>
  
  <script>    
    let toggle = true;
    window.onscroll = function() {  
        toggle = !toggle;   
        // navbar_h = document.getElementById("navbar_id");
        // console.log("navbar_h:"+navbar_h);
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) { 
                document.getElementById("navbar_id").style.background = "lightskyblue";  
        } else { 
                document.getElementById("navbar_id").style.background = "lightcyan";  
        }

        var spinner_color = toggle ? 'text-primary' : 'text-danger';
        var remainedpPosts = 
          `<div class="d-flex ` + spinner_color + ` justify-content-center post-loading-spinner">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>`;
        if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight){   
            if($('.post-loading-spinner').length<1) {
              $('.middle-col').append(remainedpPosts);  
            }  
             
            var next_page = parseInt($('.posts-next-page-no').text());
            console.log("gonne load next-page:" + next_page);
             
            if($('.ind-post-area-page-'+next_page).length>0 ){ 
              console.log("found:" + 'ind-post-area-page-'+next_page);
              $('.ind-post-area-page-'+next_page).each(function(){ 
                $(this).show();
              })
              next_page = next_page + 1; 
              $('.posts-next-page-no').text(String(next_page)); 
            }else{
              if($('.post-loading-spinner').length>0){
                $('.post-loading-spinner').remove();
              }
            }
        } else if((window.innerHeight + window.scrollY) < document.body.scrollHeight - 100) {
          if($('.post-loading-spinner').length>0){
            $('.post-loading-spinner').remove();
          }
        }

        localStorage.setItem("scrollTop", window.scrollY.toFixed());
        document.getElementById("x-location").innerHTML = window.scrollY.toFixed();  
    }

    function showTWEmojiPalette(emojisID){ 
      $('#' + emojisID).text('');
      $('#' + emojisID).disMojiPicker();   
    }

    function comment_onSubmit(commentForm_className, container_className, commentCount_className, commentInput_id){
      var url = "{{ route('comment.store') }}";  
      var ajax_data = $('.'+commentForm_className).serialize();

      $.ajax({
        type: "GET",
        url: url, 
        data: ajax_data,
        success: function (data){   
          var comment_user_name = data.comment_user_name; 
          var comment_user_profile_image = data.comment_user_profile_image;
          var comment = data.comment; 
          var comment_total = data.comment_total; 

          $('#'+commentInput_id).val('');

          var comment_count = "Comments:" + comment_total;
          $('.'+commentCount_className).html(comment_count);
 
          var div_new = 
          '<div class="row ms-1 mt-1 me-0 pe-0" style="display:flex;">'+ 
              '<div class="card col-md-3 "' +
                  'style="display:inline-block; background-color:rgb(240, 255, 255);">'+
                  '<img class="img-fluid rounded-circle mt-1" '+
                        'style="display:inline-block; height:24px; width:auto; max-width:30px; "'+  
                        'src="/'+ comment_user_profile_image + 
          '"><span class="text-danger">'+  comment_user_name + 
          '</span><span style="font-size:20px;">&#129315;</span>'+  
              '</div>'+
              '<div class="card col-md-9"'+
                    'style="display:inline-block;'+  
                            'border-radius:8px;'+ 
                            'border-style: groove;'+
                            'background-color:white;">' + comment +'</div></div>'; 
 
          var old_div = $('.'+container_className).html();
          div_new = old_div + div_new;
          // console.log(div_new);
          $('.'+container_className).html(div_new);  
        },
        error: function(data){
          console.log("ERROR");
        }
      });
    }
  
    function likeIcon_onClick(likeIcon_className, post_id, user_id, like_type){   
      var url = "{{ route('like.refresh', 
                    ['like_post_id' => ':post_id',
                     'like_user_id' => ':user_id',
                     'like' => ':like']) }}";
      url = url.replace(":post_id", post_id);
      url = url.replace(":user_id", user_id);
      url = url.replace(":like", like_type);  

      $.ajax({
        type: "GET",
        url: url,  
        success: function (data) { 
          var user_id = data.user_id; 
          var post_id = data.post_id;
          var likes_on_post = data.likes_on_post;
          var total=0; 
          var login_user_obj = {
                                  "type": 'like',
                                  "count": 0,
                                  "iconclass": 'fa-thumbs-up', 
                                  "color": 'green',
                               };

          var likes_array_obj = {
              'like': {
                        "type": 'like',
                        "count": 0,
                        "iconclass": 'fa-thumbs-up', 
                        "color": 'green',
                      },
              'love': {
                        "type": 'love',
                        "count": 0,
                        "iconclass": 'fa-heart', 
                        "color": 'red',
                      },
              'wow': {
                        "type": 'wow',
                        "count": 0,
                        "iconclass": 'fa-face-surprise', 
                        "color": 'purple',
                     },
              'sad': {
                        "type": 'sad',
                        "count": 0,
                        "iconclass": 'fa-face-sad-cry', 
                        "color": 'blue',
                     },
              'laugh':{
                        "type": 'laugh',
                        "count": 0,
                        "iconclass": 'fa-face-grin-beam', 
                        "color": 'deeppink',
                      },
              'angry':{
                        "type": 'angry',
                        "count": 0,
                        "iconclass": 'fa-face-angry', 
                        "color": 'black',
                      },
            };
 
          var liked_by_login_user = false;

          for(var i=0; i<likes_on_post.length; i++){ 
            if(likes_on_post[i].like == 'like'){ 
              likes_array_obj.like.count++;
            }
            else if(likes_on_post[i].like == 'love'){ 
              likes_array_obj.love.count++;
            } 
            else if(likes_on_post[i].like == 'wow'){ 
              likes_array_obj.wow.count++;
            }
            else if(likes_on_post[i].like == 'sad'){ 
              likes_array_obj.sad.count++;
            }
            else if(likes_on_post[i].like == 'laugh'){ 
              likes_array_obj.laugh.count++;
            }
            else if(likes_on_post[i].like == 'angry'){ 
              likes_array_obj.angry.count++;
            }
          }   

          var html_inner = "";  
          for (const property in likes_array_obj) {
            if(likes_array_obj[property].count>0){ 
                html_inner = html_inner +
                "<span class='dropdown like-count-in-type' display='flex'>" +
                "<i class='fa-solid fa-lg " + likes_array_obj[property].iconclass + 
                "' style='color:" + likes_array_obj[property].color + 
                "'></i>" +
                "<a type='button' style='text-decoration:none;' data-bs-toggle='dropdown'>"+
                "&nbsp;" + likes_array_obj[property].count + "&nbsp;&nbsp;</a>" +
                "<ul class='dropdown-menu dropdown-menu-dark dropdown-like-$like_type'>";

                for(var i=0; i<likes_on_post.length; i++){ 
                  if( (likes_on_post[i].like_post_id == post_id) &&
                      (likes_on_post[i].like == likes_array_obj[property].type) ) {

                    if(likes_on_post[i].like != 'none' &&
                       likes_on_post[i].like_user_id == user_id){ 
                        liked_by_login_user = true; 
                        login_user_obj = likes_array_obj[property]; 
                    }

                    html_inner = html_inner +
                      "<li><a class='dropdown-item' href='#'>" +
                      likes_on_post[i].like_user_name + 
                      "</a></li>";
                  }
                }

                html_inner = html_inner + "</ul></span>";
            } 
          }
          $('.post-review-data-' + post_id).html(html_inner);

          $('.post-like-icon-'+post_id).removeClass(
              'fa-beat fa-thumbs-up fa-heart fa-face-sad-cry fa-face-grin-beam fa-face-angry fa-face-surprise'); 
          if(liked_by_login_user){
            console.log(login_user_obj);
            $('.post-like-icon-'+post_id).addClass(login_user_obj.iconclass);
            $('.post-like-icon-'+post_id).addClass('fa-beat'); 
            $('.post-like-icon-'+post_id).css("color",login_user_obj.color);
          }else{
            $('.post-like-icon-'+post_id).addClass('fa-thumbs-up')
            $('.post-like-icon-'+post_id).css("color","gray");
          }
          // console.log(html_inner);  
        },
        error: function(data){
          console.log(data);
        }
      }); 
    }

  </script>

@endsection 
 