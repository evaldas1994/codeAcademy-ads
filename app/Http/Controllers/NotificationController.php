<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $categories = Category::all();
//        dd($categories);
        return view('notification.index', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        dd($request['category_id']);
    }
}
