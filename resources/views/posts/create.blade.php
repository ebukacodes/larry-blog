@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\PostsController@store', 'method' => 'POST', 'enctype' =>
    'multipart/form-data', 'files' => true, 'class' => 'container']) !!}
    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', ' ', ['class' => 'form-control', 'placeholder' => 'title']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body', ' ', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body
        Text']) !!}
    </div>
    <div class="form-group">
        {!! Form::file('cover_image') !!}
    </div>
    {!! Form::submit('Post', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!};

@endsection
