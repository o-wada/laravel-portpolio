@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mx-auto w-50 ">

        <!-- リンク -->
        <div class="row mt-3 mx-0 bg-warning bg-opacity-10 ">
            <div class="col-md text-center border py-3"> <a href="/rank" class="text-black">今日</a> </div>
            <div class="col-md text-center border py-3"> <a href="/rank_mount" class="text-black">累計</a> </div>
            <div class="col-md text-center border py-3"> <a href="/rank_average" class="text-black">平均</a> </div>
        </div>

        <div class="card">
            <div class="border bg-warning bg-opacity-25 mx-0 pt-3">
                <h2 class="text-center">平均値のランキング</h2>
            </div>
                <!-- ランキング表示 -->
                @foreach($ranks as $rank)
                <div class="card py-4">
                    <div class="row mx-0">    
                        <h3 class="col border-bottom text-center border-dark"> {{ $loop->iteration }} 位</h3>
                        <h3 class="col border-bottom text-center border-dark"> {{ $rank->name }}  </h3>
                        <h6 class="col border-bottom text-center border-dark pt-2"> カロリー収支  {{ $rank->sum }} kcal </h6>
                    </div>

                </div>
                @endforeach

        </div>

    </div>
    

</div>

@endsection
