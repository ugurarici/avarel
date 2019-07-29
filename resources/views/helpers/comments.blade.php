@foreach($comments as $comment)
<div class="media mt-3">
    <a href="{{route('profile', $comment->user)}}">
        <img src="{{asset(Storage::url($comment->user->profileimage))}}" class="mr-3 img-thumbnail" alt="{{$comment->user->displayname}}" style="width:50px;">
    </a>
    <div class="media-body">
        <a href="{{route('profile', $comment->user)}}">
        <h5 class="mt-0">{{$comment->user->displayname}}</h5>
        </a>
        <p>{{ $comment->body }}<p>
        <span class="text-mute">{{$comment->created_at->locale('tr')->diffForHumans()}}
        @auth - <a data-toggle="collapse" href="#collapseReplyForm{{$comment->id}}" aria-expanded="false" aria-controls="collapseReplyForm{{$comment->id}}">Yanıtla</a>@endauth</span>
        @auth
        <form action="{{route('articles.addComment', $article->id)}}" method="post" class="collapse" id="collapseReplyForm{{$comment->id}}">
            @csrf
            <input type="hidden" name="parent_id" value="{{$comment->id}}">
            <textarea name="comment" class="form-control" placeholder="Yanıt yazın"></textarea>
            <button class="btn btn-primary mt-2">Yanıtla</button>
        </form>
        @endauth
        @includeWhen($comment->children->isNotEmpty(), 'helpers.comments', ['comments' => $comment->children])
    </div>
</div>
@endforeach