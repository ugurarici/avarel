<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Article;
use App\User;

class ArticleCommentReceived extends Notification
{
    use Queueable;

    protected $article;
    protected $commenter;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Article $article, User $user)
    {
        $this->article=$article;
        $this->commenter=$user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->commenter->displayname . ', ' . $this->article->title . ' makalenize yorum yaptı',
            'action' => route('articles.detail', $this->article)
        ];
    }
}
