@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Your Dashboard</h2>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <a class="btn btn-outline-primary mb-3" href="/posts/create">Create Post <span
                                class="fas fa-plus"></span></a>
                        <h3>Your Blog Posts</h3>

                    </div>

                </div>
            </div>
        </div>
        @if (count($posts) > 0)
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td></td>
                            <td>
                                <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning float-right">Edit</a>
                                {!! Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id],
                                'method' => 'POST', 'class' => 'float-right , mr-3']) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                {{-- @csrf
                                @method('delete') --}}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2 class="container">You have no posts yet</h2>
        @endif


    </div>
@endsection
