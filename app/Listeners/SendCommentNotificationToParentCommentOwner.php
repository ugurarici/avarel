<?php

namespace App\Listeners;

use App\Events\ArticleCommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SubCommentReceived;

class SendCommentNotificationToParentCommentOwner
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
    
        if(!is_null($event->comment->parent) && $event->comment->user_id!==$event->comment->parent->user_id){ 
            $event->comment->parent->user->notify(
                new SubCommentReceived($event->comment)
            );
        }
    }
}
