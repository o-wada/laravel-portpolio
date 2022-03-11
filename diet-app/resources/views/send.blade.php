@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="w-75 mx-auto card my-3 p-3">
        <!-- メッセージルームの一覧を表示する -->
        @foreach($chats as $chat)
            <div class="row w-75 mx-auto">
                <!-- 相手が送ったものが見える -->
                <div class="col-md ">
                @if( ($chat->user_id == $send['id']) && ($chat->accept_user == \Auth::user()->id)  )
                <div class="bg-light">
                    <p>{{ $chat->name }}</p>
                    <p class="bg-warning bg-opacity-10">{{ $chat->comment }}</p>
                    <p>{{ $chat->updated_at }}</p>
                </div>
                @endif
                </div>

                <!-- 自分が送ったものが見れる -->
                <div class="col-md ">
                @if( ($chat->accept_user == $send['id']) && ( $chat->user_id == \Auth::user()->id ) )
                <div class="bg-light">
                    <p>{{ $chat->name }}</p>
                    <p class="bg-primary bg-opacity-10">{{ $chat->comment }}</p>
                    <p>{{ $chat->updated_at }}</p>
                </div>
                @endif
                </div>

                


            </div>
        @endforeach

        <!-- メッセージのやり取りを追加する -->
        <div class="mt-3 w-75 mx-auto">
            <h3>{{ $send['name']}}さんにメッセージを送信</h3>
            <form action="{{ route('m_store') }}" method="post">
                @csrf
                <input type="hidden" name="accept_user" value="{{ $send['id'] }}">
                <input type="hidden" name="" value="{{ \Auth::user()->id }}">
                <textarea name="comment" cols="30" rows="5" class="form-control mb-3"></textarea>
                
                <div class="row">
                    <div class="col-md ">
                        <a href="/message" class="my-2 form-control text-center text-decoration-none px-5">退出</a>
                    </div>
                    <div class="col-md"></div>
                    <div class="col-md">
                        <input type="submit" value="送信" name="submit" class="my-2 form-control ">
                    </div>
                </div>
                
            </form>

        </div>


    </div>
</div>
@endsection