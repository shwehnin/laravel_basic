@extends("layouts.app")
@section("title") Create Post @stop
@section("head")
    <style>
        .temp-view img{
            border-radius: 0.25rem;
            margin-right: 1.25rem;
            box-shadow: 0 0 2px #00000090;
            transition: 0.3s;
        }
        .temp-view img:hover{
            filter: brightness(150%) contrast(130%);
        }
    </style>
    @endsection
@section("body")
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="bg-white">
                    <ol class="breadcrumb bg-white border border-faded">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Post</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Post List</span>
                            <div>
                                <a href="{{ route('post.index') }}" class="btn btn-outline-secondary btn-icon btn-sm">
                                    <i class="fa fa-list"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Post Title">
                                        @error("title")
                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="">Select Category</label>
                                        <select name="category_id" id="" class="form-control @error('category_id') is-invalid @enderror">
                                            @foreach($categories as $c)
                                            <option value="{{ $c->id }}" {{ $c->id == old("category_id") ? "selected" : "" }}>{{ $c->title }}</option>
                                                @endforeach
                                        </select>
                                        @error("category_id")
                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="" cols="30" rows="10">{{ old('description') }}</textarea>
                                @error("description")
                                <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                @error('image.*')
                                <small class="text-danger font-weight-bold">{{$message}}</small>
                                @enderror

                                <div class="preview w-100 border border-muted p-2" style="display:none">
                                    <p>Image Preview <i class="mdi mdi-image"></i> </p>
                                    <hr>
                                    <div class="temp-view"></div>
                                </div>
                                <br>
                                <button type="button" class="btn btn-outline-primary img-upload-btn">
                                    <i class="mdi mdi-image"></i> <span class="d-none d-md-inline">ပုံရွေးချယ်ရန်</span>
                                </button>
                                <input type="file" name="image[]" id="image" class=" d-none form-control p-2" accept="image/jpeg,image/png" multiple>


                                <button class="btn btn-primary">
                                    <i class="mdi mdi-newspaper"></i> Add New Post
                                </button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection

    @section("foot")
        <script>
           $(document).ready(function () {
               $(".img-upload-btn").click(function () {
                   $("#image").click();
               });

               $("#image").on("change",function () {
                   $(".preview").show("slow");
                   $(".temp-view").empty();
                   let input = event.target;
                   let images = input.files;

                   for(let x in images){
                       let reader = new FileReader();
                       reader.onload = function(){
                           let dataFile = reader.result;
                           $(".temp-view").append('<img style="height: 100px" src="'+dataFile+'">');
                       };
                       reader.readAsDataURL(images[x]);
                   }

               });
           });
        </script>
        @endsection
