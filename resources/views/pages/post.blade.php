@extends('layout.default')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->user->name }}</p>
    <p>{{ $post->body }}</p>

    @include('components.createcomment')
    @include('components.comments')
    {{ $post->comments }}
@endsection
