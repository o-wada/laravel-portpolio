<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Profile;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class ChartController extends Controller
{
    public function chart(){

        $date = Record::get();

        dd($date);

        

    }




}
