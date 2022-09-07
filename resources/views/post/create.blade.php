@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4"> 
                <img src="" class="w-100" id="postpicPreview">  
            </div>
            <div class="col-4">
                <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="postpic">Post Pictures</label>
                        <input type="file" name="postpic" id="postpic">
                        <input type="hidden" name="postpics" id="postpics">

                        <script type="text/javascript"> 
                            function readURL(input){
                                if(input.files && input.files[0]){
                                    var reader = new FileReader();
                                    reader.onload = function(e){
                                        var curImgs = document.getElementsByClassName("adding-image");
                                        if(curImgs && curImgs.length<9){ //Limit to 9 pics.
                                            $('#postpicPreview').attr('src', e.target.result);
                                            add_image2list(e.target.result, "adding-image","adding-images");                                           
                                        }
                                    }
                                    reader.readAsDataURL(input.files[0]); 
                                }
                            }
                            $("#postpic").change(function(){  
                                readURL(this); 
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
                        <label for="content">Content</label>
                        <input class="form-control" type="text" name="content" id="content">
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Post!</button>
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
