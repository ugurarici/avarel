@forelse($articles as $article)
<div class="card">
    @if($article->image)
    <a href="{{route('articles.detail', $article)}}">
        <img src="{{asset(Storage::url($article->image))}}" class="card-img-top" alt="{{$article->title}}">
    </a>
    @endif
    <div class="card-body">
        <a href="{{route('articles.detail', $article)}}">
            <h5 class="card-title">{{$article->title}}</h5>
        </a>
        <p class="card-text">{{ $article->summary }}</p>
        <p class="card-text">
            <small class="text-muted">
                <a href="{{route('profile', $article->user)}}">
                    @if($article->user->profileimage)
                    <img src="{{asset(Storage::url($article->user->profileimage))}}" height="30" class="d-inline-block align-middle rounded-circle">
                    @endif
                    {{$article->user->displayname}}
                </a>
            </small>
            <small class="text-muted float-right">{{$article->created_at->diffForHumans()}}</small>
        </p>
    </div>
</div>
@empty
Yok ki :(
@endforelse