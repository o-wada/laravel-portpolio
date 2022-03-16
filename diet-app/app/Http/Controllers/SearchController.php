<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;

use App\Http\Requests\ProfileSearch;
use DB;

class SearchController extends Controller
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
    public function index()
    {
        $profiles = Profile::get();

        return view('search', compact('profiles') );

    }

    public function search(ProfileSearch $request){

        $posts = $request->all();
        
        // ↓チェックした項目が存在するか確認
        $element_exists = Profile::whereBetween('weight', [ $posts['weight'],( $posts['weight'] +9 ) ] )
                                 ->whereBetween('tall',   [ $posts['tall']  ,( $posts['tall']   +4 ) ])
                                 ->whereBetween('age',    [ $posts['age']   ,( $posts['age']    +9 ) ])
                                 ->where([ ['gender','=',$posts['gender'] ],['way','=',$posts['way'] ],['shape','=',$posts['shape']] ])
                                 ->exists();
                                 
                     //            dd($posts,$element_exists);

        if($element_exists){

            $user_element = \DB::table('users')
                               ->join('profiles', 'user_id','=','users.id')
                               ->whereBetween('weight', [ $posts['weight'],( $posts['weight'] +9 ) ] )
                               ->whereBetween('tall',   [ $posts['tall']  ,( $posts['tall']   +4 ) ])
                               ->whereBetween('age',    [ $posts['age']   ,( $posts['age']    +9 ) ])
                               ->where([ ['gender','=',$posts['gender'] ],['way','=',$posts['way'] ],['shape','=',$posts['shape']] ])
                               ->select('users.*','profiles.*','profiles.id')
                               ->get();

       //     dd($posts,$element_exists,$user_element);

            return view('search',compact('user_element'));

        }elseif( !($element_exists) ){

            $message = "該当のユーザーが存在しません。";

            return view('search', compact('message'));

        }else{

            $message = "全ての項目に1つずつチェックしてください";

            return view('search', compact('message'));

        }

    }


    





}
