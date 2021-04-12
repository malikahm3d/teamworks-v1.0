<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <h5 class="text-info text-sm-start">By: {{ $post->user->name }}</h5>
                <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                <p class="text-black-50 mt-2 mb-2 border-secondary">{{ $post->title }}</p>
                <p class="text-black-100 mt-2 mb-2 border-secondary text-body">{!! $post->body !!}</p>
                {{--                TODO post body not rendering html tags--}}
                @if($post->file)
                    @if($post->file && Route::is('showPost'))
                        <button
                            class="btn btn-outline-dark btn-sm py-0 mb-2" style="font-size: 0.8em" type="button"
                            data-toggle="collapse" data-target="#collapse_target" aria-expanded="false"
                            aria-controls="multiCollapseExample2">
                            Show files
                        </button>
                        @foreach($post->file as $post->file)
                            @if(str_ends_with($post->file->file_path, "png") ||
                                str_ends_with($post->file->file_path, "jpg") ||
                                str_ends_with($post->file->file_path, "jpeg"))
                                <div id="collapse_target" class="collapse">
                                    <img src="{{$post->file->file_path}}" class="img-fluid" alt="">
                                </div>
                            @else
                                <div id="collapse_target" class="collapse">
                                    <a href="{{$post->file->file_path}}" class="link-primary" target="_blank">Download {{$post->file->name}}</a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endif
                <p class="card-text">
                    @if(!Route::is('postsInACourse'))
                        <small class="text-info text-sm-start"><a href="{{ route('postsInACourse', $post->course) }}">
                                In: {{ $post->course->name }}</a></small>
                    @endif
                    @if(!Route::is('showPost'))
                        <small class="text-info text-sm-start"><a href="{{ route('showPost', $post) }}">
                                More Info</a></small>
                    @endif
                </p>
                @if(Route::is('showPost'))
                    @can('delete', $post)
                        <form action="{{ route('post.delete', $post) }}" method="POST" class="m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-danger">Delete post</button>
                        </form>
                    @endcan
                    @can('update', $post)
                        <form action="{{ route('post.showEdit', $post) }}" method="GET" class="m-2">
                            <button type="submit" class="btn-sm btn-info text-center">Edit post</button>
                        </form>
                        {{-- <a href="{{ route('post.showEdit', $post) }}" class="btn-sm btn-info">Edit post</a>--}}
                    @endcan
                @endif
                @include('components.like-button', ['likeables' => 'posts', 'likeable_id' => $post->id, 'likeable'=> $post])
            </div>
        </div>
    </div>
</div>
