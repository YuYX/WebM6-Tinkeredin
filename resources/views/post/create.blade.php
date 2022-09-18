@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4"> 
                <img src="" class="w-100" id="postpicPreview">  
            </div>
            <div class="col-6">
                <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group row"> 
                        <label for="postpic">Choose Image</label>
                        <input type="file" name="postpic" id="postpic"> 
                        <div class="container-fluid row" id="adding-featured-images"> 
                        <script type="text/javascript"> 
                            function readURL(input){
                                if(input.files && input.files[0]){
                                    var reader = new FileReader();
                                    reader.onload = function(e){
                                        var curImgs = document.getElementsByClassName("adding-image");
                                        if(curImgs && curImgs.length<9){ //Limit to 9 pics.
                                            $('#postpicPreview').attr('src', e.target.result);
                                            add_image2list(e.target.result, "adding-image","adding-featured-images");                                           
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
                                            var curImgs = document.getElementsByClassName("adding-image");
                                            if(curImgs && curImgs.length<9){ //Limit to 9 pics.
                                                $('#postpicPreview').attr('src', e.target.result); 
                                                add_image2list(e.target.result, "adding-image", "adding-images", "postpicPreview"); 
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
                        <div class="container-fluid row" id="adding-images"> 
                    </div>

                    <div class="form-group row">
                        <label for="caption">Caption</label>
                        <input class="form-control" type="text" name="caption" id="caption">
                    </div>

                    <div class="form-group row">
                        <label for="caption">URL</label>
                        <input class="form-control" type="text" name="url" id="url">
                    </div>

                    <div class="form-group row">
                        <label for="content">Content</label>
                        {{-- <input class="form-control" type="text" name="content" id="content"> --}}
                        <textarea class="form-control" 
                            type="text" name="content" id="content" rows="6"></textarea>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Post!</button>
                    </div>
                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
@endsection
