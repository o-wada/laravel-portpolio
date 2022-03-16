@extends('layouts.app')

@section('content')

<div class="container-fluid row w-75 mx-auto">

    <div class=" mx-auto col-md ">
        <!-- これまでの投稿（recordを表示） -->
            <!-- 戻るボタン -->
            <div class="w-75 mx-auto my-2">
                <p> <a href="{{ route('my_page') }}">戻る</a> </p>
            </div>

            <!-- 記録項目 -->
        @foreach($records as $record)

            <div class="card my-5 w-75 mx-auto">
                <div class=" row mx-2 my-3 pt-2">
                    <div class="col-md my-2">
                        <p class="border-bottom border-dark">日付 ：{{ $record->date }}</p>
                    </div>

                    <div class="col-md my-2">
                        <p class="border-bottom border-dark">体重 ：{{ $record->weight }}</p>
                    </div>

                    <div class="col-md my-2">
                        <p class="border-bottom border-dark ">カロリー収支 ：{{ $record->sum }}</p>
                    </div>
                    @if( $record->user_id = \Auth::user()->id )
                    <div class="col-md-1 text-center">
                        <a href="/edit/{{ $record->id }}" class="text-decoration-none text-black">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        </a>
                    </div>
                    @endif


                    <div class="my-2">
                        <p class="border-bottom border-dark me-5">今日の活動について ：</p>
                        <p class="border-bottom border-dark me-5">{{ $record->memo }}</p>
                    </div>
                </div>
            

                <!-- Likeボタンとリプライボタン /id -->
                <div class="bg-warning bg-opacity-10 ">
                    <div class="m-3 row">

                        <div class="col-md"></div>
                        <div class="col-md-2">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        </div>
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

                    </div> 
                </div>
            </div>
        @endforeach





    </div>
    

</div>

@endsection
