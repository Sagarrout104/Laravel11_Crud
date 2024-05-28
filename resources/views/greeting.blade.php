@extends('layouts.master')

@section('content')
    <div class="text-center ">
        <div class=" mt-5">
            <a href="{{ route('greet', 'en') }}" class="btn btn-outline-dark">English</a>
            <a href="{{ route('greet', 'hi') }}" class="btn btn-outline-dark">Hindi</a>
        </div>
        <h1 class="mt-5">{{ __('translate.wellcome') }}</h1>
        <h4 class=" mt-5">{{ __('translate.defination') }}</h4>
    </div>
@endsection
