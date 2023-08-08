<div class="container">
    <form action="{{ url('createcomment') }}" method="POST">
        @csrf
        <h2>Post your comment</h3>
            <div class="mb-3">
                <input class="form-control" type="text" name="content" placeholder="Enter your comment" required />
                <input type='hidden' name="post_id" value='{{ $post->id }}' />
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>

    @include('components.errors')
    @include('components.status')



</div>
