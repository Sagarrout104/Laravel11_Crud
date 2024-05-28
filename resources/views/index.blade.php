@extends('layouts.master')

@section('content')
    <div class="main-content mt-5">
        @session('success')
            <div class="alert alert-success">{{ session('success') }}</div>
        @endsession
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>All Posts</h4>
                    </div>
                    @can('create', App\Models\Post::class)
                        <div class="col-md-6 d-flex justify-content-end">
                            <a href="{{ route('post.create') }}" class="btn btn-success mx-1">Create</a>
                            <a href="{{ route('post.trash') }}" class="btn btn-info mx-1">Trashed</a>
                        </div>
                    @endcan
                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered border-dark">
                    <thead style="background: rgb(190, 182, 182)">
                        <tr class=" text-center">
                            <th scope="col">Sl.No.</th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category</th>
                            <th scope="col">Publish Date</th>
                            <th scope="col">Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        @if ($allPost && $allPost->count() > 0)
                            @foreach ($allPost as $post)
                                <tr class="text-center">
                                    <th scope="row">{{ $post->id }}</th>
                                    <td><img src="{{ asset($post->image) }}" alt="" style="width: 100px"></td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ date('d-m-y', strtotime($post->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('post.show', $post->id) }}"
                                            class=" btn btn-sm btn-success">Show</a>
                                        @can('update', App\Models\Post::class)
                                            <a href="{{ route('post.edit', $post->id) }}"
                                                class=" btn btn-sm btn-primary">Edit</a>
                                        @endcan
                                        @can('delete', App\Models\Post::class)
                                            <form action="{{ route('post.destroy', $post->id) }}" method="post"
                                                class=" d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm btn btn-danger">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="7">No Data Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $allPost->links() }}
            </div>
        </div>
    </div>
@endsection
