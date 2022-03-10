@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card w-75 mx-auto my-2" >
        <!-- icon uname -->
        <div class="content" >

            <div class="m-3 w-75 mx-auto ">
                <div class=" row my-3">
                    @foreach($profiles as $profile)
                    <img src="/images/{{ $profile['picture'] }}" alt="no_image"  class="col-md-3 rounded rounded-circle float-start ">
                    @endforeach
                    <h4 class="col-md fw-bold fs-1 ms-5 my-auto"> {{ Auth::user()->name }} </h4> 

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
                        <a href="/post">投稿一覧</a>                    
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
@endsection