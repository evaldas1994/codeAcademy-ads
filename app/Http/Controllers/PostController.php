<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PostController extends Controller
{
    public function index()
    {
        return view('post.index', ['posts' => Post::paginate(5)]);
    }

    public function create()
    {
        return view('post.create', ['categories' => Category::where('is_active', true)->get()]);
    }

    public function save(Request $request)
    {

//        dd($request);
//validate
        Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required||regex:/^\d+(\.\d{1,2})?$/',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'mimes:jpg,jpeg,png|max:400',
            'images' => 'max:5',
        ], [
            'images.max' => 'Cannot upload more than 5 files.',]
    );
//        $this->validate(
//            $request,
//            [
//                'title' => 'required|max:255',
//                'description' => 'required',
//                'price' => 'required||regex:/^\d+(\.\d{1,2})?$/',
//                'category_id' => 'required|exists:categories,id',
//                'images.*' => 'mimes:jpg,jpeg,png|max:400',
//                'images' => 'max:5',
//            ]
//        );
//        dd($request);

        //create post
//        Post::create([
//            'user_id' => Auth::id(),
//            'category_id' => $request['category_id'],
//            'title' => $request['title'],
//            'description' => $request['description'],
//            'price' => $request['price']
//
//        ]);


        //login user
//        auth()->attempt($request->only('email', 'password'));

        $post = $request->user()->posts()->create(
            array_merge($request->only([
                'title', 'description', 'price', 'category_id'
            ]), ['show_phone_number' => $request->has('show_phone_number')])
        );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->storePublicly('images', 'public');
                //$image->store('posts_images');
                $post->images()->create([
                    'file_path' => $path
                ]);
            }
        }
        //redirect

        return redirect()->route('dashboard');
//        return redirect()->route('home')->middleware('auth');
    }
}
