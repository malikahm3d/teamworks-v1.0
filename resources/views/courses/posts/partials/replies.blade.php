{{--@forelse($replies as $reply)--}}
{{--    <div class="row-cols-md-4">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="text-red-600">--}}
{{--                <div class="" id="mainn">--}}
{{--                    <div class="display-comment ">--}}
{{--                        <div class="border rounded p-2 m-2"><strong>{{ $reply->user->name }} {{ $reply->parent_id }}</strong>--}}
{{--                            <p class="text-lg">{{ $reply->body }}</p></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--            <button class="btn btn-outline-primary btn-sm py-0 mb-2" style="font-size: 0.8em" type="button"--}}
{{--                    data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false"--}}
{{--                    aria-controls="multiCollapseExample2">Reply--}}
{{--            </button>--}}
{{--            <button id="hidee">hide</button>--}}
{{--            <div id="multiCollapseExample2" class="collapse">--}}
{{--                <form method="post" action="{{ route('reply.add') }}">--}}
{{--                    @csrf--}}
{{--                    <div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <input type="text" name="body" class="form-control mx-sm-3"/>--}}
{{--                        </div>--}}

{{--                        <input type="hidden" name="post_id" value="{{ $post_id }}"/>--}}
{{--                        <input type="hidden" name="comment_id" value="{{ $comment->id }}"/>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <input type="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;"--}}
{{--                               value="Add Reply"/>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}

{{--            <div class="row-cols-md-4">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="text-red-600">--}}
{{--                        @include('courses.posts.partials.replies', ['replies' => $reply->replies])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--@empty--}}
{{--@endforelse--}}
