@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">

            </div>
            <div class="col-4">
                <form action="{{ route('profile.postEdit', ['id' => $profile->id]) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description" 
                        id="description" 
                        value = "{{$profile->description}}"> 
                    </div>

                    <div class="form-group row">
                        <div>
                            <label for="profilepic">Profile picture</label>
                            <input type="file" name="profilepic" id="profilepic" 
                                alt="profile image" 
                                accept="image/*" > 

                            <script type="text/javascript"> 
                                function readURL(input){
                                    if(input.files && input.files[0]){
                                        var reader = new FileReader();
                                        reader.onload = function(e){
                                            var ObjImg = document.getElementById("profile_image");
                                            ObjImg.setAttribute("src", e.target.result)
                                        }
                                       
                                        reader.readAsDataURL(input.files[0]); 
                                    }
                                }
                                $("#profilepic").change(function(){  
                                    readURL(this); 
                                });
                            </script>

                        </div>
                        <div class="mb-2 mt-2"> 
                            <img id="profile_image" src="/storage/{{$profile->image}}" 
                                style="width: 25%;">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div>
                            <label for="backpic">Background picture</label>
                            <input type="file" name="backpic" id="backpic" 
                                alt="profile background image"
                                accept="image/*">

                            <script type="text/javascript"> 
                                function readURL2(input){
                                    if(input.files && input.files[0]){
                                        var reader = new FileReader();
                                        reader.onload = function(e){
                                            var ObjImg = document.getElementById("profile_backimage");
                                            ObjImg.setAttribute("src", e.target.result)
                                        }
                                       
                                        reader.readAsDataURL(input.files[0]); 
                                    }
                                }
                                $("#backpic").change(function(){  
                                    readURL2(this); 
                                });
                            </script>

                        </div>
                        <div class="mb-2 mt-2">
                            <img id="profile_backimage" src="/storage/{{$profile->back_image}}"
                                style="width: 40%;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Update profile</button>
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
