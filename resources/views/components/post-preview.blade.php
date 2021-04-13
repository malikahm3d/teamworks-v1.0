<div class="m-md-4">
    <div class="row">
        <div class="col-md-10">
            <div class="flex flex-col">
            </div>
            <table class="table table-striped text-center border-2 rounded">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Time</th>
                    <th scope="col">By</th>
                    <th scope="col">in</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td><a class="text-info"
                           href="{{ route('showPost', $post) }}">{{ $post->title }}</a></td>
                    <td>{{ $post->created_at->diffForHumans() }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td><a class="text-info"
                           href="{{ route('postsInACourse', $post->course) }}">{{ $post->course->name }}</a></td>
                    <td class="position-absolute">@include('components.like-button', ['likeables' => 'posts', 'likeable_id' => $post->id, 'likeable'=> $post])</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
