<?php

namespace App\Http\Controllers\Gold;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoldPrice;
class GoldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['goldPrice'] = GoldPrice::all();
        
        return view('gold_price.index',$data);
    }

    public function goldPrice(){
        $goldPrice = goldPrice::all();

        return response()->json(["message"=>"success","data"=>$goldPrice], 200,);
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
            'date' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
        ]);

        // return $request->all();

        if(GoldPrice::create($request->all())){
            return back()
            ->with('success','Gold Price Added Successfully');
        }else{
            return back()
            ->with('success','Something went wrong try again!');
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
        $goldPrice = GoldPrice::find($id);
        if( $goldPrice->delete()){
            return redirect()->back()->with('success', 'Gold Price deleted successfully');   
        }else{
            return redirect()->back()->with('error', 'Something went wrong');   
        }
    }
}
