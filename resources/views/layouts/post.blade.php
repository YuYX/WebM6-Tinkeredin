@if($no_post_loaded<$posts->count())
            @foreach ($posts as $post) 
                <?php 
                    $no_post = $no_post + 1; 
                    $no_page = floor($no_post/20);
                ?>

                {{-- <script>
                    console.log("no_post:" + {{ $no_post }} + 
                                " no_post_loaded:"+ {{ $no_post_loaded }} + 
                                " no_page:" + {{ $no_page }} + 
                                " next_page:" + {{ $next_page }});
                </script> --}}

                {{-- @if($no_post>=$no_post_loaded && $no_post<($no_post_loaded+20) )  --}}
                  
                    {{-- <script>
                        console.log("no_post_loaded:" + {{ $no_post_loaded }});
                    </script> --}}

                  @if($no_page>0) 
                    @if($post->user_id == $user->id)
                      <div class="ind-post-area-page-{{ $no_page }} row mb-3" style="background-color:rgb(240, 255, 255); border-radius:8px; display:none;">
                    @else
                      <div class="ind-post-area-page-{{ $no_page }} row mb-3" style="background-color:rgb(224, 255, 255); border-radius:8px; display:none;">
                    @endif
                  @else
                    @if($post->user_id == $user->id)
                      <div class="ind-post-area row mb-3" style="background-color:rgb(240, 255, 255); border-radius:8px;">
                    @else
                      <div class="ind-post-area row mb-3" style="background-color:rgb(224, 255, 255); border-radius:8px;">
                    @endif
                  @endif
                      <div class="container mb-1 row ms-2 mt-2 me-0 pe-0" > 
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
                              {{-- src="/{{ $post->profile_image }}" --}}
                              src="{{Storage::disk('s3')->url($post->profile_image)}}"
                              {{-- src="/storage/{{ $post->profile_image }}" --}}
                              onmouseover="onMouseOverProfileImagePost({{ $post->id }})"
                              onmouseout="onMouseOutProfileImagePost({{ $post->id }})" 
                            ><span class="text-danger">{{ $post->user_name }}</span> 

                            <div class="dropdown-menu p-4">  
                              <div class="card cardeffect sticky-top " 
                                  style="background-color:honeydew;" >  
                                      <img class="rounded card-img-top mb-0" 
                                      {{-- src="/{{ $post->profile_back }}"  --}}
                                      src="{{Storage::disk('s3')->url($post->profile_back)}}"
                                      alt="">  
                                      {{-- src="/storage/{{ $post->profile_back }}" alt="">  --}}
                                      <div class="mx-auto">
                                          <img class="rounded-circle card-img-overlay mx-auto" 
                                              width="120" height="auto"
                                              {{-- src="/{{ $post->profile_image }}"  --}}
                                              src="{{Storage::disk('s3')->url($post->profile_image)}}"
                                              alt=""> 
                                              {{-- src="/storage/{{ $post->profile_image }}" alt="">   --}}
                                      </div> 
                                      
                                    <div class="card-body" style="text-align: center">
                                        <strong>{{$post->user_name}}</strong><br> 
                                        <div class="pt-1">{{ $post->profile_desc }}</div> 
                                    </div>  
                              </div>   
                            </div> 
                          </div>   

                          <div class="col-2 mt-1 ">Posted: {{ calcDateTimeDiff_2_Day_Hour_Min($post->created_at) }} </div>
                          <div class="col-4"></div>
                          <div class="col-2 pe-0 me-2"> 
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
                                {{-- src="{{ url('/' . $post->image ) }}" > --}}
                                {{-- src="/storage/{{$post->image}}" > --}} 
                                {{-- src="/{{$post->image}}" >  --}}
                                src="{{Storage::disk('s3')->url($post->image)}}">
                                @endif
                                {{ $post->content }} 
                              </div>
                            </div>   
                          </div>
                         
                        {{-- @if ($post->user_id == $user->id) 
                        @endif --}}
                          <hr class="solid" style="width:97%;">
                          <div class="container-fluid row" id="showing-images">
                            
                            @if ($post->images != null)
                              @foreach (json_decode($post->images) as $image)   
                                <img class="post-preview-image image-fluid col-sm-4 col-md-3 mt-2 mb-1"
                                  style="width:20%; height:auto; object-fit: contain; border-style:double; border-color:lightblue;" 
                                  {{-- src="{{ url('/' . $image ) }}"  --}}
                                  {{-- src="storage/{{$image}}"   --}}
                                  {{-- src="/{{$image}}" --}}
                                  src="{{Storage::disk('s3')->url($image)}}"
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
                                          {{-- src="/storage/{{ $comment->profile_image }}"> --}}
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
                                  {{-- src="/{{ $profile->image }}" --}}
                                  src="{{Storage::disk('s3')->url($profile->image)}}"
                                  >
                                {{-- src="/storage/{{ $profile->image }}"> --}}
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
                              {{-- data-bs-target="#collapseComment-{{ $post->id }}"  --}}
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
                {{-- @else  
                @endif --}}
            @endforeach   
            
            {{-- <script>
                console.log("no_post_loaded IDE:" + {{ $no_post_loaded }});
            </script> --}}
        @endif 