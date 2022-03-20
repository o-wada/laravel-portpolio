<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class MyPageController extends Controller
{
    /*
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
        
        //プロフィールを表示する
        $profiles = Profile::select('profiles.*')
                    ->where('user_id', '=' ,\Auth::id())
                    ->whereNull('deleted_at')
                    ->get();


        //プロフィールの登録があるか確認する
        $first = Profile::select('profiles.*')
                  ->where('user_id', '=', \Auth::id())
                  ->count();

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
                ->select('user_id','name')
                ->whereNull('records.deleted_at')
                ->selectRaw('AVG(sum) as sum')
                ->groupBy('user_id')
                ->get();        
        
        $finishes = new Profile;
        $finish   = $finishes->finish();

        $record = Record::where('user_id','=',\Auth::id() )->whereNull('deleted_at')->exists();
                    
        if($record){

            foreach($averages as $ave){
            $average = $ave->sum / $count_date;
            }

            return view('my_page',compact('average','finish','profiles','first','target','balance','cal','count_date'));

        }else{
             
            $average = 0;

            return view('my_page',compact('average','finish','profiles','first','target','balance','cal','count_date'));

        }


        return view('my_page', compact('profiles','first','target','balance','cal','count_date','finish'));               
    }

    public function store(Request $request){

   //     画像の保存
        $this->validate($request, Profile::$rules);

        if ($file = $request->picture ) {
            $fileName = time() . $file->getClientOriginalName();
            $target_path = public_path('images/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }

        $member = new Profile;

        $member->picture = $fileName;
        $member->target = $request->target;
        $member->way = $request->way;
        $member->other = $request->other;
        $member->rule = $request->rule;
        $member->age = $request->age;
        $member->gender = $request->gender;
        $member->tall = $request->tall;
        $member->weight = $request->weight;
        $member->shape = $request->shape;
        $member->user_id = \Auth::user()->id ;

        $member->save();
    

        return redirect( '/record' );
    }

    public function edit($id){

        $profiles = Profile::select('profiles.*')
                ->where('user_id','=',\Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC')
                ->get();

        $edit_profile = Profile::find($id);

        return view('edit_profile', compact('profiles', 'edit_profile'));

    }

    public function update(Request $request){

        $posts = $request->all();

           //     画像の保存
           $this->validate($request, Profile::$rules);

           if ($file = $request->picture ) {
               $fileName = time() . $file->getClientOriginalName();
               $target_path = public_path('images/');
               $file->move($target_path, $fileName);
           } else {
               $fileName = "";
           }
   
           $member = new Profile;
   
           $member->picture = $fileName;
           $member->target = $request->target;
           $member->way = $request->way;
           $member->other = $request->other;
           $member->rule = $request->rule;
           $member->age = $request->age;
           $member->gender = $request->gender;
           $member->tall = $request->tall;
           $member->weight = $request->weight;
           $member->shape = $request->shape;
           $member->user_id = \Auth::user()->id ;
   
      //     $member->save();
        
        Profile::where('id', $posts['profile_id'])
                 ->update([
                        'picture' => $fileName,
                        'target' => $request->target, 'way' => $request->way, 'other' => $request->other,
                        'age' =>$request->age ,'gender' => $request->gender ,'tall' => $request->tall ,
                        'weight' => $request->weight , 'shape' => $request->shape , 'rule' => $request->rule, ]);



        return redirect( route('my_page'));

    }


    public function delete(Request $request){
    }


    // my_page 投稿一覧
    public function post(){

        $records = \DB::table('users')
                    ->join('records', 'records.user_id','=','users.id')
                    ->join('profiles', 'profiles.user_id','=','users.id')
                    ->select('records.*','users.*','profiles.*','records.id')
                    ->where('records.user_id' ,'=', \Auth::user()->id )
                    ->whereNull('records.deleted_at')
                    ->orderBy('records.updated_at' ,'DESC')
                    ->get();


        // 投稿に対するリプをカウント
        $counts = \DB::table('records')
                    ->join('replies', 'replies.host_id','=','records.id')
                    ->whereNull('replies.deleted_at')
                    ->groupBy('replies.host_id')
                    ->get(['replies.host_id',\DB::raw('count(replies.host_id) as reply')]);

        return view('post' , compact('records', 'counts'));
    }




}
