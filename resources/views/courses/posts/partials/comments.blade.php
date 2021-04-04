@forelse($comments as $i => $comment)
    <div class="border rounded p-2 m-2">
        <strong class="font-light">{{ $comment->user->name }}</strong>
        <p class="text-lg" id="test">{{ $comment->body }}   {{$i}}</p>

    @if($comment->parent_id == null)
{{--        if statement to only allow one reply--}}
        <button class="btn btn-outline-primary btn-sm py-0 mb-2" style="font-size: 0.8em" type="button"
                data-toggle="collapse" data-target="#collapse_target_{{$i}}" aria-expanded="false"
                aria-controls="multiCollapseExample2">Reply
        </button>

        <div id="collapse_target_{{$i}}" class="collapse">
            <form method="post" action="{{ route('reply.add') }}">
                @csrf
                <div class="col-lg-4">
                    <input type="text" name="body" class="form-control mx-sm-3"/>
                    <input type="hidden" name="post_id" value="{{ $post_id }}"/>
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
    @endif
    </div>
@empty
@endforelse
