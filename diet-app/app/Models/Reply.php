<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;
use App\Models\User;
use App\Models\Like;

class Reply extends Model
{
    use HasFactory;

    public function likes(){

        // 主テーブルの投稿に対して従テーブルのlikeは複数もちます（もつ場合もあります）。
        return $this->hasMany(Like::class, 'reply_id');
    }



    public function liked(){


        $ids = record::orderBy('updated_at','ASC')->pluck('id');

              //  dd($ids);

        foreach($ids as $id){

            $like_exists = Like::select('likes.*')->where( [  ['user_id','=',\Auth::id()], [ 'record_id','=', $id ] ])->exists();

            //dd($like_exists);    

        }

        if($like_exists){
            return true;
        }else{
            return false;
        }



    }

}
