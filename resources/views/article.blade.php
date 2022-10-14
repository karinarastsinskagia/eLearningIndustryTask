@extends('layout')

@section('content')

    <body>

    <h1>Articles List</h1>

    <article>
        <a href="/articles/{{$article->id}}">
            <h2> {{ $article->title }} </h2>
        </a>

        <div> Published at : {{$article->created_at}}</div>

        @if (!empty($article->category_id))

            <div> Category : {{$article->category->name}}</div>
        @endif

        <div> Owner : {{$article->user->name}}</div>

        <p> Content : {{$article->content}}</p>

    </article>

    <a href="/articles">Go back</a>

    </body>

@endsection

