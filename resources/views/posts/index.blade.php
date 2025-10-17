@extends('layouts.app')
@section('title')index @endsection
@section('content')
    
<div class="text-center">
<a href="{{ route('posts.create') }}" class="btn btn-outline-success" disabled>Create Post</a>

            </div>
        </div>
            <div class= "container mt-5">
        <table class="table table-bordered" mt-4>
          
            <thead>
              <tr class="table-danger">
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Posted By</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              
              @foreach ($posts as $post)
              <tr>
                
                <td>{{  $loop->iteration }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->user ? $post->user->name :"not found" }}</td>
                <td>{{ $post->user ? $post->user->created_at :"not found" }}</td>
                <td>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-outline-info">View</a>
                    <a href="{{route('posts.edit', $post->id)}}" class="btn btn-outline-primary">Edit</a>
                    <form style="display :inline;" method="POST" action="{{ route('posts.destroy', $post->id) }}">
                      @csrf
                      @method('DELETE')
                    <button type="submit"  class="btn btn-outline-danger" onclick="return confirmSubmit(event);">Delete</button>
                    </form> 
                    
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
              
            </div>
          </div>
          <script>
            function confirmSubmit(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "This delete will be permanent.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.closest('form').submit(); // Submit the form
                    } else {
                        Swal.fire("Your post is safe!");
                    }
                });
            }
        </script>
</html> 

@endsection