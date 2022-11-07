<?php

namespace App\Http\Controllers\Gold;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gold;
use App\Models\User;
use App\Models\GoldPrice;
use App\Models\Transaction;
class GoldStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['gold'] = Gold::all();
        $data['total'] = 0;
    
        foreach ($data['gold'] as $gold) {
            if($gold['action']==1 || $gold['action']==4){
                // IN
                $data['total'] += $gold['quantity'];
            }else{
                // OUT
                $data['total'] -= $gold['quantity'];
            }
        }
        return view('gold.index',$data);
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
        $request->validate([
            'quantity' => 'required',
            'action' => 'required',
        ]);
        if(Gold::create($request->all())){
            return back()
            ->with('success','Successfull');
        }else{
            return back()
            ->with('success','Something went wrong try again!');
        }
    }

    public function buyGold(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'action' => 'required',
        ]);
        $gold = Gold::all();
        $available_gold = 0;
        foreach ($gold as $gold) {
            if($gold['action']==1 || $gold['action']==4){
                // IN - Gold available in our system
                $available_gold += $gold['quantity'];
            }else{
                // OUT - Gold out from our system or user buy gold from system
                $available_gold -= $gold['quantity'];
            }
        }
        $user_id = $request->user()["id"];

        

        if($request->action==3){
            // buy gold
            if($available_gold >= $request->quantity){
                // user can buy gold
                $user = User::find($user_id);
                // get latest gold selling price and cut balance from user account
                // add gold to user account
                $latest_price = GoldPrice::latest()->first();
                if($user->balance_tk>=$latest_price->buy_price*$request->quantity){
                    $user->balance_tk = $user->balance_tk-($latest_price->buy_price * $request->quantity);
                    $amount = $latest_price->buy_price*$request->quantity;
                    $user->balance_gold = $user->balance_gold + $request->quantity;
                    if($user->save()){
                        $data = $request->all();
                        $data['user_id'] = $user_id;
                        $data['transaction_type'] = 3;
                        $data['amount'] = $amount;
                        Gold::create(['quantity'=>$request->quantity,"action"=>3,"user_id"=>$user_id]);
                        if(Transaction::create($data)){
                            return response()->json(["status"=>true,"message"=>"gold bought successfully","data"=>$data], 200,  );
                        }
                    }
                }else{
                    return response()->json(["status"=>false,"message"=>"you don't have sufficient balance"], 200);
                }
                
            }else{
                // gold not available
                return response()->json(["status"=>false,"message"=>"this amount of gold not available in the system","available_gold"=>$available_gold], 200);
    
            }
        }else{
            $user = User::find($user_id);
            $gold_balance =  $user->balance_gold;
            $latest_price = GoldPrice::latest()->first();
            // sell gold
            $user->balance_tk = $user->balance_tk+($latest_price->sell_price * $request->quantity);
            $amount = $latest_price->sell_price*$request->quantity;
            $user->balance_gold = $user->balance_gold - $request->quantity;
            if($gold_balance>=$request->quantity){
                if($user->save()){
                    $data = $request->all();
                    $data['user_id'] = $user_id;
                    $data['transaction_type'] = 4;
                    $data['amount'] = $amount;
                    Gold::create(['quantity'=>$request->quantity,"action"=>4,"user_id"=>$user_id]);
                    if(Transaction::create($data)){
                        return response()->json(["status"=>true,"message"=>"gold sold successfully","data"=>$data], 200,  );
                    }
                }
            }else{
                return response()->json(["status"=>false,"message"=>"you don't have sufficient balance"], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gold = Gold::find($id);
        if( $gold->delete()){
            return redirect()->back()->with('success', 'History deleted successfully');   
        }else{
            return redirect()->back()->with('error', 'Something went wrong');   
        }
    }
}
