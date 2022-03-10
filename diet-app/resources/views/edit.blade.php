@extends('layouts.app')

@section('content')

<div class="card w-75 mx-auto p-3">
    <!-- 削除機能 -->
    <div class="mb-3">
        <form action="{{ route('delete') }}" method="post" >
           @csrf
           <input type="hidden" name="record_id" value="{{ $edit_record['id'] }}">   
           <button type="submit" name="delete" class="form-control w-25 float-end text-white bg-primary" >
               <i class="fa fa-trash" aria-hidden="true"> 削除</i>
            </button>
        </form>

    </div>

    <!-- 編集機能 -->
    <form class="row g-3" action="{{ route('update') }}" method="post">
     @csrf
        <input type="hidden" name="record_id" value="{{ $edit_record['id'] }}">
                
        <div class="col-md-3">
            <label for="date" class="form-label">日時</label>
            <input type="date" class="form-control" name="date" required value="{{ $edit_record['date'] }}">
        </div>
        <div class="col-md-3">
            <label for="weight" class="form-label">体重</label>
            <input type="number" class="form-control" step="0.1" name="weight" required value="{{ $edit_record['weight'] }}">
        </div>
        <div class="col-md-3">
            <label for="intake" class="form-label">摂取カロリー</label>
            <input type="number" class="form-control" name="intake" required value="{{ $edit_record['intake'] }}">
        </div>
        <div class="col-md-3">
            <label for="consumption" class="form-label">消費カロリー</label>
            <input type="number" class="form-control" name="consumption" required value="{{ $edit_record['consumption'] }}">
        </div>
             <input type="hidden" name="sum" value="{{ $edit_record['sum'] }}">
        <div class="">
            <label for="memo" class="form-label">メモ</label>
            <textarea name="memo" class="form-control col-8" name="memo" cols="30" rows="10" >{{ $edit_record['memo'] }}</textarea>
        </div>
        
        <!-- indexにいるときの戻り先はindex -->
        <div class="col-md-2"> 
            <a href="{{ route('index') }}" class="form-control my-3 border-0 text-center bg-primary text-white text-decoration-none">« 戻る</a> 
        </div>

        

        <div class="col-md"></div>
        <div class="col-md-4 ">
            <button type="submit" class="btn btn-primary form-control my-3">更新する</button>
        </div>
    </form>
</div>

@endsection
