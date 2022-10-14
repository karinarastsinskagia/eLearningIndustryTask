@extends('layout')



@section('content')

    <body>

    <h1>Articles List</h1>

    <div class ="mt-8 md:mt-0">
        @auth

            <span class="text-xs font-bold uppercase">Welcome, {{ auth()->user()->name }}!</span>

            <form mehod="GET" action="/logout">
                @csrf

                <button type="submit">Logout</button>
            </form>
        @else

            <a href="/register" class="text-xs font-bold uppercase">Register</a>
        @endauth
    </div>


    @foreach ($articles as $article)

        <article>
            <a href="/articles/{{$article->id}}">
                <h2> {{ $article->title }} </h2>
            </a>

            <div> Published at : {{$article->created_at}}</div>

            @if (!empty($article->category_id))

                <div>
                    <a href="/categories/{{$article->category->name}}">

                        Category : {{$article->category->name}}

                    </a>
                </div>
            @endif

            <div> Owner : {{$article->user->name}}</div>

            <p> Content : {{$article->content}}</p>

        </article>

    @endforeach

    <div>{{ $articles->links()}}</div>
    </body>

@endsection

