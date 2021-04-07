<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <h5 class="text-info text-sm-start">By: {{ $post->user->name }}</h5>
                <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                <p class="text-black-50 mt-2 mb-2 border-secondary">{{ $post->title }}</p>
                <p class="text-black-100 mt-2 mb-2 border-secondary text-body">{!! $post->body !!}</p>
                @if($post->file && Route::is('showPost'))
                    <img src="{{$post->file->file_path}}" class="img-fluid">
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
                @can('delete', $post)
                <form action="{{ route('post.delete', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger">Delete post</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
