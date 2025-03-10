<div>
    <h1>New Comment On Your Idea</h1>
    <p>Hello {{ $comment->idea->user->name }},</p>
    <p>A new comment has been added to your idea:</p>
    <p>{{ $comment->content }}</p>
    <p>You can view the idea by clicking <a href="{{ route('idea.show', $comment->idea->slug) }}">here</a>.</p>
</div>