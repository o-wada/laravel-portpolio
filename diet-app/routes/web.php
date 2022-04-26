<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TomController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;


use App\Models\Profile;
use Facade\FlareClient\Time\Time;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome'); });
Route::get('/guest', [LoginController::class, 'guestLogin'])->name('login.guest');

Auth::routes();
// ログインしていない場合、ログイン画面に戻す
Route::group(['middleware' => ['auth']] , function(){ 

    Route::get('/select',  function() {return view('select');} ) ;

    //index
    Route::get('/index', [HomeController::class, 'index'])->name('index');
    //reply
    Route::get('/index/{id}',[HomeController::class, 'reply'])->name('reply');
    Route::post('/rep_store', [HomeController::class, 'rep_store'])->name('rep_store');
    //reply-comments
    // Route::get('/rep_comment',[HomeController::class, 'index_rep_comment'])->name('index_rep_comment');
    Route::get('/rep_comment/{id}', [HomeController::class, 'rep_comment'])->name('rep_comment');
    Route::post('/rep_delete',[HomeController::class, 'rep_delete'])->name('rep_delete');

    Route::post('/comment_store',[HomeController::class, 'comment_store'])->name('comment_store');
    Route::post('/comment_delete', [HomeController::class, 'comment_delete'])->name('comment_delete');

    // Record
    Route::get('/record', [HomeController::class, 'record'])->name('record');
    Route::post('/store', [HomeController::class, 'store'])->name('store');
    //Route::get('/edit/{id}', function() { return view('edit'); } );
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
    Route::post('/update', [HomeController::class, 'update'])->name('update');
    Route::post('/delete', [HomeController::class, 'delete'])->name('delete');

    // My_page
    Route::get('/my_page', [MyPageController::class, 'index'])->name('my_page');
    Route::get('/store_profile', function() { return view('store_profile'); });
    Route::post('/s_profile', [MyPageController::class, 'store'])->name('s_profile');
    Route::get('/edit_profile/{id}', [MyPageController::class, 'edit'])->name('e_profile');
    Route::post('/update_profile', [MyPageController::class, 'update'])->name('u_profile');
    //他人のマイページを見る
    //Route::get('/user_page', [MyPageController::class, 'show'])->name('show') ;
    Route::get('/user_page/{id}', [HomeController::class, 'move'])->name('move');
    Route::get('/post' , [MyPageController::class, 'post'] )->name('post');
    Route::get('/post/{id}' , [MyPageController::class, 'list'] )->name('list');


    Route::get('/message', [MessageController::class, 'index'] )->name('dm');
    Route::get('/send/{id}', [MessageController::class, 'send'] )->name('send');
    Route::post('/message/store',  [MessageController::class, 'm_store'])->name('m_store');

    //ランキング
    // Route::get('/rank', function() {return view('rank'); })->name('rank');
    Route::get('/rank', [RankController::class, 'index'])->name('rank');
    Route::get('/rank_mount', [RankController::class, 'mount'])->name('mount');
    Route::get('/rank_average', [RankController::class, 'average'])->name('average');

    //友達申請
    Route::post('/request', [FriendController::class ,'request'])->name('request');
    Route::post('/dis_request', [FriendController::class ,'dis_request'])->name('dis_request');
    //Route::get('/user_page/{id}',[FriendController::class ,'select'])->name('select');

    Route::get('/try.show', [TomController::class,'show'] )->name('tomato');

    Route::post('/try/store', [TomController::class,'store'])->name('tom');
    Route::get('/app', function(){ return view('app');} );

    //いいね機能
    Route::get('/reply/like/{id}', [LikeController::class,'like'])->name('like');
    Route::get('/reply/unlike/{id}', [LikeController::class,'unlike'])->name('unlike');


    //検索ページ
    Route::group(['prefix' => 'search', 'as' => 'search.'], function(){

        //    Route::get('/', function(){ return view('search'); }  )->name('home');
           Route::get('/', [SearchController::class, 'index']  )->name('index');
        //    Route::post('/store', [SearchController::class, 'store']  )->name('store');
        //    Route::get('/display', function(){ return view('search'); }  );
           Route::post('/user', [SearchController::class, 'search']  )->name('user');
       
       
       });
       

});
