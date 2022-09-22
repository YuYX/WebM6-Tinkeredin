@extends('layouts.app')  

@section('content')  

  <div class="container">  
    <div class="row justify-content-center">   
      <div class="col-md-1 left-hand-col">
        
      </div>

      <div class="col-md-10">   
            {{-- <div class="row mb-5">
                <div class="card profile-image-container col-md-1">
                    <img class="img-fluid rounded-circle mx-auto mt-1 profile-image"  
                        width="40" height="40" 
                        data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"
                    src="/storage/{{ $profile->image }}" alt="">   
                </div>
                <div class="card col-md-11">
                    <div class="card-body"> 
                        <a class="nav-link" href="{{ route('post.create')}}">Wanna Post Something, <span style="font-weight: bold;">{{ $user->name }}</span>?</a>
                    </div> 
                </div> 
            </div>  --}}

            
            <h3 style="color:blueviolet;"><span><strong>{{ $numResult }}</strong></span> results found in searching for "{{ $search_keyword }}":</h3>  
            @foreach ($users as $user)  
            <div class="row mb-3" style="background-color:lightcyan; border-radius:8px;">
                <div class="mb-1 row pt-2" >
                    <div class="col-1" style="display:block;">
                      <img class="search-profile-image rounded-circle mx-auto" width="40" height="40" 
                        src="/storage/{{ $user->image }}"> 
                    </div> 

                    <div class="col-2 text-danger "> {{ $user->name }} </div>
                    <div class="col-6"> {{ $user->email }} </div>
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
                        <button class="btn btn-outline-primary">{{$btnText}}</button> 
                    </div>
                    <div class="col-1" >
                        <button class="btn btn-primary mx-0">Posts</button> 
                    </div> 
                </div>  

                <div class="mb-1 row pt-2" >
                    <div class="col-9 text-primary">{{ $user->description }}</div>
                    <div class="col-1 text-secondary text-nowrap ">{{ $InfoText }}</div>
                </div>
                <hr class="solid mt-1" style="margin-left: 10px; width:100%;">  
            </div>
            @endforeach
      </div>    

      <div class="col-md-1 right-hand-col"> 
      </div>  
    </div>  
  </div>

@endsection