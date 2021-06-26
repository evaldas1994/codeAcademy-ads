<?php


namespace App\Service;


use App\Models\Post;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostManager
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(User $user, array $data): Post
    {
        $dateEnd = (new DateTime('+ 60day'))->format('Y-m-d');
        Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required|max:4000',
            'price' => 'required||regex:/^\d+(\.\d{1,2})?$/|min:0|max:999999',
            'category_id' => 'required|exists:categories,id',
            'expires_at' => ['required','date_format:Y-m-d', 'after:today', sprintf('before_or_equal: %s', $dateEnd)],
        ])->validate();

        return $user->posts()->create($data);
    }
}
