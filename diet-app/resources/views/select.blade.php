@extends('layouts.app')

@section('content')

<div class="container-fluid  py-5">

    <div class="mx-auto ">
        <!-- カロリー収支の表示 -->
        <div class="card mx-auto w-50 bg-warning bg-opacity-50">
            {{Auth::user()->name}}さん
            <p>次の目標まであと-xx kcalです。</p>
            <p>level 23</p>
        </div>

        <!-- select部分 -->
        <div class=" row mx-auto w-50 ">
            <div class="col-md-4 text-center py-5 ">
                <button class="btn bg-warning bg-opacity-50 py-5">
                    <a href="/record" class="p-4  text-black ">記録する</a>
                    <p>今日の成果を記録しましょう</p>
                </button>
            </div>
            <div class="col-md-4 text-center py-5 ">
                <button class="btn bg-warning bg-opacity-50 py-5 ">
                    <a href="/index" class="p-4 text-black ">タイムライン</a>
                </button>
            </div>
            <div class="col-md-4 text-center py-5 ">
                <button class="btn bg-warning bg-opacity-50 py-5 ">
                    <a href="/" class="p-5 text-black ">検索</a>
                </button>
            </div>
            <div class="col-md-4 text-center py-5 border border-danger">
                <button class="btn bg-warning bg-opacity-50 py-5 ">
                    <a href="/my_page" class="p-4 text-black ">マイページ</a>
                </button>
            </div>
            <div class="col-md-4 text-center py-5 ">
                <button class="btn bg-warning bg-opacity-50 py-5 ">
                    <a href="/message" class="p-4 text-black ">メッセージ</a>
                </button>
            </div>
            <div class="col-md-4 text-center py-5 ">
                <button class="btn bg-warning bg-opacity-50 py-5 ">
                    <a href="/rank" class="p-4 text-black ">ランキング</a>
                </button>
            </div>

        </div>

    </div>
    

</div>

@endsection
