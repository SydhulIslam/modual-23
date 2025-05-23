<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRwquest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'Posts retrieved successfully',
            'status' => 200,
        ], 200);


    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRwquest $request)
    {


        $data = $request->validated();

        $post = Post::create($data);

        // return $post;
        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post created successfully',
            'status' => 201,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        if(!$post) {
            return response()->json([
                'message' => 'Post not found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'data' => PostResource::collection($post),
            'message' => 'Post retrieved successfully',
            'status' => 200,
        ], 200);
    }






    /**
     * Update the specified resource in storage.
     */
    public function update(PostRwquest $request, string $id)
    {
        $post = Post::findOrFail($id);

        if(!$post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

       $data = $request->validated();

        $post->update($data);

        return response()->json([
            'data' => PostResource::collection($post),
            'message' => 'Post updated successfully',
            'status' => 200,
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if(!$post) {
           return response()->json([
                'message' => 'Post not found',
                'status' => 404,
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted',
            'status' => 200,
        ], 200);


    }
}
