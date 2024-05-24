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
                        <h4>Trashed Posts</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('post.index') }}" class="btn btn-info mx-1">Back</a>
                    </div>
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
                        @if ($allTrash && $allTrash->count() > 0)
                            @foreach ($allTrash as $post)
                                <tr class="text-center">
                                    <th scope="row">{{ $post->id }}</th>
                                    <td><img src="{{ asset($post->image) }}" alt="" style="width: 100px"></td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->category_id }}</td>
                                    <td>{{ date('d-m-y', strtotime($post->created_at)) }}</td>
                                    <td>
                                        <div class=" d-flex justify-content-center gap-2">
                                            <a href="{{ route('post.restore', $post->id) }}"
                                                class=" btn btn-sm btn-primary">Restore</a>
                                            <form action="{{ route('post.forcedelete', $post->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm btn btn-danger">Delete Permanent</button>
                                            </form>
                                        </div>
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
            </div>
        </div>
    </div>
@endsection
