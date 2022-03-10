@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="w-75 mx-auto card my-3 p-3">
        <!-- メッセージのやり取りを追加する -->
        <div class="mt-3">
            <h3>友達一覧</h3>
            <form action="" method="post">
                @foreach($users as $user)
                @if(!($user['id'] == \Auth::user()->id) )
                <p> <a href="/send/{{ $user['id'] }}"> {{ $user['name'] }} </a>  </p>
                @endif
                @endforeach
            </form>

        </div>

        <!-- メッセージルームの一覧を表示する -->
    </div>
</div>
@endsection