@extends('layouts.app')


@section('content')
<div class="container">
    <h1>
    @if(request()->route()->named('tag.articles'))
        <strong>{{ $tag->tag }}</strong> etiketli makaleler
    @elseif(request()->route()->named('user.articles'))
        <strong>{{ $user->name }}</strong> kişisinin makaleleri
    @else
        Tüm Makaleler
    @endif
    </h1>
    <div class="card-columns">
        @include('helpers.articlecards', ['articles' => $articles])   
    </div>
</div>
@endsection