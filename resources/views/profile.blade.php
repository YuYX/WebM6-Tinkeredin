@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3"> 
            <div class="card cardeffect" style="background-color:beige;"> 
                <img class="rounded  card-img-top mb-5"  
                src="/storage/{{ $profile->back_image }}" alt=""> 
                <div class="mx-auto" style="position:absolute; left:80px; top: 140px;">
                    <img class="rounded-circle mx-auto" width="100" height="100" 
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

        <div class="col-md-9">   
            <div class="row mb-5">
                <div class="card col-md-1">
                    <img class="rounded-circle mx-auto" width="40" height="40" 
                    src="/storage/{{ $profile->image }}" alt="">  
                </div>
                <div class="card col-md-11">
                    <div class="card-header"> 
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

    </div>
</div>
@endsection
