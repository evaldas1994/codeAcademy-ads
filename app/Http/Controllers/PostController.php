<?php

namespace App\Http\Controllers;

use App\Mail\PostCreated;
use App\Mail\Test;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Service\PostImagesManager;
use App\Service\PostMailService;
use App\Service\PostManager;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PostController extends Controller
{
    const PAGE_SIZE = 5;

    private $postMailService;
    private $postManager;
    private $postImagesManager;

    public function __construct(PostManager $postManager, PostImagesManager $postImagesManager, PostMailService $postMailService)
    {
        $this->middleware('auth', ['except' => ['index']]);
        $this->postManager = $postManager;
        $this->postImagesManager = $postImagesManager;
        $this->postMailService = $postMailService;
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

        if ($request->hasFile('images')) {
            $this->postImagesManager->appendPost($post, $request->file('images'));
        }

        $this->postMailService->informUserPostCreated($request->user(), $post);

        return redirect()->route('dashboard');
    }

    public function destroy(Post $post): RedirectResponse
    {
//        $this->authorize('delete', $post);
        $post->delete();

        return back();
    }
}
