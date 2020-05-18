@extends("template.master")
@section("content")
    <div class="row">
        <div class="col-12 col-md-8">
            @if(count($list)==0)
                <div class="card mb-3">
                    <div class="card-header mm">There is no Post</div>
                    <div class="card-body mm-beauty">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam atque deleniti dicta doloribus ea eos excepturi iure magnam odio omnis provident quod ratione recusandae reprehenderit repudiandae rerum, sed soluta!
                        <br>
                        <a href="{{ route("article") }}" class="btn btn-outline-secondary">Read All</a>
                    </div>
                </div>
                @endif
            @foreach($list as $l)
                <div class="card mb-3">
                    <div class="card-header mm">{{ $l->title }}</div>
                    <div class="card-body mm-beauty">
                        {{ substr($l->description,0,150) }}
                        <br>
                        <a href="{{ route("detail",$l->id) }}" class="btn btn-outline-secondary">Read More</a>
                    </div>
                </div>
                @endforeach
        </div>
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold text-uppercase">Category Lists</h4>
                    <hr>
                    @foreach($categories as $c)
                        <a href="" class="btn btn-outline-secondary d-block mt-2" >
                            {{ $c->title }}
                        </a>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    @endsection
