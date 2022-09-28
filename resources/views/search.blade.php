@extends('layouts.app')  

@section('content')  

  <div class="container">  
    <div class="row justify-content-center">   
      <div class="col-md-1 left-hand-col">
        
      </div>

      <div class="col-md-10">    
            <h3 style="color:blueviolet;"><span><strong>{{ $numResult }}</strong></span> results found in searching for "{{ $search_keyword }}":</h3>  
             
            
            @foreach ($users as $user)   
            @if ($user->following_id == null or $user->following_id == $login_user->id) 
            <div class="row mb-2" style="background-color:lightcyan; border-radius:8px;">
                <div class="mb-1 row pt-1" >
                    <div class="col-4" style="display:block;">
                      <img class="search-profile-image rounded-circle mx-auto" 
                        {{-- width="40" height="40"  --}}
                        style="height:40px; width:auto; max-width:40px; display:inline-block;"
                        src="/storage/{{ $user->image }}"> 
                      <span class="text-danger">{{ $user->name }}</span>
                    </div> 

                    {{-- <div class="col-2 text-danger "> {{ $user->name }} </div> --}}
                    <div class="col-6 mt-1"> {{ $user->email }} </div>  

                    {{-- <form class="" method="POST"> --}}
                    <div class="col-2" > 
                        <?php 
                            switch(strtolower($user->status)) {
                                case 'pending':
                                    $btnText = "Withdraw";
                                    $InfoText = "Request Pending"; 
                                    break;
                                case 'following':
                                    $btnText = "Unfollow";
                                    $InfoText = "Following"; 
                                    break;
                                default:
                                    $btnText = "Follow";
                                    $InfoText = "Not Following"; 
                                    break;
                            }  
                        ?>   
                            <a class = "btn btn-outline-primary" method = "POST"
                              href="{{ route('relation.follow',
                                      ['follower_id'=>$login_user->id, 
                                      'following_id'=>$login_user->id, 
                                      'status'=>$btnText]) }}">{{$btnText}}</a>  
                    </div>
                    {{-- <div class="col-1 form-check" > 
                        <td><button class="block-operation btn btn-danger mx-0">Block</button></td>  
                    </div>  --}}
                    {{-- </form> --}}
                </div>  

                <div class="mb-1 row pt-2" >
                    <div class="col-10 text-primary">{{ $user->description }}</div>
                    <div class="col-2 text-secondary text-nowrap ">{{ $InfoText }}</div>
                </div>
                <hr class="solid mt-1" style="width:100%;">  
            </div>
            @endif
            @endforeach
      </div>    

      <div class="col-md-1 right-hand-col"> 
      </div>  
    </div>  
  </div>

@endsection