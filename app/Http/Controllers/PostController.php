<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('posts', compact('posts'));
    }

    public function store(Request $request)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        // return response
        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil di simpan!',
            'data'      => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post->update([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        return response()->json([
            'success' => true,
            'message'  => 'Data berhasil diupdate!',
            'data'  => $post
        ]);
    }

    public function show(Post $post)
    {
        return response()->json([
            'success'    => true,
            'message'   => 'Detail data Post',
            'data'  => $post
        ]);
    }

    public function destroy($id)
    {
        // delete post by id
        Post::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }
}
