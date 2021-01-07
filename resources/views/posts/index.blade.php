@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div class="card">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img width="100%" src="/storage/cover_images/{{$post->cover_image}}" alt="{{$post->title}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
                        <small>Written on {{ $post->created_at }} by
                            <strong>{{ $post->user->name ?? 'unknown' }}</strong></small>
                    </div>
                </div>

            </div>
            {{-- pagination --}}
            {{ $posts->links() }}
        @endforeach
    @else
        <h1>No Posts found</h1>
    @endif

@endsection
