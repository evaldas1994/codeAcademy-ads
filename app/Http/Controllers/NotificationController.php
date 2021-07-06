<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();

        $user = User::find(auth()->user()->id);

        $existingCategoriesIds = [];
        foreach ($user->notifications as $notification) {
            array_push($existingCategoriesIds, $notification->id);
        }

        return view('notification.index', ['categories' => $categories, 'existingCategoriesIds' => $existingCategoriesIds]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::find(auth()->user()->id);
        $user->notifications()->sync($request['category_id']);

        return back();

    }
}
