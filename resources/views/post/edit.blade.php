@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- <div class="col-4"></div> --}}
            <div class="col-8">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </div>
            <div class="col-4"> 
                <div>Updating Post ID: <strong>{{$post->id}}</strong></div>
                <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="postpic">Choose Image</label>
                        <input type="file" name="postpic" id="postpic">
                        {{-- <label>Old File:{{$post->image}}</label> --}}
                    </div>

                    <div class="form-group row">
                        <label for="caption">Caption</label>
                        <input class="form-control" type="text" name="caption" id="caption" 
                        value="{{ $post->caption }}">
                    </div>

                    <div class="form-group row">
                        <label for="content">Caption</label>
                        <input class="form-control" type="text" name="content" id="content" 
                        value="{{ $post->content }}">
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
