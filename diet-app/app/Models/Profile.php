<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;
use Carbon\Carbon;


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
    // 脂肪1キロ燃やすのに必要な消費カロリー
    public $kcal = 7200 ;

    //目標消費カロリーの計算
    public function CalKcal(){

        // SQLからmy_pageの目標体重と初期の体重を取得する
        $targets = Profile::select('profiles.*')
                ->where('user_id','=',\Auth::user()->id )
                ->get();

        $profile = Profile::where('user_id','=',\Auth::id())->exists();

        // 目標体重と初期体重のギャップを計算する
        foreach($targets as $target){
            if($profile){
                $sub = $target['weight'] - $target['target'];
                $target_kcal = $sub * $this->kcal ;
                return($target_kcal); 
            }else{
                $message = 'プロフィールを登録してください。';
                return($message);
            }

        }
 
    }

    //目標消費カロリーの残高計算
    public function amount(){

        // SQLからmy_pageの目標体重と初期の体重を取得する
        $targets = Profile::select('profiles.*')
                ->where('user_id','=',\Auth::user()->id )
                ->get();

        $profile = Profile::where('user_id','=',\Auth::id())->exists();

        // 目標体重と初期体重のギャップを計算する
        foreach($targets as $target){
            if($profile){
                // 目標体重と初期体重のギャップを計算する
                // 差額 = 元の体重 - 目標の体重
                $sub = $target['weight'] - $target['target'];
                // 消費するべき合計カロリー = 差額 かける 7200kcal
                $target_kcal = $sub * $this->kcal ;
        
                //これまでの合計消費カロリー（カロリー収支）を取得
                $amounts = \DB::table('users')
                        ->join('records', 'records.user_id','=','users.id')
                        ->where('user_id','=',\Auth::user()->id )
                        ->whereNull('records.deleted_at')
                        ->select('user_id','name')
                        ->selectRaw('SUM(sum) as sum')
                        ->groupBy('user_id')
                        ->get();

                //カロリー収支を計算
                foreach($amounts as $amount){

                // これまでの消費カロリーの合計
                $amount_kcal = $amount->sum;

                // 目標までの消費カロリー = 消費するべき合計カロリー - これまでの消費カロリーの合計
                $balance = $target_kcal + $amount_kcal ;

                return($balance) ;
                }
            
            }else{
                $message = 'プロフィールを登録してください。';
                return($message);
            }

        }

       
    }

    //1kg減量計算をする
    public function CalKg(){

    // SQLからmy_pageの目標体重と初期の体重を取得する
    $targets = Profile::select('profiles.*')
                ->where('user_id','=',\Auth::user()->id )
                ->get();

    $profile = Profile::where('user_id','=',\Auth::id())->exists();

    // 目標体重と初期体重のギャップを計算する
    foreach($targets as $target){
        if($profile){
            // 目標体重と初期体重のギャップを計算する
            // 差額 = 元の体重 - 目標の体重
            $sub = $target['weight'] - $target['target'];
            // 消費するべき合計カロリー = 差額 かける 7200kcal
            $target_kcal = $sub * $this->kcal ;
        
            //これまでの合計消費カロリー（カロリー収支）を取得
            $amounts = \DB::table('users')
                        ->join('records', 'records.user_id','=','users.id')
                        ->where('user_id','=',\Auth::user()->id )
                        ->whereNull('records.deleted_at')
                        ->select('user_id','name')
                        ->selectRaw('SUM(sum) as sum')
                        ->groupBy('user_id')
                        ->get();

            //カロリー収支を計算
            foreach($amounts as $amount)

            // これまでの消費カロリーの合計
            $amount_kcal = $amount->sum;
            
            // 目標までの消費カロリー = 消費するべき合計カロリー - これまでの消費カロリーの合計
            $balance = $target_kcal + $amount_kcal ;
            
            // 以下の計算で-がつくとややこしいので、符号反転させる。
            $replace = - $amount_kcal;


            // 次の1キロ減量までの消費カロリー        
            if( $replace < 0 ){

                //合計消費カロリーがプラスの場合（摂取カロリーが上まっている場合）
                $cal = $this->kcal - $replace ;
                    
            
            }elseif( $replace < $this->kcal ){

                    // 合計が7200未満の時
                    $cal = $this->kcal - $replace ; 

            }else{

                // 合計が7200以上の時
                $re_cal = $replace % $this->kcal;

                $cal = $this->kcal - $re_cal;

            }
            // 合計がマイナスの時 $amount < 0


            return($cal);

        }else{
            $message = 'プロフィールを登録してください。';
            return($message);
        }

    }

    }

    //目標達成までの残り日数を数える
    public function finish(){

            //calKcalと同じ内容
            // SQLからmy_pageの目標体重と初期の体重を取得する
            $targets = Profile::select('profiles.*')
                    ->where('user_id','=',\Auth::user()->id )
                    ->get();

            $profile = Profile::where('user_id','=',\Auth::id())->exists();

            // 目標体重と初期体重のギャップを計算する
            foreach($targets as $target){
                if($profile){
                    $sub = $target['weight'] - $target['target'];
                    $target_kcal = $sub * $this->kcal ;                
                
                    //これまでの合計消費カロリー（カロリー収支）を取得
                    $amounts = \DB::table('users')
                            ->join('records', 'records.user_id','=','users.id')
                            ->where('user_id','=',\Auth::user()->id )
                            ->whereNull('records.deleted_at')
                            ->select('user_id','name')
                            ->selectRaw('SUM(sum) as sum')
                            ->groupBy('user_id')
                            ->get();

                    $averages = \DB::table('users')
                            ->join('records', 'records.user_id','=','users.id')
                            ->where('user_id','=',\Auth::id())
                            ->whereNull('records.deleted_at')
                            ->select('user_id','name')
                            ->selectRaw('AVG(sum) as sum')
                            ->groupBy('user_id')
                            ->get();
        

                    $count_date = User::where('id','=', \Auth::id() )->value('created_at')->diffInDays( Carbon::now() );
                    $count_dates = $count_date + 1 ;

                    //カロリー収支を計算
                    foreach($amounts as $amount){

                    // これまでの消費カロリーの合計
                    $amount_kcal = $amount->sum;

                    // 目標までの消費カロリー = 消費するべき合計カロリー - これまでの消費カロリーの合計
                    $balance = $target_kcal + $amount_kcal ;
                    
                    foreach($averages as $a){
                     
                        $ave = ($a->sum/$count_dates);
                        $finish = - $balance / $ave ;

                        return(ceil($finish));

                    }

                    
                }



            }
        }
    }
}
