<?php


namespace App\Service;


use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostManager
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(User $user, array $data): Post
    {
        Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required||regex:/^\d+(\.\d{1,2})?$/',
            'category_id' => 'required|exists:categories,id',
            'expires_at' => 'date_format:Y-m-d|after:today',
        ])->validate();

        return $user->posts()->create($data);
    }
}
