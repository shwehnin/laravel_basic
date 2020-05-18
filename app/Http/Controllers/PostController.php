<?php

namespace App\Http\Controllers;

use App\File;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = new Post();
        if(Auth::user()->role == 0){
            $list = $post->latest()->paginate(5);
        }else{
            $list = $post->where("user_id",Auth::user()->id)->latest()->paginate(5);
        }

        return view("post.index",compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("post.create");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            "title"=>"required|unique:posts,title|min:5|max:255",
            "category_id"=>"required|numeric|exists:categories,id",
            "description" => "required|min:15"
        ]);

//        Step 1
        $saveFiles = array();
        if ($request->hasFile('image')) {

            $request->validate([
                'image.*' => 'required|mimes:jpeg,png|max:1000'
            ]);

            $fileArr = $request->image;
            $dir = 'store/';
            $rand = uniqid();

            foreach ($fileArr as $fa) {
                $name = uniqid() . "." . $fa->getClientOriginalExtension();
                $fa->move($dir, $name);
                $location = $dir.$name;
                array_push($saveFiles,$location);
            }

        }
//        Step 2
        $post   = new Post();
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->description = $request->description;
        $post->user_id = Auth::user()->id;
        $post->save();

//        step 3
        if(count($saveFiles) > 0){
            foreach ($saveFiles as $s){
                $file = new File();
                $file->location = $s;
                $file->post_id = $post->id;
                $file->save();
            }
        }

        return redirect()->route("post.index")->with("status","<p class='alert alert-success'>{$request->title} is added</p>");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $info = $post;
        return view("post.show",compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(Auth::user()->role != 0){
            if(Auth::user()->id != $post->user_id){
                return redirect()->back()->with("status","<p class='alert alert-warning'>ဂျင်းမသိပ်ရ</p>");
            }
        }
        $post->delete();
        return redirect()->back()->with("status","<p class='alert alert-success'>မသိဘူး ဖျက်တယ်</p>");
    }
}
