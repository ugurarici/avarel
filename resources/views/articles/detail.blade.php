@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $article->title }}
                    <a href="{{ route('articles.index') }}" class="float-right btn btn-sm">Geri Dön</a>
                    @auth
                    @if(Auth::user()->can('update', $article))
                    <a href="{{route('articles.edit', $article->id)}}" class="float-right btn btn-sm">Düzenle</a>
                    @endif
                    @endauth
                </div>
    
                <div class="card-body">
                    @if($article->image)
                    <img src="{{asset(Storage::url($article->image))}}" alt="{{ $article->title }}">
                    @endif
                    <p>
                        {{ $article->content }}
                    </p>
                    <hr>
                    @foreach($article->tags as $tag)
                    <a href="{{ route('tag.articles', $tag) }}">
                        {{ $tag->tag }}
                    </a>
                    @endforeach
                    <hr>
                    <small><a href="{{route('profile', $article->user)}}">{{ $article->user->displayname }}</a>, {{ $article->created_at->locale('tr')->diffForHumans() }} ekledi</small>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Yorumlar {{ $article->comments()->count() }}</div>
                <div class="card-body">
                    @guest
                    <p>Yorum yapmak için üye girişi yapmalısınız.</p>
                    @else
                    <form action="{{route('articles.addComment', $article->id)}}" method="post">
                        @csrf
                        <textarea name="comment" class="form-control" placeholder="Yorum yazın"></textarea>
                        <button class="btn btn-primary mt-2">Yorum Ekle</button>
                    </form>
                    @endguest
                    <hr>
                    @include('helpers.comments', ['comments' => $article->topLevelComments])
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
