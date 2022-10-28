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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Nid No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Nid No</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{  $user->name }}</td>
                        <td>{{  $user->email }}</td>
                        <td>{{  $user->nid_no }}</td>
                        <td>
                            <form action="{{route("users-delete",)}}" method="POST">
                                @csrf
                                @method("delete")
                                <input type="hidden" value={{$user->id}} name="id">
                                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
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
@endsection