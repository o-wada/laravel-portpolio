<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Profile;
use App\Models\Req;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\User;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class FriendController extends Controller
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
    // 友達申請
    public function request(Request $request){

        $posts = $request->all();

        Req::insert(['user_id' => \Auth::id(), 'request' => $posts['request'], 'permission_user' => $posts['permission_user'] ]);

        return redirect()->back();
            

    }

    // 申請取り消し
    public function dis_request(Request $request){

        $posts = $request->all();

        Req::where('id',$posts['request_id'])->update(['request' => $posts['request'] ]);

        return redirect()->back();

    }

    // 取り消しに必要なidを取り出す。
    public function select($id){

        $sel = Req::find($id);

        $select = \DB::table('users')
                 ->join('reqs', 'users.id','=','reqs.user_id')
                 ->where('reqs.user_id','=',\Auth::user()->id )
                 ->get();

           //      dd($sel);

        return view('user_page',compact('select'));
    }


}
