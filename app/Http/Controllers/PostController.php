<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PostController extends Controller
{
    public function index()
    {
        return view('post.index', ['posts' => Post::paginate(5)]);
    }

    public function create()
    {
        return view('post.create', ['categories' => Category::all()]);
    }

    public function save(Request $request)
    {

//        dd($request);
//validate
        $this->validate(
            $request,
            [
                'title' => 'required|max:255',
                'description' => 'required|max:255',
                'price' => 'required|max:255||regex:/^\d+(\.\d{1,2})?$/',
                'category_id' => 'required|integer'
            ]
        );
//        dd($request);

        //create post
        Post::create([
            'user_id' => Auth::id(),
            'category_id' => $request['category_id'],
            'title' => $request['title'],
            'description' => $request['description'],
            'price' => $request['price']

        ]);


        //login user
        auth()->attempt($request->only('email', 'password'));

        foreach ($request->file('images') as $image) {
            $image->store('posts_images');
        }
        //redirect

        return redirect()->route('dashboard');
//        return redirect()->route('home')->middleware('auth');
    }
}
