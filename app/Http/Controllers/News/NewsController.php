<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use File;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['news'] = News::all();
        return view('news.index', $data);
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

    public function getNews(){
        $news = News::all();
        return response()->json(["message"=>"success","data"=>$news], 200, );
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data['title'] = $request->title;
        $data['description'] = $request->description;

    
        $imageName = time().'.'.$request->image->extension();  
     
        if($request->image->move(public_path('images/news'), $imageName)){
            $image_url = "images/news/".$imageName;
            $data['image_url'] = $image_url;
        if(News::create($data)){
            return back()
            ->with('success','News added successfully!');
        }else{
            return back()
            ->with('success','Something went wrong try again!');
        }        
        }
        return back()
            ->with('success','Something went wrong try again!');
        
        
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
        $data['news'] = News::findOrFail($id);
        return view('news.edit', $data);


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
      $data = $request->all();
      $news = News::findOrFail($id);
    //   return $data; 
      if(isset($data["image"])){
        $imageName = time().'.'.$request->image->extension();  
        if($request->image->move(public_path('images/news'), $imageName)){
            $image_url = "images/news/".$imageName;
            $data['image_url'] = $image_url;
            $image_path = $news->image_url;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $news->title = $data['title'];
        $news->description = $data['description'];
        $news->image_url = $data['image_url'];
        if( $news->save()){
            return redirect()->route("news.index")->with('success', 'News updated successfully');   
        }else{
            return redirect()->route("news.index")->with('error', 'Something went wrong');   
        }

      }else{
        $news->title = $data['title'];
        $news->description = $data['description'];
        if( $news->save()){
            return redirect()->route("news.index")->with('success', 'News updated successfully');   
        }else{
            return redirect()->route("news.index")->with('error', 'Something went wrong');   
        }
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
        $news = News::find($id);
        if( $news->delete()){
            return redirect()->back()->with('success', 'News deleted successfully');   
        }else{
            return redirect()->back()->with('error', 'Something went wrong');   
        }

    }
}
