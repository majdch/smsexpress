<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use App\Item;
use Illuminate\Http\Request;
use App\Categorie;
use App\Post;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data=Categorie::all();
        $id=request('id');

        if($id != null){

            $result=Item::find($id);

            return view('items.recreate',compact('data','result'));
        }
else{
    return view('items.create',compact('data'));
}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data=request()->validate(  [
            'titre'=>'required',
            'description'=>'required',
            'image'=>['required','image'],
            'categorie'=>'required',
            'prix'=>'required',
            'date_dispo'=>'required',
            'date_fin_dispo'=>'required',
            'premium'=>''
          ]);
         if(!isset($data['premium'])){
$data['premium']=false;
         }else{
            $data['premium']=true;
         }

          $imagepath=request('image')->store('items','public');
          $image=Image::make("storage/{$imagepath}")->fit(1200,1200);
          $image->save();

          $datae=auth()->user()->item()->create([
              'titre'=>$data['titre'],
               'description'=>$data['description'],
               'categorie_id'=>$data['categorie'],
                'image'=>$imagepath,

               ]);

               Post::create([
                   'item_id'=>$datae['id'],
                   'user_id'=>auth()->user()->id,
                   'categorie_id'=>$data['categorie'],
                'prix'=>$data['prix'],
                'date_dispo'=>$data['date_dispo'],
                'date_fin_dispo'=>$data['date_fin_dispo'],
                'premium'=>$data['premium']
                 ]);
                return redirect('/profile/'.auth()->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
    public function restore(){
        $data=request(['item_id','prix','categorie','date_dispo','date_fin_dispo','premium']);
        if(!isset($data['premium'])){
            $data['premium']=false;
                     }else{
                        $data['premium']=true;
                     }
        Post::create([
            'item_id'=>$data['item_id'],
            'categorie_id'=>$data['categorie'],
            'user_id'=>auth()->user()->id,
         'prix'=>$data['prix'],
         'date_dispo'=>$data['date_dispo'],
         'date_fin_dispo'=>$data['date_fin_dispo'],
         'premium'=>$data['premium']
          ]);
         return redirect('/profile/'.auth()->user()->id);
    }
}
