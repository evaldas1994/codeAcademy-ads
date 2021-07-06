<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $user = User::find(auth()->user()->id);

        $existingCategoriesIds = [];
        foreach ($user->notifications as $notification) {
            array_push($existingCategoriesIds, $notification->id);
        }

        return view('notification.index', ['categories' => $categories, 'existingCategoriesIds' => $existingCategoriesIds]);
    }

    public function store(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->notifications()->sync($request['category_id']);

        return back();

    }
}
