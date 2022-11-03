<?php

namespace App\Http\Controllers\Gold;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gold;
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
            if($gold['action']==1){
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
            if($available_gold <= $request->quantity){
                // user can buy gold
                $user = User::find($user_id);
                // get latest gold selling price and cut balance from user account
                // add gold to user account
            }else{
                // gold not available
    
            }
        }else{
            // sell gold
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
