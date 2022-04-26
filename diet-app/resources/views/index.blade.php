@extends('layouts.app')

@section('content')

<div class="container-fluid ">

    <div class="mx-auto ">

         @if((\Route::currentRouteName() === 'index') )
         <div class="w-75 mx-auto row">
         @endif
            <!-- もどるボタン -->
             @if(!(\Route::currentRouteName() === 'index') )
                <div class="w-75 mx-auto" >

                    <div class="w-25 ms-2" >
                        <button class="btn btn-outline-warning form-control">
                            <a href="/index" class="text-black text-decoration-none px-5 "> 《 戻る </a>
                        </button>
                    </div>

                </div>

            <div class="row w-75 mx-auto">
             @endif            
                   @if((\Route::currentRouteName() === 'index'))
                   <div class="col-md-4">
                        <!-- 経過日数 -->
                        <div class="my-4 card mx-3 text-center">
                            <h4 class="pt-2">開始から {{$count_date}} 日目</h4>
                        </div>
                        <!-- カロリー表示 -->
                        <div class="card mx-3 my-4">
                            <p class="px-2 pt-3">{{Auth::user()->name}}さんの</p>
                            <p class="px-2">減量目標を達成するには、合計{{ $target }} kcalのカロリー消費が必要です。</p>
                        </div>
                        <div class="card mx-3 my-4">
                            <p class="px-2 pt-3  ">目標まであと  - {{ $balance }} kcalです。</p>      
                            <p class="px-2">1kg 減量まであと - {{$cal}} kcalです。</p>
                        </div>
                        <div class="card mx-3 my-4">

                            <!-- 平均 -->
                            @if($average < 0)
                            <p class="px-2 pt-3 " >1日の平均カロリー収支は {{ $average }}kcalです。</p>
                            @elseif($average >= 0 )
                            <p class="px-2 pt-3">1日の平均カロリー収支は +{{ $average }}kcalです。</p>
                            @endif

                            <!-- 目標までのみちのり -->
                            @if($target <= $balance)
                            <p>カロリー収支をマイナスにして、目標までの道のりを確認しよう！</p>
                            @elseif($target > $balance)
                            <p class="px-2 ">目標達成まで</p>
                            <h3 class="px-2 ms-5">あと、{{$finish}} 日！</h3>
                            <p> <small>(* 1日の平均カロリーをもとに計算しています。) </small> </p>
                            @endif
                        </div>
                        <div class="card mx-3 my-4">
                            チャート
                        </div>
                   </div>

                    <!-- 消さない -->
                    <div class="col-md-8">

                        @endif

                        @foreach($records as $record)

                            <!-- 画面を2分割にする左側 -->
                            @if(!(\Route::currentRouteName() === 'index') )
                            <div class="col-md">
                            @endif

                                <div class="card my-4 mx-auto">
                                    <!-- 名前と日付 -->
                                    <div class="bg-warning bg-opacity-10 row pt-3 mx-0 px-0">

                                        <div class="col-md my-auto ">
                                            <div class="row">

                                                @if($record->user_id == \Auth::user()->id) 
                                                    <div class="col-md-2">
                                                        @if($record->picture == NULL )
                                                            <i class="fa-solid fa-user fa-3x ms-3"></i>  
                                                        @else
                                                            <img src="/images/{{ $record->picture }}" alt="a"  width="75px" height="75px" class="rounded rounded-circle float-start ">
                                                        @endif
                                                    </div>
                                                    <div class="col-md">
                                                        <h4> <a href="/my_page" class="px-4">{{ $record->name }}</a>  </h4>
                                                        <p><small class="px-4">{{ $record->updated_at }}</small></p> 
                                                    </div>
                                                @else
                                                    <div class="col-md-2">
                                                        @if($record->picture == NULL )
                                                            <i class="fa-solid fa-user fa-3x ms-3"></i>  
                                                        @else
                                                            <img src="/images/{{ $record->picture }}" alt="a"  width="75px" height="75px" class="rounded rounded-circle float-start ">
                                                        @endif
                                                    </div>
                                                    <div class="col-md">
                                                        <h4> <a href="/user_page/{{ $record->profile_id }}" class="px-4">{{ $record->name }}</a>  </h4>
                                                        <p><small class="px-4">{{ $record->updated_at }}</small></p> 
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <!-- 自分の投稿のみ編集ボタンが出力されるようにする -->
                                            @if( ($record->user_id == \Auth::user()->id) && (\Route::currentRouteName() === 'index') )
                                            <a href="/edit/{{ $record->id }}" class="text-decoration-none text-black">
                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                            </a>
                                            @endif
                                        </div>

                                    </div>

                                    <!-- 記録項目 -->
                                    <div class="row mx-2 my-3">

                                        <div class="col-md my-2">
                                            <p class="border-bottom border-dark">体重 ：{{ $record->weight }}</p>
                                        </div>

                                        <div class="col-md my-2">
                                            <p class="border-bottom border-dark ">カロリー収支 ：{{ $record->sum }}</p>
                                        </div>

                                        <div class="my-2">
                                            <p class="border-bottom border-dark">今日の活動について ：</p>
                                            <p class="border-bottom border-dark">{{ $record->memo }}</p>
                                        </div>

                                    </div>

                                    <!-- Likeボタンとリプライボタン /id -->
                                    <div class="bg-warning bg-opacity-10 ">
                                        <div class="m-3 row">
                                            @if(\Route::currentRouteName() === 'index')
                                                <div class="col-md"></div>
                                                <!-- like 判定がうまくいかない -->
                                                <div class="col-md-2">

                                                       <!-- データが入ってれば赤 -->          
                                                            <a href="{{ route('unlike', ['id' => $record->id]) }}" class="btn btn-danger opacity-75 btn-sm" name='post'>
                                                            <i class="fa fa-heart" aria-hidden="true"></i>    
                                                            <span class="badge">済</span></a>
                                                   
                                                        <!-- データなければ灰色 -->                                                     
                                                            <a href="{{ route('like', ['id' => $record->id]) }}" class="btn btn-secondary btn-sm"  name='post'>
                                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                                            <span class="badge">未</span></a>
                                                   
                                                </div>

                                                <!-- リプライ -->
                                                <div class="col-md-2 ">
                                                    <a href="/index/{{ $record->id }}" class="btn btn-dark btn-sm text-decoration-none">
                                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                                            <span> 
                                                            @foreach($counts as $count)
                                                                @if($count->host_id == $record->id)
                                                                {{ $count->reply }} 
                                                                @endif
                                                            @endforeach
                                                            </span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div> 
                                    </div>
                            
                                    <!-- コメントを一覧表示 /rep_id -->
                                    @if(!(\Route::currentRouteName() === 'index') )
                                        @foreach($reps as $rep)

                                            <div class="border">


                                                <div class="bg-primary bg-opacity-10 row pt-3 mx-0 px-0">
                                                    <div class="icon col-md-2">
                                                        <img src="/images/{{ $rep->picture }}" alt="no_image" width="50px" height="50px" class="rounded rounded-circle float-start">
                                                    </div>
                                                    <div class="col-md">
                                                        <!-- 自分の場合はマイページ 他人の場合はユーザーページにとぶ -->
                                                        @if($rep->user_id == \Auth::user()->id) 
                                                            <h4> <a href="/my_page">{{ $rep->name }}</a>  </h4>
                                                            <p><small>{{ $rep->updated_at }}</small></p> 
                                                        @else
                                                            <h4> <a href="/user_page/{{ $rep->user_id }}">{{ $rep->name }}</a>  </h4>
                                                            <p><small>{{ $rep->updated_at }}</small></p> 
                                                        @endif
                                                    </div>
                                                    <div class="col-md-1 p-0 me-3">
                                                        <!-- 自分の投稿のみ削除ボタンが出力されるようにする /id -->
                                                        @if( $rep->user_id == \Auth::user()->id )
                                                        <form action="{{ route('rep_delete') }}" method="post" >
                                                            @csrf
                                                            <input type="hidden" name="rep_id" value="{{ $rep->id }}">
                                                            <button class="btn btn-dark">
                                                                <i class="fa fa-trash" aria-hidden="true " class=""></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="my-5">
                                                    <p class="border-bottom border-dark mx-3">{{ $rep->comment }}</p>
                                            
                                                </div>

                                                <div class="bg-primary bg-opacity-10 mx-0 pb-3 row">
                                                        <div class="col-md"></div>
                                                        <div class="col-md"></div>
                                                        <div class="pt-3 mx-3 col-md ">
                                                            <a href="" class="mx-2 text-decoration-none px-3 ">
                                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="/rep_comment/{{ $rep->id }}" class="m-2 text-decoration-none">
                                                                <i class="fa fa-comment" aria-hidden="true"></i>
                                                                @foreach($counts as $count)

                                                                @if($count->reply_id == $rep->id)
                                                                {{ $count->comment }} 
                                                                @endif

                                                                @endforeach

                                                            </a>
                                                        </div> 
                                                </div>

                                            </div>
                                        
                                        @endforeach
                                    @endif

                                </div>
                            
                            @if(!(\Route::currentRouteName() === 'index') )
                                </div>
                            @endif                            

                            <!-- 画面を2分割にする右側 -->
                            @if(!(\Route::currentRouteName() === 'index') )
                            <div class="col-md ">
                            @endif
                                <div class="row">
                                    <div class="position-fixed col-md-5">
                                        <!-- 返信機能 indexページには表示しない、コメントボタンで飛ぶ先の個別ページのみに表示したい -->
                                        @if(!(\Route::currentRouteName() === 'index') )

                                        <div class="card my-4">

                                            <div class=" bg-primary bg-opacity-10 row mx-0 py-3 ">

                                                    <div class=" ms-5 my-auto">
                                                        <h4 > {{ \Auth::user()->name }}  </h4>
                                                    </div>

                                            </div>

                                            <div class="m-3 ">
                                                <form action="{{ route('rep_store') }}" method="post">
                                                @csrf
                                                    <div class="row">
                                                        <p class="col-md pt-2"> {{ $record->name }}さんの投稿にコメントする </p>
                                                        <input type="hidden" name="host_id" value="{{ $record->id }}">
                                                    </div>
                                                    <textarea name="comment" id="" cols="30" rows="3" class="form-control"></textarea>
                                                    <input type="submit" name="submit" value="送信" class="form-control w-25 float-end btn-outline-primary mt-3">
                                                </form>
                                            </div>
                                            
                                        </div>
                                        
                                        @endif
                                    </div>
                                    <div class="col-md"></div>
                                </div>
                            @if(!(\Route::currentRouteName() === 'index') )
                            </div>
                            @endif

                        
                    
                        @endforeach
                    </div>

             @if(!(\Route::currentRouteName() === 'index') )
            </div>
             @endif

         @if(!(\Route::currentRouteName() === 'index') )
        </div>
         @endif
    </div>

    
</div>

@endsection
