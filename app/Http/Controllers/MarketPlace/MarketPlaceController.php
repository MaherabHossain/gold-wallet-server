<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketPlace;
use App\Models\User;
class MarketPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marketPlace = MarketPlace::all();
        $user_id = $request->user()->id;
        return response()->json(["status"=>true,"message"=>"success","data"=>$marketPlace,'user_id'=>$user_id], 200,);

        
    }

    public function userSell(Request $request)
    {
        $user_id = $request->user()->id;
        $marketPlace = MarketPlace::where('user_id',$user_id);
        return response()->json(["status"=>true,"message"=>"success","data"=>$marketPlace, 200,]);
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
            'amount' => 'required',
            'unit_price' => 'required',
        ]);

        $_data = $request->all();
        $data = $_data;
        $data['user_id'] = $request->user()->id;
        $user_id = $data['user_id'];
        $user = User::find($user_id);
        $gold_balance = $user->balance_gold;
        if($gold_balance >= $amount){
            if(MarketPlace::create($data)){
                return response()->json(["status"=>true,"message"=>"sell added successfully","data"=>$_data], 200,  );
            }
        }else{
            return response()->json(["status"=>false,"message"=>"you don't have sufficient balance"], 200);
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
         $user_id = $request->user()->id;
         $marketPlace = MarketPlace::find($id);
         $user  = User::find($user_id);
         $seller_id = $marketPlace->user_id;
         $saller = User::find($seller_id);
         $total_cost = $marketPlace->amount * $marketPlace->unit_price;

         if($user->balance_tk >= $total_cost){
            // update buyer balance
            $user->balance_tk = $user->balance_tk - $total_cost;
            $user->balance_gold = $user->balance_gold + $marketPlace->amount;
            // update saller balance
            $saller->balance_tk = $saller->balance_tk + $total_cost;
            $saller->balance_gold = $saller->balance_gold - $marketPlace->amount;
            $marketPlace->isSold = "1";
            if($user->save() && $saller->save() && $marketPlace->save()){
                return response()->json(["status"=>true,"message"=>"gold bought successfully!"], 200);
            }else{
                return response()->json(["status"=>false,"message"=>"something went wrong!"], 200);
            }
         }else{
            return response()->json(["status"=>false,"message"=>"you don't have sufficient balance"], 200);
         }
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
            return response()->json(["status"=>true,"message"=>"sell deleted successfully!"], 200);   
        }else{
            return response()->json(["status"=>false,"message"=>"something went wrong!"], 200);  
        }
    }
}
