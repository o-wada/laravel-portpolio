@extends('layouts.app')

@section('content')

<div class="container-fluid">
        <!-- display target & chart -->
<div>
    <div class="mx-auto w-50 p-3 row">

    
        <div class="card col-md pt-3 mx-auto bg-warning bg-opacity-10"> 
            <!-- 記録の有無によって条件分岐 完了した場合は、編集の画面を提示-->
            @if( $counts == 0 )
            <form class="row g-3" action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- 名前と日付 -->
                <div class="my-3 bg-warning bg-opacity-10">
                    <p class="m-3">  {{ Auth::user()->name }}さん、今日の記録をしましょう。 </p> 
                    <input type="text" class="border-0 text-center bg-warning bg-opacity-10" value="{{ $dt }}" name="date">
                    <input type="hidden" name="profile_id" value="{{ Auth::user()->id }}">
                </div>
                <!-- 記録項目 -->
                <div class="items row text-center">
                    <div class="col-md-4 my-2">
                        <label for="weight" class="form-label">体重</label>
                        <input type="number" class="form-control" step="0.1" name="weight" required>
                    </div>
                    <div class="col-md-4 my-2">
                        <label for="intake" class="form-label">摂取カロリー</label>
                        <input type="number" class="form-control" name="intake" required>
                    </div>
                    <div class="col-md-4 my-2">
                        <label for="consumption" class="form-label">消費カロリー</label>
                        <input type="number" class="form-control" name="consumption" required>
                    </div>
                    <div class="my-2">
                        <label for="memo" class="form-label">活動内容の記録</label>
                        <textarea name="memo" class="form-control" name="memo" cols="30" rows="10"> </textarea>
                    </div>

                    <div class="col-8"></div>
                    <div class="col-4 ">
                        <button type="submit" class="btn btn-outline-warning form-control text-black my-3">登録する</button>
                    </div>

                </div>
            </form>
            <!-- 編集画面を案内 -->
            @else
                <div class="my-5 mx-3">
                    <p>本日の記録は完了しております。</p>
                    <p>記録を編集する場合はこちらからどうぞ。
                        @foreach($changes as $change)
                        <a href="/edit/{{ $change['id'] }}" class=""> 編集する  <br> </a>
                        @endforeach 
                    </p>
                </div>
            @endif
        </div>
    
    
    </div>
 

</div>

@endsection
