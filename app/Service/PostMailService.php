<?php


namespace App\Service;


use App\Mail\PostCreated;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PostMailService
{
    public function informUserPostCreated(User $user, Post $post): void
    {
        Mail::to($user)->send(new PostCreated($post));
    }
}
