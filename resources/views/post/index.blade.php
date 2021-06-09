@extends('layout')


@section ('css')

@endsection
<link rel="stylesheet" href={{ asset('css/page/post.css') }}>
@section('page')
    <h2 class="page-title">Posts</h2>
    <div class="submit-block">
        <a href={{ route('post.create') }}> <input class="submit" type="submit" value="Submit"> </a>
    </div>

    <section class="section-dish-cards-list">
        @if($posts->count() > 0)

            @foreach($posts as $post)

                <div class="card">
                    <div class="card-main">
                        <div class="card-main-dish-title">
                            <h3>{{ $post->title }}</h3>
                        </div>
                        <img class="card-main-dish-img" src="img/dish-1.jpg" alt="dish-img">

                    </div>

                    <div class="card-info">
                        <p class="card-info-item"><i class="fas fa-coins"></i>{{ $post->price }}&euro;</p>
                        <p class="card-info-item"><i class="fas fa-coins"></i>{{ $post->status }}</p>
                        <p class="card-info-item"><a class="card-info-item-link" href="#"><i class="far fa-arrow-alt-circle-down"></i>Miestas</a></p>
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
