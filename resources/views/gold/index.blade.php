@extends('layout.master')


@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Gold </h6>
    </div>
    @if (\Session::has('success'))
    <div class="alert alert-success">
        
           {!! \Session::get('success') !!}
        
    </div>
@endif
    <div class="card-body">
       
        <h3>Available Gold: {{ $total }}G</h3>
        <div class="table-responsive">
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exampleModal">
                Maintain Gold
              </button>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($gold as $gold)
                    <tr>
                        
                        <td>{{ $gold->created_at }}</td>
                        <td>{{ $gold->quantity }}G</td>
                        <td > <b class="<?php
                        
                        if($gold->action==2){
                          echo "text-danger";
                        }
                        elseif ($gold->action==3) {
                          echo "text-danger";
                        }else{
                          echo "text-success";
                        }
                        ?>"> 
                        
                        <?php 
                        if($gold->action==1){
                          echo "IN";
                        }
                        if($gold->action==2){
                          echo "OUT";
                        }
                        if($gold->action==3){
                          echo "BUY";
                        }
                        if($gold->action==4){
                          echo "SELL";
                        }

                        ?>  </td></b>
                        <td>
                            <form action="{{route("gold-storage.destroy",['gold_storage'=>$gold->id])}}" method="POST">
                                @csrf
                                @method("delete")
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
          <h5 class="modal-title" id="exampleModalLabel">Add Gold price</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{  route("gold-storage.store") }}" method="post" >
            @csrf
            <div class="form-group">
                <input type="text" name="quantity" id="" placeholder="Quantity in gram" class="form-control"> 
                <br>
                <div class="form-group">
                    <label for="exampleInputPassword1">Action</label>
                    <select name="action" class="form-control" >
                        <option value="">Select</option>
                        <option value="1">In</option>
                        <option value="2">Out</option>
                       
                      </select>
                  </div>   
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection