<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //get logged in user
        $user = auth()->user();

        //get user posts
        $posts = Post::where('user_id', $user['id'])->get();

//        dd($user->posts()->get());
        return view('dashboard.index');
    }
}
