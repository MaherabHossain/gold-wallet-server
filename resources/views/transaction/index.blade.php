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
                        <th>Transaction type</th>
                        <th>Amount</th>
                        <th>Phone number</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Transaction type</th>
                        <th>Amount</th>
                        <th>Phone number</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{  $transaction->user->name }}</td>
                        {{-- <td>{{  $transaction->transaction_type }}</td> --}}
                        <td > <b class="{{$transaction->transaction_type%2!=0?"text-success":"text-danger"}}"> 
                        
                            <?php 
                            if($transaction->transaction_type==1){
                              echo "IN";
                            }
                            if($transaction->transaction_type==2){
                              echo "OUT";
                            }
                            if($transaction->transaction_type==3){
                              echo "BUY";
                            }
                            if($transaction->transaction_type==4){
                              echo "SELL";
                            }
    
                            ?> 
                        </td></b>
                        <td>{{  $transaction->amount }}</td>
                        <td>{{  $transaction->phone_number }}</td>
                        <td>{{  $transaction->payment_method }}</td>
                        <td>{{  $transaction->trx_id }}</td>
                        <td>
                            <form action="{{route("transaction.destroy.admin",["transaction"=>$transaction->id])}}" method="POST">
                                @csrf
                                @method("delete")
                                <input type="hidden" value={{$transaction->id}} name="id">
                                <a href="{{route("transaction.destroy.admin",["transaction"=>$transaction->id])}}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
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