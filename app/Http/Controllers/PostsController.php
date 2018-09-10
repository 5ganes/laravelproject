<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post; // load Post model
use DB; // load DB library to use manual sql queries

// get the authenticated user
use Illuminate\Support\Facades\Auth;
use App\User;

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
        // $posts = Post::all();
        
        // $posts = Post::orderBy('title', 'desc')->get();
        // $posts = Post::orderBy('title', 'desc')->take(1)->get();
        // $posts = Post::where('title', 'Post One')->get();
        // $posts = DB::select('SELECT * from posts');

        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);

        // $user_id = Auth::id();
        // $user = User::find($user_id);
        // print_r($user->posts);
        // foreach($user->posts as $post){
        //     print_r($post);
        // }
        // return view('posts.index')->with('posts', $user->posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_imnage' => 'image|nullable|max:1999'
        ]);
            
        // Handle file upload
        if($request->hasFile('cover_image')){
            // get filename with the extention
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // get the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // get just ext
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $filenameToStore = $filename . '_' . time() . '.' . $extention;
            // uppload image
            $path = $request->file('cover_image')->storeAs('public/cover_images/', $filenameToStore);
        }
        else{
            $filenameToStore = 'noimage.jpg';
        }

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = Auth::id();
        $post->cover_image = $filenameToStore;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = POST::find($id);

        // Check for correct user
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error', 'Unathorized Page');
        }

        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        
        // Handle file upload
        if($request->hasFile('cover_image')){
            // get filename with the extention
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // get the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // get just ext
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $filenameToStore = $filename . '_' . time() . '.' . $extention;
            // uppload image
            $path = $request->file('cover_image')->storeAs('public/cover_images/', $filenameToStore);
        }

        // Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $filenameToStore;
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Check for correct user
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error', 'Unathorized Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_images/' . $post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted Successfully');
    }
}
