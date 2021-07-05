<?php

namespace App\Http\Controllers;


use App\Events\PostCreated;
use App\Models\Category;
use App\Models\Post;
use App\Service\PostImagesManager;
use App\Service\PostManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class PostController extends Controller
{
    const PAGE_SIZE = 5;

    private $postManager;
    private $postImagesManager;

    public function __construct(PostManager $postManager, PostImagesManager $postImagesManager)
    {
        $this->middleware('auth', ['except' => ['index']]);
        $this->postManager = $postManager;
        $this->postImagesManager = $postImagesManager;
    }

    public function index()
    {
//        dd('PostController@index');
        return view('post.index', ['posts' => Post::paginate(5)]);
    }

    public function create()
    {
        return view('post.create', ['categories' => Category::where('is_active', true)->get()]);
    }

    public function save(Request $request): RedirectResponse
    {
        $data = array_merge(
            $request->only([
                'title', 'description', 'price', 'category_id', 'expires_at'
            ]),
            ['show_phone_number' => $request->has('show_phone_number')]

        );

        $post = $this->postManager->create($request->user(), $data);

        PostCreated::dispatch($post);

        if ($request->hasFile('images')) {
            $this->postImagesManager->appendPost($post, $request->file('images'));
        }

        return redirect()->route('dashboard');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();

        return back();
    }
}
