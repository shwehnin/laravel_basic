@extends("layouts.app")
@section("title") Post List @stop
@section("body")
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="bg-white">
                    <ol class="breadcrumb bg-white border border-faded">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Post</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Post List</span>
                            <div>
                                <a href="{{ route('post.create') }}" class="btn btn-outline-secondary btn-icon btn-sm">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                @if(Auth::user()->role == 0)
                                    <th>Post User</th>
                                    @endif
                                <th>Controls</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $l)
                                <tr>
                                    <td>{{ $l->id }}</td>
                                    <td class="mm">{{ $l->title }}</td>
                                    {{--<td>{{ $categories->find($l->category_id)->title }}</td>--}}
                                    <td>{{ $l->getCategory->title }}</td>
                                    @if(Auth::user()->role == 0)
                                        <td>{{ $l->getUser->name }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('post.show',$l->id) }}" class="btn btn-outline-info btn-icon btn-sm">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        <form action="{{ route('post.destroy',$l->id) }}" class="d-inline-block" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-outline-danger btn-icon btn-sm">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $list->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection
