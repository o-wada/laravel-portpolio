<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Profile;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth')->only(['like', 'unlike']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     */

         // 引数のIDに紐づくレコードにLIKEする

    public function like($id)
    {
        Like::create([
        'record_id' => $id,
        'user_id' => \Auth::id(),
        ]);

        // $like_exists = Like::where('user_id','=',\Auth::id() )
        //                 ->where('record_id','=', $id )
        //                 ->exists();


        return redirect()->route('index');
    }

    // 引数のIDに紐づくリプライにUNLIKEする

    public function unlike($id)
    {
        $like = Like::where('record_id', $id)->where('user_id', \Auth::id())->first();
        $like->delete();

        // $like_exists = Like::where('user_id','=',\Auth::id() )
        //               ->where('record_id','=', $id )
        //               ->exists();

        return redirect()->route('index');

    }




}
