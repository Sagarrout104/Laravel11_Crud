@extends('layouts.master')

@section('content')
    <div class="main-content mt-5 d-flex justify-content-center">
        <div class="card w-50 text-center">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Show Posts</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('post.index') }}" class="btn btn-info mx-1">Back</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered border-dark">
                    <tbody>
                        <tr>
                            <td>id</td>
                            <td>{{ $post->id }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img src="{{ asset($post->image) }}" alt="" style="width: 300px"></td>
                        </tr>
                        <tr>
                            <td>title</td>
                            <td>{{ $post->title }}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{ $post->category->name }}</td>
                        </tr>
                        <tr>
                            <td>Publish Date</td>
                            <td>{{ date('d-m-y', strtotime($post->created_at)) }}</td>
                        </tr>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
