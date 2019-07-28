@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Yeni Makale</div>
    
                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Başlık</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>İçerik</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10"></textarea>
                            @error('content')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Görsel</label>
                            <input type="file" name="image" class="@error('image') is-invalid @enderror">
                            @error('image')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Etiketler</label>
                            <input type="text" name="tags" class="form-control @error('tags') is-invalid @enderror" placeholder="etiketleri virgülle ayırınız">
                            @error('tags')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-block btn-lg">Makaleyi Ekle</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
