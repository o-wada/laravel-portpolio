@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="card w-75 mx-auto my-2" >
    @foreach($profiles as $profile)
        <!-- icon uname -->
        <div class="content">
        <form action="{{ route('u_profile') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="profile_id" value="{{ $edit_profile['id'] }}">   
            <div class="row my-5" >
                <h4 class="text-center col-md"> {{ Auth::user()->name }} </h4> 
                <input type="file" class="col-md " name="picture" >
            </div> 
            <div class="inform m-3 ">
                    <div class="inform-items my-3 p-3">
                        <div class="m-2">
                            <div class="d-flex my-2">
                                <label for="target" class="pt-2 w-25">目標体重 :</label>
                                <input type="text" name="target" class="form-control w-50" required  value="{{ $profile['target'] }}"> 
                            </div>
                            <label for="way" class="mb-3">ダイエット方針 :</label>
                            <select name="way" class="form-control mb-1" required >
                                <option value={{ $profile['way'] }}>{{$profile['way']}}</option>
                                <option value="糖質制限">糖質制限</option>
                                <option value="脂質制限">脂質制限</option>
                                <option value="ボディメイク">ボディメイク</option>
                                <option value="パレオ式">パレオ式</option>
                                <option value="その他">その他</option>
                            </select>
                            <input type="text" name="other" class="form-control mb-3" placeholder="その他の場合は、こちらに記載してください" value="{{ $profile['other'] }}">
                            <textarea name="rule" id="" cols="30" rows="10" class="form-control mb-3" > {{ $profile['rule'] }}</textarea>
                        </div>

                        <div class="row text-center m-2 ">
                            <h5 class="w-25 my-3">基本情報</h5>    
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="age" class="form-label w-25 pt-2" >年齢:</label>
                                <input type="number" name="age" class="form-control w-50" value="{{ $profile['age'] }}">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="gender" class="form-label w-25 pt-2">性別:</label>
                                <select name="gender" id="" class="form-control w-50" required>
                                    <option value={{$profile['gender']}}>{{$profile['gender']}}</option>
                                    <option value="男性">男性</option>
                                    <option value="女性">女性</option>
                                    <option value="その他">その他</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="tall" class="form-label w-25 pt-2">身長:</label>
                                <input type="number" step="0.1" class="form-control w-50" name="tall" required value="{{ $profile['tall'] }}">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="weight" class="form-label w-25 pt-2">体重:</label>
                                <input type="number" step="0.1" class="form-control w-50" name="weight" required value="{{ $profile['weight'] }}">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="shape" class="form-label w-25 pt-2">骨格:</label>
                                <select name="shape"  class="form-control w-50" required>
                                    <option value={{$profile['shape']}}>{{$profile['gender']}}</option>
                                    <option value="細身">細身</option>
                                    <option value="普通">普通</option>
                                    <option value="太め">太め</option>
                                    <option value="ガッチリ">ガッチリ</option>
                                    <option value="その他">その他</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md"> 
                                <a href="{{ route('my_page') }}" class="form-control my-3 border-0 text-center bg-primary text-white text-decoration-none">« 戻る</a> 
                            </div>
                            <div class="col-md"></div>
                            <div class="col-md">
                                <input type="submit" value="更新" name="submit" class="form-control bg-primary my-3 text-white">
                            </div>

                        </div>

                    </div>
            </div>
        
        </div>

        <div class="card-body m-3">
        

        </div>


    @endforeach
    </div>
</div>

@endsection
