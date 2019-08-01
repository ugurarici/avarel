<?php

namespace App\Listeners;

use App\Events\ArticleCommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ArticleCommentReceived;

class SendCommentNotificationToArticleOwner implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleCommentCreated  $event
     * @return void
     */
    public function handle(ArticleCommentCreated $event)
    {
        if(is_null($event->comment->parent_id) && $event->article->user->id!==$event->comment->user->id)
            $event->article->user->notify(
                new ArticleCommentReceived($event->article, $event->comment->user)
            );
    }
}
