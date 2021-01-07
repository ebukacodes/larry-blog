@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn  btn-outline-secondary mt-3 mb-3">Go back</a>
    <h1>{{ $post->title }}</h1>
     <img width="100%" src="/storage/cover_images/{{$post->cover_image}}" alt="{{$post->title}}}">
     <br>
    <div class="">
        {!! $post->body !!}
    </div>
    <hr>
    <small>Written on {{ $post->created_at }} by <strong>{{ $post->user->name ?? 'unknown' }}</strong></small>
    <hr>
    @if (!Auth::guest())
        @if (!Auth::user()->id == $post->user_id)
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning">Edit</a>

            {!! Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST',
            'class' => 'float-right']) !!}
            {!! Form::hidden('_method', 'DELETE') !!}
            {{-- @csrf
            @method('delete') --}}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        @endif
    @endif

@endsection
