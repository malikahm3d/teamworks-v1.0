<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <h5 class="text-info text-sm-start">By: {{ $post->user->name }}</h5>
                <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                <p class="text-black-50 mt-2 mb-2 border-secondary">{{ $post->title }}</p>
                <p class="text-black-100 mt-2 mb-2 border-secondary text-body">{!! $post->body !!}</p>
                <p class="card-text">
                    <small class="text-info text-sm-start"><a href="{{ route('postsInACourse', $post->course) }}">
                            In: {{ $post->course->name }}</a></small>
                    <small class="text-info text-sm-start"><a href="{{ route('showPost', $post) }}">
                            More Info</a></small>
                </p>
            </div>
        </div>
    </div>
</div>
