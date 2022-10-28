@extends('layout.master')


@section('content')
    <div class="card-body ">
        <div class="row">
           <div class="col-md-6">
            <form action="{{  route("news.update",['news'=>$news->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <input type="text" name="title" id="" placeholder="Title" class="form-control" value="{{ $news->title }}">
                    <br>
                   
                    <textarea name="description"   placeholder="Description" class="form-control"  id="" cols="10" rows="3">{{ $news->description }}</textarea>
                    <br>
                    <img src="{{ asset($news->image_url) }}" class="mb-3" alt="" height="100" width="150">
                    <br>
                    <input type="file" name="image" id="" class="form-control" accept="image/png, image/gif, image/jpeg" >
                </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
           </div>
        <div></div>
        </div>
    </div>
@endsection