<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;


class Profile extends Model
{
    use HasFactory;

    //画像の保存
    protected $guarded = ['id'];

    public static $rules = [
        'picture' => 'image|file'
        // 'target' => 'required',
        // 'way' => 'required',
        // 'other' => 'max:200',
        // 'rule' => 'max:2000',
        // 'age' => 'required|max:200',
        // 'gender' => 'required',
        // 'tall' => 'required',
        // 'weight' => 'required',
        // 'shape' => 'required',
        // 'user_id' => '\Auth::id()',

    ];

    //目標消費カロリーの計算
    public function CalKcal(){

        // 脂肪1キロ燃やすのに必要な消費カロリー
        $kcal = 7200 ;

        // SQLからmy_pageの目標体重と初期の体重を取得する
        $targets = Profile::select('profiles.*')
                ->where('user_id','=',\Auth::user()->id )
                ->get();

        // 目標体重と初期体重のギャップを計算する
        foreach($targets as $target)
        $sub = $target['weight'] - $target['target'];
        $target_kcal = $sub * $kcal ;

        return($target_kcal); 
 
    }

    //目標消費カロリーの残高計算
    public function amount(){

        //calKcalと同じ内容
                // 脂肪1キロ燃やすのに必要な消費カロリー
                $kcal = 7200 ;

                // SQLからmy_pageの目標体重と初期の体重を取得する
                $targets = Profile::select('profiles.*')
                        ->where('user_id','=',\Auth::user()->id )
                        ->get();

                // 目標体重と初期体重のギャップを計算する
                foreach($targets as $target)
                // 差額 = 元の体重 - 目標の体重
                $sub = $target['weight'] - $target['target'];
                // 消費するべき合計カロリー = 差額 かける 7200kcal
                $sub_kcal = $sub * $kcal ;            

        //これまでの合計消費カロリー（カロリー収支）を取得
        $amounts = \DB::table('users')
                ->join('records', 'records.user_id','=','users.id')
                ->where('user_id','=',\Auth::user()->id )
                ->select('user_id','name')
                ->selectRaw('SUM(sum) as sum')
                ->groupBy('user_id')
                ->get();

         //カロリー収支を計算
         foreach($amounts as $amount)

         // これまでの消費カロリーの合計
         $amount_kcal = $amount->sum;

         // 目標までの消費カロリー = 消費するべき合計カロリー - これまでの消費カロリーの合計
         $balance = $sub_kcal + $amount_kcal ;

    
        return($balance) ;

    }

    //1kg減量計算をする
    public function CalKg(){

                // 脂肪1キロ燃やすのに必要な消費カロリー
                $kcal = 7200 ;

                // SQLからmy_pageの目標体重と初期の体重を取得する
                $targets = Profile::select('profiles.*')
                            ->where('user_id','=',\Auth::user()->id )
                            ->get();

                // 目標体重と初期体重のギャップを計算する
                foreach($targets as $target)
                // 差額 = 元の体重 - 目標の体重
                $sub = $target['weight'] - $target['target'];
                // 減量するカロリー = 差額 かける 7200kcal
                $sub_kcal = $sub * $kcal ;            
        

                //これまでの合計消費カロリー（カロリー収支）を取得
                $amounts = \DB::table('users')
                            ->join('records', 'records.user_id','=','users.id')
                            ->where('user_id','=',\Auth::user()->id )
                            ->select('user_id','name')
                            ->selectRaw('SUM(sum) as sum')
                            ->groupBy('user_id')
                            ->get();

                //カロリー収支を計算
                foreach($amounts as $amount)

                // これまでの消費カロリーの合計
                $amount_kcal = $amount->sum;
                
                // 目標までの消費カロリー = 消費するべき合計カロリー - これまでの消費カロリーの合計
                $balance = $sub_kcal + $amount_kcal ;
        
        // 以下の計算で-がつくとややこしいので、符号反転させる。
        $replace = - $amount_kcal;


        // 次の1キロ減量までの消費カロリー        
       if( $replace < 0 ){

        //合計消費カロリーがプラスの場合（摂取カロリーが上まっている場合）
        $cal = $kcal - $replace ;
            
       
        }elseif( $replace < $kcal ){

            // 合計が7200未満の時
            $cal = $kcal - $replace ; 

        }else{

        // 合計が7200以上の時
           $re_cal = $replace % $kcal;

           $cal = $kcal - $re_cal;

       }
       // 合計がマイナスの時 $amount < 0


        return($cal);
    }



    

}
