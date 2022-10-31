<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['transactions'] = Transaction::where("isApprove","0")->get();

        return view("transaction.index",$data);

        // return $data['transactions'][0]->user->name;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return "hello";
        $request->validate([
            'transaction_type' => 'required',
            'amount' => 'required',
            'phone_number' => 'required',
            'payment_method' => 'required',
        ]);
        // return $request->all();
        $data['transaction_type'] = $request->transaction_type;
        $data['amount'] = $request->amount;
        $data['phone_number'] = $request->phone_number;
        $data['payment_method'] = $request->payment_method;
        $user_id = $request->user()["id"];    
        if(isset($request->trx_id) && $request->transaction_type=="1"){
            // diposit
         $data['trx_id'] = $request->trx_id;
        
         $_data = $data;
         $_data['user_id'] = $user_id;
         if(Transaction::create($_data)){
            return response()->json(["message"=>"success","data"=>$data], 200);
         }else{
            return response()->json(["message"=>"something went wrong!",], 500);
         }
        }else{
            // withdraw
          $_data = $data;
          $_data['user_id'] = $user_id;
          if(Transaction::create($_data)){
            return response()->json(["message"=>"success","data"=>$data], 200);
         }else{
            return response()->json(["message"=>"something went wrong!",], 500);
         }
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if($transaction->transaction_type=="1"){
            // deposit
            $user = User::findOrFail($transaction->user_id);
            $balance_tk = $user->balance_tk;
            $balance_tk += $transaction->amount;
            $user->balance_tk = $balance_tk;

            if($user->save()){
                $transaction->isApprove = 1;
                if($transaction->save()){
                    return redirect()->back()->with('success', 'Transaction approved successfully');   
                }else{
                    return redirect()->back()->with('success', 'Something went wrong try again');   
                }
            }else{
                return redirect()->back()->with('success', 'Something went wrong try again');   
            }
            
            // $amount = $user->
        }else{
            // withdraw
            $user = User::findOrFail($transaction->user_id);
            $balance_tk = $user->balance_tk;
            $balance_tk -= $transaction->amount;
            $user->balance_tk = $balance_tk;
            if($user->save()){
                $transaction->isApprove = 1;
                if($transaction->save()){
                    return redirect()->back()->with('success', 'Transaction approved successfully');   
                }else{
                    return redirect()->back()->with('success', 'Something went wrong try again');   
                }
            }else{
                return redirect()->back()->with('success', 'Something went wrong try again');   
            }
            return $balance_tk;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function balance(Request $request){
        $user_id = $request->user();
        $user =  $request->user();
        return response()->json(["message"=>"success","data"=>["balance_tk"=>$user->balance_tk,"balance_gold"=>$user->balance_gold]], 200, );
        
    }
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if( $transaction->delete()){
            return redirect()->back()->with('success', 'Transaction deleted successfully');   
        }else{
            return redirect()->back()->with('error', 'Something went wrong');   
        }
    }
}
