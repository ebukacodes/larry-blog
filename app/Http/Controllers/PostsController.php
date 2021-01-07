<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;


class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list all posts
        // order by created at in descending order
        $posts = Post::orderBy('created_at', 'desc')->paginate(7);
        return view('posts.index')->with('posts' , $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // create a post
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // receive and handle the uploaded file
        if ($request->hasFile('cover_image')) {
            // Get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get filename to avoid duplicates
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // Set filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        } else {
            $fileNameToStore = 'noimage.png';
        }

        // create the post
        $post = new Post;
        $post->title = $request->input('title'); 
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->user_id = auth()->user()->id;
        $post->save();

        // redirect
        return redirect('/posts')->with('success' , 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find a post
        $post =  Post::find($id);
        //return view('posts.show')->with('post', $post);
        if ($post) {
            return view('posts.show')->with('post', $post);
           //return view('posts.show')->with('post', $post);
        } else {
            abort(404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // edit a post
        $post = Post::find($id);

        // check user authentication
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error' , 'You do not have access to this');
        } 
        return view('posts.edit')->with('post' , $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request , [
            'title' => 'required',
            'body' => 'required'
        ]);

        if ($request->hasFile('cover_image')) {
            // Get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get filename to avoid duplicates
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // Set filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        }

        // update and save the new post
        $post = Post::find($id);
        $post->title = $request->input('title'); 
        $post->body = $request->input('body');
         if ($request->hasFile('cover_image')) {
            Storage::delete('public/cover_images/' . $post->cover_image);
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        // redirect
        return redirect('/posts')->with('success' , 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete a post
        $post = Post::find($id);

        // check user authentication
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error' , 'You do not have access to this');
        } 

        if ($post->cover_image != 'noimage.png') {
            // Delete the image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();

        return redirect('/posts')->with('success' , 'Post Deleted');
    }
}
