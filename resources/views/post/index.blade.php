@extends('layout')


@section ('css')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href={{ asset('css/page/post.css') }}>
@endsection

@section('page')
    <h2 class="page-title">Posts</h2>

    <section class="section-dish-cards-list">

            <div class="card add-new-post">
                <a class="" href={{ route('post.create') }}>
                <div class="card-main">
                    <div class="card-main-dish-title">
                        <h3 class="add-dish">+</h3>
                    </div>
                    <!-- <img class="card-main-dish-img" src="" alt="dish-img"> -->

                </div>

                <div class="card-info">
                    <p class="card-info-item">Pridėti naują</p>
                </div>
                </a>
            </div>


        @if($posts->count() > 0)

            @foreach($posts as $post)

                <div class="card">
                    <div class="card-main">
                        <div class="card-main-dish-title">
                            <h3>{{ $post->title }}</h3>
                        </div>

                        {{--                        <x-post_image :post="$post"></x-post_image>--}}
                        {{--                        <img class="card-main-dish-img" src="{{ asset('storage/'. $post->images()->first()->file_path) }}" alt="dish-img">--}}
                        @include('components.post_image')
                    </div>

                    <div class="card-info">
                        <p class="card-info-item"><i class="fas fa-coins"></i>{{ $post->price }}&euro;</p>
                        <p class="card-info-item"><i class="fas fa-coins"></i>{{ $post->status }}</p>
                        <p class="card-info-item"><a class="card-info-item-link" href="#">Miestas</a></p>

                        {{--                        @if($post->user->id !== auth()->user()->id)--}}
                        @if($post->starredBy(auth()->user()))
                            <form action="{{ route('posts.stars', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="post-star-button" type="submit"><i class="fas fa-star"></i></button>
                            </form>
                        @else
                            <form action="{{ route('posts.stars', $post) }}" method="POST">
                                @csrf
                                <button class="post-star-button" type="submit"><i class="far fa-star"></i></button>
                            </form>
                        @endif
                        {{--                        @endif--}}
                        <form action="{{ route('post.delete', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="post-star-button" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach

        @else
            no post yet
        @endif
    </section>

    <section class="section-page-paginate">
        {{ $posts->links() }}
    </section>
@endsection
