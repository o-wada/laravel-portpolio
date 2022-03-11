<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class RankController extends Controller
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

        //今日のランキング
        $dt = Carbon::now()->toDateString();        

        $sum =\DB::table('users')
               ->join('records', 'records.user_id','=','users.id') 
               ->where('date','=', $dt )
               ->whereNull('records.deleted_at')
               ->orderBy('sum', 'ASC')
               ->get();

        $ranks = $sum->sortBy('sum');
        $ranks->values()->all();

      //  dd($abc);


        return view('rank', compact('ranks') );
    }

    // 合計のランキング

    public function mount(){

        $amount = \DB::table('users')
                ->join('records', 'records.user_id','=','users.id')
                ->select('user_id','name')
                ->selectRaw('SUM(sum) as sum')
                ->groupBy('user_id')
                ->get();
        
        $ranks = $amount->sortBy('sum');
        $ranks->values()->all();


          //      dd($mounts);
    
        return view('rank_mount', compact('ranks'));

    }


    //平均のランキング
    public function average(){

        $average = \DB::table('users')
                ->join('records', 'records.user_id','=','users.id')
                ->select('user_id','name')
                ->selectRaw('AVG(sum) as sum')
                ->groupBy('user_id')
                ->get();

        $ranks = $average->sortBy('sum');
        $ranks->values()->all();


           //     dd($mounts);
    
        return view('rank_average', compact('ranks'));

    }






    public function store(Request $request){

    }

    public function edit($id){
    }

    public function update(Request $request){
    }

    public function delete(Request $request){
    }



}
