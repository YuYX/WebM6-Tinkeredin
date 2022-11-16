@extends('layouts.app')  

@section('content')  

  <div class="container">  
    <div class="row justify-content-center">   
      <div class="col-md-1 left-hand-col"></div>

      <div class="col-md-10">    
        @if($user_type == "users_following_me")
            <h3 style="color:blueviolet;">
                <span><strong>{{ $users_search->count() }}</strong>
                </span> following "{{ $login_user->name }}":
            </h3>  
        @elseif($user_type == "users_i_following")
            <h3 style="color:blueviolet;">
                No. of {{ $login_user->name }} following: 
                <span><strong>{{ $users_search->count() }}</strong>
                </span>
            </h3>  
        @elseif($user_type == "request_received")
            <h3 style="color:blueviolet;">
                {{ $login_user->name }} received request from: 
                <span><strong>{{ $users_search->count() }}</strong>
                </span>
            </h3>  
        @elseif($user_type == "request_sent")
            <h3 style="color:blueviolet;">
                {{ $login_user->name }} has sent request to: 
                <span><strong>{{ $users_search->count() }}</strong>
                </span>
            </h3>  
        @endif

        @foreach ($users_search as $user_search)    
            <div class="row mb-2" style="background-color:lightcyan; border-radius:8px;">
                <div class="mb-1 row pt-1" >
                    <div class="col-4" style="display:block;">
                      <img class="search-profile-image rounded-circle mx-auto"  
                        style="height:40px; width:auto; max-width:40px; display:inline-block;"
                        src="/{{ $user_search->image }}"> 
                        {{-- src="/storage/{{ $user_search->image }}">  --}}
                      <span class="text-danger">{{ $user_search->name }}</span>
                    </div> 
 
                    <div class="col-4 mt-1"> {{ $user_search->email }} </div>   
                    
                    <div class="col-2" > 
                        @if($user_type == "request_received")
                            <a class = "btn btn-outline-primary" method = "GET" 
                                href="{{ route('search.follow',
                                ['follower_id'=>$user_search->id, 
                                 'following_id'=>$login_user->id, 
                                 'status'=>'Following']) }}"
                            >Accept</a> 
                        @endif
                    </div> 

                    <div class="col-2" > 
                        @if($user_type == "users_i_following")
                            <a class = "btn btn-outline-primary" method = "GET" 
                                href="{{ route('search.follow',
                                ['follower_id'=>$login_user->id, 
                                'following_id'=>$user_search->id, 
                                'status'=>'NotFollowing']) }}"
                            >Unfollow</a> 

                        @elseif($user_type == "request_sent")
                            <a class = "btn btn-outline-primary" method = "GET" 
                                href="{{ route('search.follow',
                                ['follower_id'=>$login_user->id, 
                                'following_id'=>$user_search->id, 
                                'status'=>'NotFollowing']) }}"
                            >Withdraw</a> 
                            {{-- <div class="col-2 text-secondary text-nowrap ">Request sent</div>  --}}
                        @endif
                    </div>
                </div>   
                <hr class="solid mt-1" style="width:100%;">  
            </div> 
        @endforeach
      </div>    

      <div class="col-md-1 right-hand-col"> 
      </div>  
    </div>  
  </div>

@endsection