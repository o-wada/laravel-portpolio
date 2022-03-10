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


    public function like($id){

        /**
        * 引数のIDに紐づくリプライにLIKEする
        *
        * @param $id リプライID
        * @return \Illuminate\Http\RedirectResponse
        */

        Like::create([
            'reply_id' => $id,
            'user_id' => \Auth::user()->id,
        ]);

        session()->flash('succsess','You Liked the Reply.');

        return redirect()->back();

    }

    /**
     * 引数のIDに紐づくリプライにUNLIKEする
     *
     * @param $id リプライID
     * @return \Illuminate\Http\RedirectResponse
     */

    public function Unlike($id){

        $like = Like::where('reply_id', $id)->where('user_id',\Auth::id())->first();
        // $like->delete();

        session()->flash('OK');
        
        return redirect()->back();

    }


    public function store(Request $request){

    }

    public function edit($id){
    }

    public function update(Request $request){
    }

    public function delete(Request $request){
    }




   // カウント {{ $reply->likes->count() }}
//    @if(!($reply))
//    <a href="{{ route('rep_unlike', ['id']) }}" class="btn btn-dark btn-sm text-decoration-none px-2">
//        <i class="fa fa-heart" aria-hidden="true"></i>

//    </a>
// @else
//    <a href="{{ route('rep_like', ['id']) }}" class="btn btn-danger btn-sm  text-decoration-none px-2">
//        <i class="fa fa-heart" aria-hidden="true"></i>
//        <span class="badge"></span>
//    </a>
// @endif

}
