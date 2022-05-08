<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;
use App\Models\User;
use App\Models\Like;

class Chart extends Model
{
    use HasFactory;

    //横軸の日数を取得
    public function r_day(){

        $record_dates = Record::select('date')->where('user_id','=', \Auth::user()->id )->whereNull('deleted_at')->get();

        $record_day = [];

        foreach($record_dates as $record){

            $record_day[] = $record['date'];

        }

        return $record_day;



    }

    //縦軸の体重を取得
    public function r_weight(){

        $record_dates = Record::select('weight')->where('user_id','=', \Auth::user()->id )->whereNull('deleted_at')->get();

        $record_weight = [];

        foreach($record_dates as $record){

            $record_weight[] = $record['weight'];

        }

        return $record_weight;


    }

}