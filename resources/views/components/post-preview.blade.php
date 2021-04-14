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
