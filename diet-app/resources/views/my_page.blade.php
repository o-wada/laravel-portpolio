@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="w-75 mx-auto my-2" >
        <!-- icon uname -->
        <div class="row" >
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
                    <p class="px-2 pt-3">目標まであと  - {{ $balance }} kcalです。</p>      
                    <p class="px-2">1kg 減量まであと - {{$cal}} kcalです。</p>
                </div>
                <div class="card mx-3 my-4">

                    <!-- 平均 -->
                    @if($average < 0)
                    <p class="px-2 pt-3">1日の平均カロリー収支は {{ $average }}kcalです。</p>
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


            
            <div class="col-md-8 card my-4">

                <div class="m-3 w-75 mx-auto ">
                    
                    <div class=" row my-3">
                        <div class="col-md-3">
                        @foreach($profiles as $profile)
                            @if($profile->picture == NULL )
                            <i class="fa-solid fa-user fa-3x ms-5"></i>  
                            @else
                            <img src="/images/{{ $profile->picture }}" alt="a"  width="100px" height="100px" class="rounded rounded-circle float-start ">
                            @endif
                       @endforeach
                        </div>
                        <div class="col-md">
                            <h4 class="col-md fw-bold fs-1 ms-5 my-auto"> {{ Auth::user()->name }} </h4> 
                        </div>

                    </div>
                    @if( $first  >= 1)
                    <div class="row mx-3 text-center">
                        <div class="col-md">
                        </div>
                        <div class="col-md">
                        </div>
                        <div class="col-md">
                        </div>             
                        <div class="col-md">
                            @foreach($profiles as $profile)
                            <a href="/post/{{ $profile['id'] }}">投稿一覧</a>                    
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row" >
                    <div class="col-md"></div>
                    <div class="col-md">

                        @if( $first  >= 1)
                            @foreach($profiles as $profile)
                        <a href="/edit_profile/{{ $profile['id'] }}" class="mx-auto w-50 form-control my-3 border-0 text-center bg-primary text-white text-decoration-none"> 編集する </a>
                            @endforeach
                        @else
                        <p>まずは、プロフィールを登録してください。↓</p>
                        <a href="/store_profile" class="mx-auto w-50 form-control my-3 border-0 text-center bg-primary text-white text-decoration-none"> プロフィールを登録する </a>
                        @endif
                    </div>
                </div>



                 



                <form action="{{ route('my_page') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="inform-items p-3 ">
                        @foreach($profiles as $profile)
                            <div class="row m-2 w-75 mx-auto">
                                <div class="col-md">
                                    <p class="mt-2">目標体重： {{ $profile['target'] }}</p>
                                    <p class="mt-2">ダイエット方針： {{ $profile['way'] }} {{ $profile['other'] }}</p>
                                </div>

                                <textarea class="mt-2 form-control bg-white" cols="30" rows="10">{{ $profile['rule'] }}</textarea>
                            </div>


                            <div class="row my-4 ">
                                <div class="w-75 mx-auto my-3">
                                    <h5 class="my-3">基本情報</h5>    
                                    <div class="w-50 mx-auto">
                                        <p class="mt-2">年齢： {{ $profile['age'] }}</p>
                                        <p class="mt-2">性別： {{ $profile['gender'] }}</p>
                                        <p class="mt-2">身長： {{ $profile['tall'] }}</p>
                                        <p class="mt-2">体重： {{ $profile['weight'] }}</p>
                                        <p class="mt-2">体格： {{ $profile['shape'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection