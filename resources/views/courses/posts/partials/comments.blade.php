@forelse($comments as $comment)
    <div class="display-comment">
        <strong>{{ $comment->user->name }}</strong>
        <p>{{ $comment->body }}</p>
        <a href="" id="reply"></a>
        <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Reply</button>
        </p>
        <div id="multiCollapseExample2" class="collapse">
            <form method="post" action="{{ route('reply.add') }}">
                @csrf
                <div class="form-group">
                    <div class="col-lg-4">
                        <input type="text" name="body" class="form-control mx-sm-3"/>
                    </div>

                    <input type="hidden" name="post_id" value="{{ $post_id }}"/>
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}"/>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;"
                           value="Send reply"/>
                </div>
            </form>
        </div>
        <div class="row-cols-md-4">
            <div class="col-md-12">
                <div class="small text-red-600">
                    @include('courses.posts.partials.comments', ['comments' => $comment->replies])
                </div>
            </div>
        </div>


    </div>
@empty
@endforelse
