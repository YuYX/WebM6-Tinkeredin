@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- <div class="col-4"></div> --}}
            <div class="col-4">
                <img src="/storage/{{ $post->image }}" class="w-100" id="postpicPreview"> 
            </div>
            <div class="col-4"> 
                <div>Updating Post ID: <strong>{{$post->id}}</strong></div>
                <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="postpic">Choose Image</label>
                        <input type="file" name="postpic" id="postpic"> 
                        <script type="text/javascript"> 
                            function readURL(input){
                                if(input.files && input.files[0]){
                                    var reader = new FileReader();
                                    reader.onload = function(e){
                                        var curImgs = document.getElementsByClassName("editing-image");
                                        if(curImgs && curImgs.length<9){ //Limit to 9 pics.
                                            $('#postpicPreview').attr('src', e.target.result);    
                                            $('#postpicOld').attr('src', "/storage/{{ $post->image }}");               
                                        }
                                    }
                                    reader.readAsDataURL(input.files[0]); 
                                }
                            }
                            $("#postpic").change(function(){  
                                readURL(this);  
                            });
                        </script>

                        <label for="postpics">Choose Multiple Images</label>
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
                                                $('#postpicPreview').attr('src', e.target.result); 
                                                add_image2list(e.target.result, "editing-image", "editing-images", "postpicPreview");
                                                $('#postpicOld').attr('src', "/storage/{{ $post->image }}");               
                                            }
                                        }
                                        reader.readAsDataURL(input.files[i]); 
                                    }
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
                        <label for="caption">Caption</label>
                        <input class="form-control" type="text" name="caption" id="caption" 
                        value="{{ $post->caption }}">
                    </div>

                    <div class="form-group row">
                        <label for="caption">URL</label>
                        <input class="form-control" type="text" name="url" id="url" 
                        value="{{ $post->url }}">
                    </div>

                    <div class="form-group row">
                        <label for="content">Content</label>
                        <input class="form-control" type="text" name="content" id="content" 
                        value="{{ $post->content }}">
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </div>

                    <div class="mb-5">
                        <label>Old Image</label>
                        <img src="" class="w-50 mg-5 pt-2" id="postpicOld" alt="old posted image">
                    </div>
                </form>
                
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
