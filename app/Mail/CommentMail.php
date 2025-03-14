<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;
use App\Models\User;
use App\Models\Idea;

class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $user;
    public $idea;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment, User $user, Idea $idea)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->idea = $idea;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Comment On Your Idea',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.comment',
            with:[
                'commentContent' => $this->comment->content,
                'ideaTitle' => $this->idea->title,
                'userName' => $this->comment->is_anonymous ? 'Anonymous' : $this->user->name,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
