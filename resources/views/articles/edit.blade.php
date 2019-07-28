@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Makale Düzenle</div>
    
                <div class="card-body">
                    <form action="{{ route('articles.update', $article->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Başlık</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$article->title}}">
                            @error('title')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>İçerik</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{$article->content}}</textarea>
                            @error('content')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Etiketler</label>
                            <input type="text" name="tags" class="form-control" value="{{$article->tags->implode('tag', ',')}}">
                        </div>


                        <div class="form-group">
                            <button class="btn btn-primary btn-block btn-lg">Makaleyi Düzenle</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
