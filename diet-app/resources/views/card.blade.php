<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>Laravel</title>

    </head>
    <body>

        <div class="card-body pt-0 pb-2">
            <h3 class="h4 card-title">
            <a class="text-dark" href="{{ route('articles.show', ['article' => $article]) }}">
                {{ $article->title }}
            </a>
            </h3>
            <div class="card-text">
            {!! nl2br(e( $article->body )) !!}
            </div>
        </div>
        
        <div class="card-body pt-0 pb-2 pl-3">
            <div class="card-text">
            <article-like
                :initial-is-liked-by='@json($article->isLikedBy(Auth::user()))'
                :initial-count-likes='@json($article->count_likes)'
                :authorized='@json(Auth::check())'
                endpoint="{{ route('articles.like', ['article' => $article]) }}"
            >
            </article-like>
            </div>
        </div>     

    </body>
</html>
