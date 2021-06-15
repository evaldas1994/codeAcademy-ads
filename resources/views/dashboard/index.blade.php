@extends('layout')

@section ('css')
    <link rel="stylesheet" href={{ asset('css/page/post.css') }}>
@endsection

@section ('page')
    <h2 class="page-title">Dashboard</h2>

    <section class="section-dish-cards-list">

        <div class="card card-for-actions">
            <form action={{ route('dashboard') }} method="post">
                @csrf

                <div class="card-for-actions-item">
                    <a class="card-for-actions-item-add" href="{{ route('post.create') }}"> + </a>
                </div>

                <div class="card-for-actions-item">
                    <select name="status" class="card-for-actions-item-action">
                        <option {{ app('request')->input('status') === null ? 'selected' : '' }}>---</option>
                        <option value="active" {{ app('request')->input('status') === 'active' ? 'selected' : '' }} >Active</option>
                        <option value="inactive" {{ app('request')->input('status') === 'inactive' ? 'selected' : '' }} >Inactive</option>
                        <option value="closed" {{ app('request')->input('status') === 'closed' ? 'selected' : '' }} >Closed</option>
                    </select>
                </div>

                <div class="card-for-actions-item">
                    other
                </div>

                <div class="card-for-actions-item">
                    other
                </div>

                <div class="card-for-actions-item-last">
                    <button class="card-for-actions-item-last-button" type="submit">Filter</button>
                </div>
            </form>
        </div>


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
