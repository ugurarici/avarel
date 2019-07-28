@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-columns">

        <div class="card text-center">
            <div class="card-body">
                @if($user->profileimage)
                <img src="{{asset(Storage::url($user->profileimage))}}" class="img-thumbnail w-50 mb-3 shadow" style="margin-top:-35px;">
                @endif
                <h5 class="card-title">{{$user->displayname}}</h5>
                <p class="card-text">{{$user->name}}</p>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info text-white">{{$user->followers()->count()}}<br><small>Takipçi</small>
                    </button>
                    <button type="button" class="btn btn-info text-white">{{$user->followees()->count()}}<br><small>Takip Edilen</small></button>
                    <button type="button" class="btn btn-info text-white">{{$user->articles()->count()}}<br><small>Gönderi</small></button>
                </div>
                @if(Auth::id()===$user->id)
                <div class="mt-3">
                <a href="{{route('articles.create')}}" class="btn btn-sm btn-primary">Yeni Gönderi</a> <a href="#" class="btn btn-sm btn-primary" onclick="event.preventDefault();document.getElementById('editProfileForm').classList.toggle('d-none')">Profili Düzenle</a>
                </div>
                
                <form action="{{route('profile.update')}}" class="my-2 d-none" id="editProfileForm" method="post" enctype="multipart/form-data">
                    @csrf
                <hr>
                    <h5>Profili Düzenle</h5>
                    <div class="form-group">
                        <label>Görünen İsim</label>
                        <input type="text" class="form-control" name="displayname" value="{{$user->displayname}}">
                    </div>
                    <div class="form-group">
                        <label>Doğum Tarihi</label>
                        <input type="date" class="form-control" name="birth_date" value="{{$user->birth_date->format('Y-m-d')}}">
                    </div>
                    <div class="form-group">
                        <label>Profil Fotoğrafı</label>
                        <input type="file" name="profileimage">
                    </div>
                    <button class="btn btn-primary btn-block">Profili Güncelle</button>
                </form>
                @elseif(Auth::check())
                    @if(Auth::user()->isFollowing($user))
                    <a href="{{route('unfollow', $user)}}" class="btn btn-success mt-3">Takip Ediyorsun</a>
                    @else
                    <a href="{{route('follow', $user)}}" class="btn btn-outline-success mt-3">Takip Et</a>
                    @endif
                @endif
            </div>
        </div>
        @include('helpers.articlecards', ['articles' => $user->articles()->latest()->get()])  
    </div>
</div>
@endsection