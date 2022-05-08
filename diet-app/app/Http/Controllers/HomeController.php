<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Profile;
use App\Models\Reply;
use App\Models\User;
use App\Models\Req;
use App\Models\Like;
use App\Models\Chart;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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


    public function index(){

        // 投稿の一覧を表示
        $records = \DB::table('users')
                    ->join('records', 'records.user_id','=','users.id')
                    ->join('profiles', 'profiles.user_id','=','users.id')
                    ->select('records.*','users.*','profiles.*','records.id','records.updated_at')
                    ->whereNull('records.deleted_at')
                    ->orderBy('records.updated_at','DESC')
                    ->get();

              //     dd($records);

        // 投稿に対するリプをカウント
        $counts = \DB::table('records')
                    ->join('replies', 'replies.host_id','=','records.id')
                    ->whereNull('replies.deleted_at')
                    ->groupBy('replies.host_id')
                    ->get(['replies.host_id',\DB::raw('count(replies.host_id) as reply')]);

        $shaft = new Chart;
        $record_day = $shaft->r_day();
        $record_weight = $shaft->r_weight();

      //  dd(gettype($record_day));

     //   dd($record_weight);
                                        
         $reply = new Reply;
                
        // 消費カロリーの見える化
        $pro = new Profile;
        $target = $pro->CalKcal();
        // 目標消費カロリーの残高計算
        $balance = $pro->amount();
        $cal = $pro->CalKg(); 

        //日数を計算
        $count_dates = User::where('id','=', \Auth::id() )->value('created_at')->diffInDays( Carbon::now() );
        $count_date = $count_dates + 1;    

        //平均カロリー収支を計算
        $averages = \DB::table('users')
                    ->join('records', 'records.user_id','=','users.id')
                    ->where('user_id','=',\Auth::id())
                    ->whereNull('records.deleted_at')
                    ->select('user_id','name')
                    ->selectRaw('AVG(sum) as sum')
                    ->groupBy('user_id')
                    ->get();

        $finishes = new Profile;
        $finish   = $finishes->finish();
            
        $record = Record::where('user_id','=',\Auth::id() )->whereNull('deleted_at')->exists();
                    
        if($record){

            foreach($averages as $ave){
            $average = ceil($ave->sum / $count_date);
            }

            return view('index',compact('records','counts','target','balance','cal','count_date','average','finish','reply','record_day','record_weight'));

        }else{
             
            $average = 0;

            return view('index',compact('records','counts','target','balance','cal','count_date','average','finish','reply','record_day','record_weight'));

        }

       return view('index' , compact('records','counts','target','balance','cal','count_date','finish','reply','record_day','record_weight'));

    }

    

    public function record(Request $request){

        $dt = Carbon::now()->toDateString();        

        //同日のrecordが存在する場合は、編集画面へ案内する
        $counts = Record::select('records.*')
                 ->where('user_id','=',\Auth::id())
                 ->where('date','=', $dt)
                 ->whereNull('deleted_at')
                 ->count();

        $changes = Record::select('records.*')
                 ->where('user_id','=',\Auth::id())
                 ->where('date','=', $dt)
                 ->whereNull('deleted_at')
                 ->orderBy('updated_at', 'DESC')
                 ->get();


        //recordの内容を取得し表示する
        $records = Record::select('records.*')
                   ->where('user_id','=',\Auth::id())
                   ->whereNull('deleted_at')
                   ->orderBy('updated_at', 'DESC')
                   ->get();
          //         dd($records);

        return view('record', compact('records','dt','counts','changes'));
    }

    public function store(Request $request){

        $posts = $request->all();

        $data['intake'] = $request->input('intake');
        $data['consumption'] = $request->input('consumption');
        $data['sum'] = ( $data['intake'] - $data['consumption'] );
        $posts['sum'] = $data['sum'];

        Record::insert(['date' => $posts['date'], 'weight' => $posts['weight'], 
                        'intake' => $posts['intake'],'consumption' => $posts['consumption'], 'sum' => $posts['sum'],
                        'memo' => $posts['memo'], 'user_id' => \Auth::id(), 'profile_id' => \Auth::id() ]);

        return redirect()->route('index') ;
    }

    public function edit($id){

        $edit_record = Record::find($id);

        return view('edit', compact( 'edit_record') );
    }

    public function update(Request $request){

        $posts = $request->all();
        //sumを再計算して保存する
        $data['intake'] = $request->input('intake');
        $data['consumption'] = $request->input('consumption');
        $data['sum'] = ( $data['intake'] - $data['consumption'] );
        $posts['sum'] = $data['sum'];

        Record::where('id', $posts['record_id'])->update(['date' => $posts['date'],
                        'weight' => $posts['weight'],'intake' => $posts['intake'],
                        'consumption' => $posts['consumption'],'memo' => $posts['memo'],
                        'sum' => $posts['sum'] ]);

                       // dd($posts);

        return redirect( route('index'));
    }

    public function delete(Request $request){

        $posts = $request->all();
        //dd($posts);
        Record::where('id', $posts['record_id'])->update(['deleted_at' => date("Y-m-d H:i:s", time())]);
       
        return redirect( route('index'));
    }

    //ここから、投稿に対するリプに伴うもの

    public function reply($id){

        $reply = Record::find($id);

        //indexページにて$recordsを取得し表示する
        $records = \DB::table('users')
                   ->join('records', 'users.id','=','records.user_id')
                   ->join('profiles', 'profiles.user_id','=','users.id')
                   ->select('users.*','records.*','profiles.*','records.id')
                   ->where('records.id','=', $reply['id'] )
                   ->whereNull('records.deleted_at')
                   ->orderBy('records.updated_at', 'DESC')
                   ->get();

        // 投稿内容に対する返信
        $reps = \DB::table('users')
                    ->join('replies' ,'users.id','=','replies.user_id')
                    ->join('profiles', 'profiles.user_id','=','users.id')
                    ->select('profiles.*','users.*','replies.*','replies.id')
                    ->where('replies.host_id','=',$reply['id'])                  
                    ->whereNull('replies.deleted_at')
                    ->orderBy('replies.updated_at','ASC')
                    ->get();
             //       dd($records);
        
        // リプに対するコメントをカウント
        $counts = \DB::table('replies')
                    ->join('comments', 'replies.id','=','comments.reply_id')
                    ->whereNull('comments.deleted_at')
                    ->groupBy('replies.id')
                    ->get(['comments.reply_id',\DB::raw('count(replies.id) as comment')]);


        //       dd($counts);

       return view('index', compact('records','reps','counts'));


    }

        //リプライ内容を保存して出力

    public function rep_store(Request $request){

        $posts = $request->all();

        Reply::insert([
            'host_id' => $posts['host_id'], 'user_id' => \Auth::user()->id ,'comment' => $posts['comment'] ]);

       // dd($posts);

        return redirect()->back() ;

    }

    // レプライ削除

    public function rep_delete(Request $request){

        $posts = $request->all();

      //  dd($posts);
        Reply::where('id', $posts['rep_id'])->update(['deleted_at' => date("Y-m-d H:i:s", time())]);
       
        return redirect()->back();

    }
    

    //ここから投稿にコメントしたコメントに返信するページ

    public function rep_comment($id){

        $reply = Reply::find($id);

        $record = Record::find($id);

        $comment = Comment::find($id);

        // 最初の投稿を表示する $records(rep_commentにて使用のため消さない)   $records->$rep->$comment
        $records = \DB::table('users')
                ->join('records', 'records.user_id','=','users.id')
                ->join('profiles', 'profiles.user_id','=','users.id')
                ->select('records.*','users.*','profiles.*','records.id')
                ->where('records.id', '=', $reply['host_id'] )
                ->whereNull('records.deleted_at')
                ->orderBy('records.updated_at' ,'DESC')
                ->get();
            //   dd($records);

                   //        dd($reply,$record,$comment);


        // 最初の投稿に対するリプライを表示
        $reps = \DB::table('users')
                   ->join('replies' ,'users.id','=','replies.user_id')
                   ->join('records', 'records.user_id','=','users.id')
                   ->join('profiles', 'profiles.user_id','=','users.id')
                   ->select('users.*','replies.*','profiles.*','records.*')
                   ->where('replies.id','=',$reply['id'])
                   ->whereNull('replies.deleted_at')
                   ->orderBy('replies.updated_at','DESC')
                   ->limit(1)
                   ->get();

            


        // コメントした内容に対して返信を表示する
        $comments = \DB::table('users')
                   ->join('comments','users.id','=','comments.user_id')
                   ->join('profiles', 'profiles.user_id','=','users.id')
                   ->where('comments.reply_id','=',$reply['id'])
                   ->whereNull('comments.deleted_at')
                   ->orderBy('comments.updated_at','ASC')
                   ->get();

             //      dd($comments);

       return view('rep_comment', compact('records','reps','reply','comments'));

    }

    //コメントを保存する
    public function comment_store(Request $request){

        $posts = $request->all();

        Comment::insert(['reply_id' => $posts['reply_id'], 
                         'user_id' => \Auth::user()->id ,'comment' => $posts['comment']]);

        return redirect()->back();
    }

   //コメントを消す
    public function comment_delete(Request $request){

        $posts = $request->all();

        //dd($posts);
        Comment::where('id', $posts['comment_id'])->update(['deleted_at' => date("Y-m-d H:i:s", time())]);
       
        return redirect()->back();


    }

    // ユーザプロフィール転送
    public function move($id){

    $profile = Profile::find($id);

    $user = User::find($id);

    $profiles = \DB::table('users')
            ->join('records', 'records.user_id','=','users.id')
            ->join('profiles', 'profiles.user_id','=','users.id')
            ->where('records.profile_id','=', $profile['id'])
            ->limit(1)
            ->get();
      //   dd($records);

    return view('user_page', compact('profiles','user'));
        

    }    


 

}
