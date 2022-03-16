<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;



class Record extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function likes()
    {
      return $this->hasMany(Like::class, 'record_id');
    }

    /**
     * リプライにLIKEを付いているかの判定
     * 
     *  @return bool true:Likeがついてる false:Likeがついてない
    */

    public function is_liked_by_auth_user()
  {
    // $id = \Auth::id();

    // $likers = array();
    
    //     foreach($this->likes as $like) {
    //         //array_pushは配列に値を追加する。第一引数に追加する配列、第二引数に追加する値
    //     array_push($likers, $like->user_id);
    //     }

//     $likes = Like::where('user_id','=',\Auth::id() )->get();

//    //    dd($likes);
//    $records = Like::select('record_id')->get();
    

//         foreach($likes as $like){
//         foreach($records as $record ){
//         if( $record['record_id'] == $like['record_id']) {
//         return true;
//         } else {
//         return false;
//         }

//     }}

  }
}

