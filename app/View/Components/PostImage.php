<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

class PostImage extends Component
{
    public function getImagePath(Post $post): string
    {
        return asset('storage/' . $post->images()->first()->file_path);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-image');
    }
}
