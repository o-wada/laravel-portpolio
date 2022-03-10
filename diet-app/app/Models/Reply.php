<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public function likes(){

        // 主テーブルの投稿に対して従テーブルのlikeは複数もちます（もつ場合もあります）。
        return $this->hasMany(Like::class, 'reply_id');
    }


    public function liked(){

        /**
  * リプライにLIKEを付いているかの判定
  *
  * @return bool true:Likeがついてる false:Likeがついてない
  */

        $id = \Auth::user()->id;

        $likers = array([
            'user_id' => $id,
        ]);


        foreach($likers as $like){

            // array_push(追加先の配列,追加する値1,追加する値2,…)
            array_push($likers, $like['user_id']);
        }

       // dd($likers);


        if(in_array($id,$likers)){
            //in_array ($検索する値 , 第二引数の$likersに$idがあれば、trueなければfalse  )

            return true;

        }else{

            return false;

        }



    }

}
