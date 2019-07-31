<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Article;
use App\Comment;

class ArticleCommentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article;
    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Article $injectedArticle, Comment $injectedComment)
    {
        $this->article = $injectedArticle;
        $this->comment = $injectedComment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
