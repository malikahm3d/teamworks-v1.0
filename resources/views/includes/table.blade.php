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
                @foreach($posts as $post)
                    <x-PostPreview :post="$post"/>
                @endforeach
            </table>
        </div>
    </div>
</div>
