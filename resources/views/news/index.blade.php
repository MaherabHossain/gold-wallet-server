@extends('layout.master')


@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
    </div>
    @if (\Session::has('success'))
    <div class="alert alert-success">
        
           {!! \Session::get('success') !!}
        
    </div>
@endif
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exampleModal">
                Add News
              </button>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($news as $news)
                    <tr>
                        
                        <td><img src="{{ asset($news->image_url) }}" height="100" width="150" alt=""></td>
                        <td>{{  $news->title }}</td>
                        <td>{{   substr($news->description, 0, 30). " ... "  }}</td>
                        <td>
                            <form action="{{route("news.destroy",['news'=>$news->id])}}" method="POST">
                                @csrf
                                @method("delete")
                                <input type="hidden" value={{$news->id}} name="id">
                                <a href="{{ route("news.edit",['news'=>$news->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                <button onclick="return confirm('Are you sure')" class="btn btn-danger mb-1 btn-sm"> <i class="fa fa-trash"></i> </button>
                           </form>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add News</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{  route("news.store") }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="title" id="" placeholder="Title" class="form-control">
                <br>
                <textarea name="description" placeholder="Description" class="form-control"  id="" cols="10" rows="3"></textarea>
                <br>
                <input type="file" name="image" id="" class="form-control" accept="image/png, image/gif, image/jpeg" >
            </div>
            
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add News</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection