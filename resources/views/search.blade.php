@extends('layouts.app')  

@section('content')  

  <div class="container">  
    <div class="row justify-content-center">   
      <div class="col-md-1 left-hand-col">
        
      </div>

      <div class="col-md-10">    
            <h3 style="color:blueviolet;"><span><strong>{{ $numResult }}</strong></span> results found in searching for "{{ $search_keyword }}":</h3>  
              
            @foreach ($users as $user)   
            {{-- @if ($user->following_id == null or $user->following_id == $login_user->id)  --}}
            <div class="row mb-2" style="background-color:lightcyan; border-radius:8px;">
                <div class="mb-1 row pt-1" >
                    <div class="col-4" style="display:block;">
                      <img class="search-profile-image rounded-circle mx-auto" 
                        {{-- width="40" height="40"  --}}
                        style="height:40px; width:auto; max-width:40px; display:inline-block;"
                        {{-- src="/storage/{{ $user->image }}">  --}}
                        src="/{{ $user->image }}"> 
                      <span class="text-danger">{{ $user->name }}</span>
                    </div> 

                    {{-- <div class="col-2 text-danger "> {{ $user->name }} </div> --}}
                    <div class="col-4 mt-1"> {{ $user->email }} </div>  

                    {{-- <form class="" method="POST"> --}}
                    <?php 
                      $btnText = "Follow";
                      $InfoText = "Not Following"; 
                      $status2Be = "Pending";

                      $btnText_followed = "";
                      $InfoText_followed = "";
                      $status2Be_followed = "Following";
                    ?>
                    <div class="col-2" >  
                      <?php  
                            foreach($relations as $relation)
                            {  
                              if( ($relation->follower_id == $login_user->id) &&
                                  ($relation->following_id  == $user->id) )
                              { 
                                $follow_status  = ($relation->status == null) ? "unfollowing" : $relation->status;   
                                switch(strtolower($relation->status)) 
                                {
                                    case 'pending': 
                                        $btnText = "Withdraw";
                                        $InfoText = "Request Sent"; 
                                        $status2Be = "NotFollowing";
                                        break;
                                    case 'following':
                                        $btnText = "Unfollow";
                                        $InfoText = "Following"; 
                                        $status2Be = "NotFollowing";
                                        break;
                                    case 'notfollowing':
                                        $btnText = "Follow";
                                        $InfoText = "Not Following"; 
                                        $status2Be = "Pending";
                                        break;
                                    default:
                                        $btnText = "Follow";
                                        $InfoText = "Not Following"; 
                                        $status2Be = "Pending";
                                        break; 
                                }    
                              } 
                              else if ($relation->follower_id == $user->id &&
                                       $relation->following_id == $login_user->id )
                              {
                                if(strtolower($relation->status) == "pending") {
                                  $btnText_followed = "Accept";
                                  $InfoText_followed = "Request Received"; 
                                }
                                else if(strtolower($relation->status) == "following") {                                  
                                  $btnText_followed = "";
                                  $InfoText_followed = "Following you!"; 
                                }
                              }

                              // $InfoText = $InfoText."[".$relation->follower_id."->".$relation->following_id."]";
                            } 
                      ?>    
                        @if($btnText_followed != "")
                        <a class = "btn btn-outline-primary" method = "GET" 
                          href="{{ route('relation.follow',
                                  ['follower_id'=>$user->id, 
                                   'following_id'=>$login_user->id, 
                                   'status'=>$status2Be_followed]) }}">{{$btnText_followed}}</a>  
                        @elseif($InfoText_followed) 
                        <span style="color:#d538f1;">{{$InfoText_followed}}</span>
                        @endif
                    </div>

                    <div class="col-2" >   

                      @if($user->id != $login_user->id)
                        <a class = "btn btn-outline-primary" method = "GET" 
                            href="{{ route('relation.follow',
                                    ['follower_id'=>$login_user->id, 
                                     'following_id'=>$user->id, 
                                     'status'=>$status2Be]) }}">{{$btnText}}</a> 
                      @endif
                    </div>
                    {{-- <div class="col-1 form-check" > 
                        <td><button class="block-operation btn btn-danger mx-0">Block</button></td>  
                    </div>  --}}
                    {{-- </form> --}}
                </div>  

                <div class="mb-1 row pt-2" >
                    <div class="col-8 text-primary">{{ $user->description }}</div>
                    <div class="col-2 text-secondary text-nowrap ">
                      @if($btnText_followed != "")
                      {{ $InfoText_followed }}
                      @endif
                    </div>
                    @if($user->id != $login_user->id)
                      <div class="col-2 text-secondary text-nowrap ">{{ $InfoText }}</div>
                    @endif
                </div>
                <hr class="solid mt-1" style="width:100%;">  
            </div>
            {{-- @endif --}}
            @endforeach
      </div>    

      <div class="col-md-1 right-hand-col"> 
      </div>  
    </div>  
  </div>

@endsection