@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Hoşgeldiniz, ahan da sizin yazılarınız;</p>
                    <p>{{ resolve('App\Helpers\Mahmut')->konus() }}</p>
                    <p>{{ request()->path() }}</p>
                    <p>
                        {{ Auth::user()->birth_date }}

                        {{ Auth::user()->age }}
                    </p>
                    <div class="list-group">
                        @foreach($articles as $article)
                        <a href="{{ route('articles.detail', $article->id) }}" class="list-group-item list-group-item-action">
                            {{ $article->title }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
