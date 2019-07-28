@foreach($comments as $comment)
<div class="media mt-3">
    <a class="mr-3" href="#">
        <img src="..." class="mr-3" alt="{{$comment->user->name}}">
    </a>
    <div class="media-body">
        <h5 class="mt-0">{{$comment->user->name}}</h5>
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
        @includeWhen($comment->children, 'helpers.comments', ['comments' => $comment->children])
    </div>
</div>
@endforeach