<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Tom;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

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


    public function index(){

        $abc = Tom::get();

     //   dd($abc);

        return view('try', compact('abc'));

    }

    public function store(Request $request){


        $this->validate($request, Tom::$rules);

        if ($file = $request->image ) {
            $fileName = time() . $file->getClientOriginalName();
            $target_path = public_path('pictures/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }

        $member = new Tom;

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



}
