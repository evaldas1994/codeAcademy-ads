@extends('layout')


@section ('css')

@endsection
<link rel="stylesheet" href={{ asset('css/page/post.css') }}>
@section('page')
    <h2 class="page-title">Create Post</h2>

    <section class="section-user-form">
        <form class="user-form"  method="POST" action={{ route('post.create') }}>
            @csrf

            <div class="title-block">
                <input class="title-input" name="title" type="text" placeholder="Title">
            </div>

            <div class="description-block">
                <textarea class="description-input" name="description" placeholder="Description">

                </textarea>
            </div>

            <div class="price-block">
                <input class="price-input" name="price" type="text" placeholder="Price">
            </div>

            <div class="category-block">
                <select name="category_id" id="category">
                    @foreach($categories as $category)
                    <option value={{ $category->id }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>



            <div class="submit-block">
                <input class="submit" type="submit" value="Submit">
            </div>
        </form>

        @if ($errors->any())
            <div class="notifications">
                <p class="notification-message notification-message-error-title">Login failed!</p>
            </div>
            @foreach ($errors->all() as $error)
                <div class="notifications">
                    <p class="notification-message notification-message-error-item">&#8226; {{ $error }}</p>
                </div>
            @endforeach
            {{--        @else--}}
            {{--            <div class="notifications">--}}
            {{--                <p class="notification-message notification-message-success-title">Registration success</p>--}}
            {{--            </div>--}}
        @endif
    </section>


@endsection
