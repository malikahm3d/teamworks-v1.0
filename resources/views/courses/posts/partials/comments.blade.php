@forelse($comments as $i => $comment)
    <div id="test" class="border rounded p-2 m-2 mb-2">
        <strong class="font-light">{{ $comment->user->name }}</strong>
        <p class="text-lg" id="comment_body">{{ $comment->body }}</p>
        @include('components.like-button', ['likeables' => 'comments', 'likeable_id' => $comment->id, 'likeable'=> $comment->likeableWithLikes($comment->id)->firstOrFail()])
        @if($post->owner(auth()->user()) && !isset($post->comment_id))
            <form action="{{ route('post.answer') }}" method="POST" class="m-2 d-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                <input type="hidden" id="comment_id" name="comment_id" value="{{ $comment->id }}">
                <button type="submit" id="close_thread" class="btn-info btn-sm">Does this Answer your Question?</button>
            </form>
        @endif

        <button
            class="btn btn-outline-primary btn-sm py-0 mb-2" style="font-size: 0.8em" type="button"
            data-toggle="collapse" data-target="#collapse_target_{{$comment->id}}" aria-expanded="false"
            aria-controls="multiCollapseExample2">
            Reply
        </button>

        <div id="collapse_target_{{$comment->id}}" class="collapse">
            <form method="post" action="{{ route('reply.add') }}">
                @csrf
                <div class="col-lg-4">
                    <input type="text" name="body" class="form-control mx-sm-3"/>
                    <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}"/>
                    <input type="submit" class="btn btn-sm btn-outline-danger py-0 mx-sm-3"
                           style="font-size: 0.8em;"
                           value="Add Reply"/>
                </div>
            </form>
        </div>
        <div class="row-cols-md-4">
            <div class="col-md-12">
                @include('courses.posts.partials.comments', ['comments' => $comment->replies])
            </div>
        </div>
    </div>
@empty
@endforelse
