@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card w-75 mx-auto my-2" >
        <!-- icon uname -->
        <div class="content" >
        @foreach($profiles as $profile)

            <div class="m-3 w-75 mx-auto ">
                <div class="row ">
                    <div class="col-md">
                        <img src="/images/{{ $profile->picture }}" alt="a"  width="100px" height="100px" class="rounded rounded-circle float-start ">
                    </div>

                    <div class="col-md my-auto">
                        <h4 class="fw-bold fs-1 text-center "> {{ $profile->name }} </h4> 
                    </div>
                    <div class="col-md m-auto text-center">
                        @if( $profile->id == 0 )
                        <!-- 友達申請機能 友達追加前に表示  -->
                        <form action="{{ route('request') }}" method="post" >
                            @csrf
                            <input type="text" name="request" value="1">
                            <input type="text" name="permission_user" value="{{ $profile->user_id }}">
                            <input type="submit" value="友達申請" name="make">
                        </form>
                        <form action="{{ route('dis_request') }}" method="post">
                            @csrf
                            <!-- 申請中はキャンセルボタンに変化 -->
                            <input type="text" name="request" value="2">
                            @foreach($select as $sel)
                            <input type="text" name="request_id" value="{{ $sel->id }}">
                            @endforeach
                            <input type="submit" value="友達申請中" name="dis">


                        </form> 
                        @endif
                        <!-- DM機能 友達追加後に表示 -->
                        <a href="/send/{{ $user['id'] }}">メッセージを送る</a>
                       
                    </div>

                    <div class="row mx-3 text-center">
                        <div class="col-md">
                            <a href="">プロフィール</a>
                        </div>
                        <div class="col-md">
                            <a href="/post">投稿一覧</a>
                        </div>
                    </div>

                </div>
            </div>


            </div> 



            <!-- プロフィールの表示 -->

            <div class="">

                <div class="inform-items my-3 p-3 ">
                    <div class="row m-2 w-75 mx-auto">
                        <div class="col-md">
                            <p class="mt-2">目標体重： {{ $profile->target }}</p>
                            <p class="mt-2">ダイエット方針： {{ $profile->way }}</p>
                        </div>
                        <div class="col-md " >
                        </div>

                        <textarea class="mt-2 form-control bg-white" cols="30" rows="10">{{ $profile->rule }}</textarea>
                    </div>


                    <div class="row my-4 ">
                        <div class="w-75 mx-auto my-3">
                            <h5 class="my-3">基本情報</h5>    
                            <div class="w-50 mx-auto">
                                <p class="mt-2">年齢： {{ $profile->age }}</p>
                                <p class="mt-2">性別： {{ $profile->gender }}</p>
                                <p class="mt-2">身長： {{ $profile->tall }}</p>
                                <p class="mt-2">体重： {{ $profile->weight }}</p>
                                <p class="mt-2">体格： {{ $profile->shape }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
            


       


        @endforeach
        </div>
    </div>
    

</div>
@endsection