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
                $data['total'] += $gold['quantity'];
            }else{
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
