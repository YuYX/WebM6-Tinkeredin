@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- <div class="col-4"></div> --}}
            <div class="col-4">
                <img src="/{{ $post->image }}" class="w-100" id="postpicPreview"> 
                {{-- <img src="/storage/{{ $post->image }}" class="w-100" id="postpicPreview">  --}}
            </div>
            <div class="col-6"> 
                <div>Updating Post ID: <strong>{{$post->id}}</strong></div>
                <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="mt-1" for="postpic"><strong>Choose Featured Picture</strong></label>
                        <input type="file" name="postpic" id="postpic"> 
                        <script type="text/javascript"> 
                            function readURL(input){
                                if(input.files && input.files[0]){
                                    var reader = new FileReader();
                                    reader.onload = function(e){
                                        var curImgs = document.getElementsByClassName("editing-image");
                                        if(curImgs && curImgs.length<9){ //Limit to 9 pics.
                                            $('#postpicPreview').attr('src', e.target.result);    
                                            update_featuredImage(e.target.result, "featured-image","postpicPreview");
                                            $('#postpicOld').attr('src', "/{{ $post->image }}");     
                                            // $('#postpicOld').attr('src', "/storage/{{ $post->image }}");                         
                                        }
                                    }
                                    reader.readAsDataURL(input.files[0]); 
                                }
                            }
                            $("#postpic").change(function(){  
                                readURL(this);  
                            });
                        </script>

                        <div class="container-fluid row mt-1" id="featured-image-container"> 
                            <img src="" 
                                class="img-thumbnail col-sm-6 col-md-4" alt="Featured picture"
                                {{-- style="height:auto; object-fit:contain; opacity: 0.7;" --}}
                                id="featured-image">  
                        </div>

                        <label class="mt-1" for="postpics"><strong>Choose Multiple Images</strong></label>
                        <input type="file" name="postpics[]" id="postpics" multiple>

                        <script type="text/javascript"> 
                            function readURLs(input){
                                if(input.files && input.files[0]){ 
                                    var fileCount = input.files.length;
                                    for (i=0; i<fileCount; i++){
                                        var reader = new FileReader();
                                        reader.onload = function(e){
                                            var curImgs = document.getElementsByClassName("editing-image");
                                            if(curImgs && curImgs.length<9){ //Limit to 9 pics.
                                                // $('#postpicPreview').attr('src', e.target.result); 
                                                add_image2list(e.target.result, "editing-image", "editing-images", "postpicPreview");
                                                // $('#postpicOld').attr('src', "/storage/{{ $post->image }}");               
                                            }
                                        }
                                        reader.readAsDataURL(input.files[i]); 
                                    } 
                                    window.scroll(0, document.body.scrollHeight);    
                                }
                            }
                            $("#postpics").change(function(){  
                                readURLs(this); 
                            });
                        </script> 

                    </div>

                    <div class="container-fluid row" id="editing-images"> 
                    </div>
                    
                    <div class="form-group row">
                        <label class="mt-1" for="caption"><strong>Caption</strong></label>
                        <input class="form-control" type="text" name="caption" id="caption" 
                        value="{{ $post->caption }}" required>
                    </div>

                    <div class="form-group row">
                        <label class="mt-1" for="caption"><strong>URL or Shared Embed Code</strong></label>
                        <input class="form-control" type="text" name="url" id="url" 
                        value="{{ $post->url }}">
                    </div>

                    <div class="form-group row">
                        <label class="mt-1" for="content"><strong>Content</strong></label>
                        {{-- <input class="form-control" type="text" name="content" id="content" 
                        value="{{ $post->content }}"> --}}
                        <textarea class="form-control" type="text" 
                            name="content" id="content" rows="6" required>{{ $post->content }}</textarea>
                    </div>

                    <div class="form-group row mt-1">
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </div>

                    <div class="mb-5">
                        <label>Old Image</label>
                        <img src="" class="w-50 mg-5 pt-2" id="postpicOld" alt="old posted image">
                    </div>
                </form>
                
            </div>
            <div class="col-2"></div>
        </div>
    </div>
@endsection
