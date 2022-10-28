@extends('layout.master')


@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Gold Price</h6>
    </div>
    @if (\Session::has('success'))
    <div class="alert alert-success">
        
           {!! \Session::get('success') !!}
        
    </div>
@endif
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exampleModal">
                Add Gold
              </button>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Buy price</th>
                        <th>Sell price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Buy price</th>
                        <th>Sell price</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($goldPrice as $goldPrice)
                    <tr>
                        
                        <td>{{ $goldPrice->date }}</td>
                        <td>{{ $goldPrice->buy_price }}</td>
                        <td>{{ $goldPrice->sell_price }}</td>
                        <td>
                            <form action="{{route("gold.destroy",['gold'=>$goldPrice->id])}}" method="POST">
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
          <h5 class="modal-title" id="exampleModalLabel">Add News</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{  route("gold.store") }}" method="post" >
            @csrf
            <div class="form-group">
                <input type="text" name="buy_price" id="" placeholder="Buy price" class="form-control">
                <br>
                <textarea name="sell_price" placeholder="Sell Price" class="form-control"  id="" cols="10" rows="3"></textarea>
                <br>
                <div class="form-group">
                    <label for="exampleInputPassword1">Date</label>
                    <input type="date" name="date" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>   
            </div>
            
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Gold</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection