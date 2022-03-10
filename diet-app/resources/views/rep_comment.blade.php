@extends('layouts.app')

@section('content')

<div class="container-fluid row w-75 mx-auto">

    <div class="mx-auto col-md ">

        <!-- 一番最初の投稿を表示 -->
        @foreach($records as $record)
        
        <!-- 戻るボタン -->
        <button class="btn btn-outline-warning mb-3 w-50">
            <a href="/index/{{ $record->id }}" class="p-5 text-decoration-none text-dark px-5">《 戻る</a>
        </button>

            <div class="border">
                <!-- 名前と画像と日付 -->
                <div class="bg-warning bg-opacity-10 row pt-3 mx-0 px-0">

                    <div class="icon col-md-2">
                        <img src="/images/{{ $record->picture }}" alt="no_image" width="50px" height="50px" class="rounded rounded-circle float-start">
                    </div>

                    <div class="col-md">
                    @if($record->user_id == \Auth::user()->id) 
                            <h4> <a href="/my_page">{{ $record->name }}</a>  </h4>
                            <p><small>{{ $record->updated_at }}</small></p> 
                        @else
                            <h4> <a href="/user_page/{{ $record->profile_id }}">{{ $record->name }}</a>  </h4>
                            <p><small>{{ $record->updated_at }}</small></p> 
                        @endif
                    </div>
                        <!-- 自分の投稿のみ編集ボタンが出力されるようにする -->
                    <div class="col-md-1">
                        @if( $record->user_id == \Auth::user()->id )
                        <a href="/edit/{{ $record->id }}" class="text-decoration-none text-black">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        </a>
                        @endif
                    </div>

                </div>

                <!-- 記録項目 -->
                <div class="row mx-2 my-3">

                    <div class="col-md my-2">
                        <p class="border-bottom border-dark">体重 ：{{ $record->weight }}</p>
                    </div>

                    <div class="col-md my-2">
                        <p class="border-bottom border-dark ">カロリー収支 ：{{ $record->sum }}</p>
                    </div>

                    <div class="my-2">
                        <p class="border-bottom border-dark">今日の活動について ：</p>
                        <p class="border-bottom border-dark">{{ $record->memo }}</p>
                    </div>

                </div>

                <!-- Likeボタンとリプライボタン /id -->
                <div class="bg-warning bg-opacity-10 ">
                    <div class="p-3 mx-5 row">
                        <div class="col-md"></div>
                        <div class="col-md-3">
                            <a href="" class="text-decoration-none">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div> 
                </div>

            </div>
        @endforeach
          
        
        <!-- コメント一覧を表示 -->
        @foreach($reps as $rep)

            <div class="border ">

                <div class="bg-primary bg-opacity-10 row pt-3 mx-0 px-0">
                    <div class="icon col-md">
                        @if($rep->user_id == \Auth::user()->id) 
                            <img src="/images/{{ $record->picture }}" alt="no_image" width="50px" height="50px" class="rounded rounded-circle float-start">
                            <h4> <a href="/my_page" class="px-4">{{ $record->name }}</a>  </h4>
                            <p><small class="px-4">{{ $record->updated_at }}</small></p> 
                        @else
                            <img src="/images/{{ $rep->picture }}" alt="no_image" width="50px" height="50px" class="rounded rounded-circle float-start">
                            <h4 > <a href="/user_page/{{ $rep->profile_id }}" class="px-4">{{ $rep->name }}</a>  </h4>
                            <p><small class="px-4">{{ $record->updated_at }}</small></p> 
                        @endif
                    </div>
                </div>

                <div class="my-5">
                    <p class="border-bottom border-dark mx-3">{{ $rep->comment }}</p>
            
                </div>

                <div class="bg-primary bg-opacity-10 mx-0 pb-3 row">
                        <div class="col-md"></div>
                        <div class="col-md"></div>
                        <div class="pt-3 mx-3 col-md">
                            <a href="" class="mx-2 text-decoration-none px-3 ">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </a>
                            @if(!(\Route::currentRouteName() === 'rep_comment'))
                            <a href="/rep_comment/{{ $rep->id }}" class="m-2 text-decoration-none">コメント</a>
                            @endif
                        </div> 
                </div>

            </div>

        @endforeach

        <!-- コメントに対する返信を表示 -->
        @foreach($comments as $comment)

            <div class="border">

                <div class="bg-info bg-opacity-10 row pt-3 mx-0 px-0">
                    <div class="icon col-md">
                        @if($comment->user_id == \Auth::user()->id) 
                            <img src="/images/{{ $record->picture }}" alt="no_image" width="50px" height="50px" class="rounded rounded-circle float-start">
                            <h4> <a href="/my_page" class="px-4">{{ $comment->name }}</a>  </h4>
                            <p><small class="px-4">{{ $comment->updated_at }}</small></p> 
                        @else
                            <img src="/images/{{ $comment->picture }}" alt="no_image" width="50px" height="50px" class="rounded rounded-circle float-start">
                            <h4 > <a href="/user_page/{{ $comment->user_id }}" class="px-4">{{ $comment->name }}</a>  </h4>
                            <p><small class="px-4">{{ $comment->updated_at }}</small></p> 
                        @endif
                    </div>

                    <div class="col-md-1 p-0 me-3">
                        <!-- 自分の投稿のみ削除ボタンが出力されるようにする /id -->
                        @if( $comment->user_id == \Auth::user()->id )
                        <form action="{{ route('comment_delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <button class="btn btn-dark">
                                <i class="fa fa-trash" aria-hidden="true " class=""></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="my-5">
                    <p class="border-bottom border-dark mx-3">{{ $comment->comment }}</p>

                </div>

                <div class="bg-info bg-opacity-10 py-2 mx-0 row">
                        <div class="col-md"></div>
                        <div class="col-md"></div>
                        <div class="pt-1 mx-3 col-md ">
                            <a href="" class="mx-2 text-decoration-none px-3 ">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </a>
                        </div> 
                </div>

            </div>

        @endforeach



    </div>

    

    <!-- 返信フォーム -->
    <div class="col-md mt-5">

        <div class="row">

            <div class="position-fixed col-md-5">
                <div class="card ">
                    <div class=" bg-info bg-opacity-10 mx-0 py-3 ">
                        <div class=" ms-5 my-auto">
                            <h4 > {{ \Auth::user()->name }}  </h4>
                        </div>

                    </div>

                    <div class="m-3 ">
                        <form action="{{ route('comment_store') }}" method="post">
                            @csrf
                            <div class="row">
                                <p class="col-md pt-2">  コメントを追加する </p>
                                <input type="hidden" name="reply_id" value="{{ $reply['id'] }}">
                            </div>
                            <textarea name="comment" id="" cols="30" rows="5" class="form-control"></textarea>
                            <input type="submit" name="submit" value="送信" class="form-control w-25 float-end btn-outline-primary text-dark mt-3">
                        </form>
                    </div>
                </div>
            </div> 

            <div class="col-md"></div>

        </div>

    </div>
    

</div>

@endsection
