@extends('layouts.app')

@section('content')

<div class="container-fluid row">

<p>画像を保存する</p>
<form action="{{ route('tom') }}" method="post" enctype="multipart/form-data">
    @csrf
<input type="file" name="image" >
<input type="submit" value="送信">
</form>

<p>画像を表示する</p>
@foreach($abc as $a)
<img src="/pictures/{{ $a->image }}" class="w-25" alt="">
@endforeach
</div>






@endsection
