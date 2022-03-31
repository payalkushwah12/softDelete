<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('trashed')) {
            $posts = Post::onlyTrashed()
                ->get();
        } else {
            $posts = Post::get();
        }

        return view('posts', compact('posts'));
    }
  
    /**
     * soft delete post
     *
     * @return void
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
  
        return redirect()->back();
    }
  
    /**
     * restore specific post
     *
     * @return void
     */
    public function restore($id)
    {
        Post::withTrashed()->find($id)->restore();
  
        return redirect()->back();
    }  
  
    /**
     * restore all post
     *
     * @return response()
     */
    public function restoreAll()
    {
        Post::onlyTrashed()->restore();
  
        return redirect()->back();
    }
}

