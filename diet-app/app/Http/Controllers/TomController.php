<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Tomm;
use App\Models\Try;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ArticleRequest;

class TomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     */



    public function store(Request $request){


        $this->validate($request, Tomm::$rules);

        if ($file = $request->image ) {
            $fileName = time() . $file->getClientOriginalName();
            $target_path = public_path('pictures/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }

        $member = new Tomm;

        $member->image = $fileName;
        $member->save();

        return redirect()->route('tomato');

    }

    public function edit($id){
    }

    public function update(Request $request){
    }

    public function delete(Request $request){
    }

    public function show(Tomm $article)
    {
        return view('try.show', ['article' => $article]);
    }

    public function like(Request $request, Tomm $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Tomm $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }


}
