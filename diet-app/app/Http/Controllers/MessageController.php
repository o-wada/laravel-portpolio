<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class MessageController extends Controller
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
     */
    public function index(){
        //個別のmessageルーム一覧
        $users = User::get();

     //   dd($users);

        return view('message', compact('users') );


    }

    // メッセージ一覧を表示
    public function display(){

        $chats = \DB::table('users')
        ->join('chats', 'chats.user_id','=','users.id')
        ->where('chats.accept_user','=','user.id')
        ->orderBy('chats.updated_at', 'DESC')
        ->get();

        

        return view('send',compact('chats'));

    }

    public function m_store(Request $request){

        $posts = $request->all();

        Chat::insert(['user_id' => \Auth::user()->id ,'accept_user' => $posts['accept_user'], 'comment' => $posts['comment'] ]);

     //   dd($posts);

        return redirect()->back();

    }

    public function send($id){

        //個別ページへ遷移
        $send = User::find($id);

        //トーク表示
      //  $chats = Chat::orderBy('updated_at', 'ASC')->get();
      $chats = \DB::table('users')
      ->join('chats', 'chats.user_id','=','users.id')
      ->orderBy('chats.updated_at', 'ASC')
      ->get();


        return view('send', compact('send','chats'));

    }

    public function update(Request $request){
    }

    public function delete(Request $request){
    }



}
