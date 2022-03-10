<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class CalIndexController extends Controller
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

        // SQLからmy_pageの目標体重を取得する

        $target = Profile::select('target')
                         ->where('user_id','=',\Auth::user()->id )
                         ->get();

                         


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
