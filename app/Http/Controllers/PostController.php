<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class PostController extends Controller
{

    public function index()
    {
        $post = Post::all();
        return response()->json($post , 200);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:50',
            'slug' => 'required|unique:posts',
            'image' => 'required|file',
            'caption' => 'required|string|max:500',
        ]);

        $imageName = time().'_'. Str::slug($request->slug) .'.'. $request->image->extension();
        $data['title'] = $request->title;
        $data['slug'] =  Str::slug($request->slug);
        $data['image'] = 'images/posts/'.$imageName.'';
        $data['caption'] = $request->caption;
        $data['user_id'] = auth()->user()->id;
        $post = Post::create($data);
        $request->image->move(public_path('images/posts') , $imageName);

        return response()->json($post , 200);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post){

            return response()->json(['message' => 'there is no post with id = '.$id]);
        }else {
            $validateData = $request->validate([
                'title' => 'required|string|max:50',
                'slug' => ['required' , Rule::unique('posts', 'slug')->ignore($post->id)],
                'image' => 'required|file',
                'caption' => 'required|string|max:500',
            ]);


        }
    }

    public function destroy($id)
    {

        $post = Post::find($id);
        if (!$post){

            return response()->json('There is no post with id = '.$id);
        }else {
            $postImage = $post->image;
            unlink($postImage);
            $post->delete();

            return response()->json('Post has been deleted', 200);
        }
    }
}
