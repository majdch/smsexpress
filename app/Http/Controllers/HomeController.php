<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use App\Post;
use App\Item;

use App\User;
use Illuminate\Support\Facades\Input;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts=Post::latest()->paginate(9);
        $data=Categorie::all();

        return view('home',compact('data','posts'));
    }




    public function search(){
        $data=Categorie::all();
        $text = Request('Search');

        $post = Item::where('titre','LIKE','%'. $text.'%')->get();
        $categorie = Categorie::where('nom','LIKE','%'. $text.'%')->get();
        if( count($post) > 0 || count($categorie) > 0)
            return view('search.result',compact('data','post','categorie'));
        else{
            $message="Aucun resultat est trouvé";
            return view ('search.result',compact('data','message'));
        }
    }

}
