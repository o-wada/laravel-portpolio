@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="card w-75 mx-auto " >
        <!-- icon uname -->
        <div class="content">
        <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="profile_id" value="">   
            <div class="icon m-3 p-3 overflow-auto" >
                <input type="file" class="mt-5 float-md-end form-control-file border-0 bg-white" name="picture">
                <img src="" alt="" class="rounded rounded-circle float-start p-5 border">
            </div>
            <div class="uname m-3 w-25"> 
                <h4 class="text-center pt-2"> username </h4> 
            </div> 
            <div class="inform m-3 ">
                    <div class="inform-items my-3 p-3">
                        <div class="m-2">
                            <div class="d-flex my-2">
                                <label for="target" class="pt-2 w-25">目標体重 :</label>
                                <input type="text" name="target" class="form-control w-50" required  value=""> 
                            </div>
                            <label for="way" class="mb-3">ダイエット方針 :</label>
                            <input type="text" name="way" class="form-control " value="">
                            <input type="text" name="other" class="form-control mb-3" placeholder="その他の場合は、こちらに記載してください" value="">
                            <textarea name="rule" id="" cols="30" rows="10" class="form-control mb-3" > </textarea>
                        </div>

                        <div class="row text-center m-2 ">
                            <h5 class="w-25 my-3">基本情報</h5>    
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="age" class="form-label w-25 pt-2" >年齢:</label>
                                <input type="number" name="age" class="form-control w-50" value="">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="gender" class="form-label w-25 pt-2">性別:</label>
                                <input type="text" name="gender" class="form-control w-50" value="">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="tall" class="form-label w-25 pt-2">身長:</label>
                                <input type="number" step="0.1" class="form-control w-50" name="tall" required value="">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="weight" class="form-label w-25 pt-2">体重:</label>
                                <input type="number" step="0.1" class="form-control w-50" name="weight" required value="">
                            </div>
                            <div class="col-md-12 mb-3 d-flex">
                                <label for="shape" class="form-label w-25 pt-2">骨格:</label>
                                <input type="text" name="shape" class="form-control w-50" value="">
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


    </div>
</div>

@endsection
