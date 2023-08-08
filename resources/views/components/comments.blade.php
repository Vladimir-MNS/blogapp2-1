<div class="position-relative p-5 text-center text-muted bg-body border border-dashed rounded-5 mb-4">

    @foreach ($post->comments as $comment)
        <small>{{ $comment->user->name }}</small>
        <p>{{ $comment->content }}</p>
        @if (auth()->user() && auth()->user()->id === $comment->user->id)
            <form action="{{ url('deletecoment') }}" method='POST'>
                @method('DELETE')
                <input type="hidden" value="{{ $comment->id }}">
            </form>
            <button>delete</button>
        @endif
    @endforeach

</div>
