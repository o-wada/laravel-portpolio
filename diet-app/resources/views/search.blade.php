@extends('layouts.app')

@section('content')

<div class="card">

    <div class="w-75 mx-auto my-5 row">


        <div class="bg-warning bg-opacity-25 col-md">


            <div class="my-3">
                <h3>検索結果</h3>
                @if( (\Route::currentRouteName() === 'search.user') && !empty($user_element))
                    @foreach($user_element as $element)
                    <div class="my-3 ms-5">
                        <h3>{{ $loop->iteration }}.
                        <a href="/user_page/{{ $element->id }}"> <span>{{ $element->name }}</span></a>
                        </h3>
                    </div>
                    @endforeach  
                @elseif( (\Route::currentRouteName() === 'search.user') && empty($user_element))
                    <p>{{ $message }}</p>
                @else
                    <p>項目をチェックしてください。</p>    
                @endif
            </div>

        </div>

                <!-- 検索 -->
        <div class="col-md my-3">
            <form action="{{ route('search.user') }}" method="post">
                @csrf
                <h3>絞り込み</h3>

                <div class="row my-3">
                    <!-- 方針 --> 
                    <div class="form-group col-md-4 mb-3">
                        <label>ダイエット方針 <span class="required text-danger"> <br> ※必須(1件のみ選択可)</span></label>
                        <br><input type="checkbox" name="way" id="糖質制限" value="糖質制限">
                            <label for="糖質制限">糖質制限</label>
                        <br><input type="checkbox" name="way" id="脂質制限" value="脂質制限">
                            <label for="脂質制限">脂質制限</label>
                        <br><input type="checkbox" name="way" id="ボディメイク" value="ボディメイク">
                            <label for="ボディメイク">ボディメイク</label>
                        <br><input type="checkbox" name="way" id="パレオ式" value="パレオ式">
                            <label for="パレオ式">パレオ式</label>
                        <br><input type="checkbox" name="way" id="方針その他" value="その他">
                            <label for="方針その他">その他</label>
                    </div>
                    <!-- 性別 -->
                    <div class="form-group col-md-4">
                        <label>性別 <span class="required text-danger"> <br> ※必須(1件のみ選択可)</span></label>
                        <br><input type="checkbox" name="gender" id="男性" value="男性">
                            <label for="男性">男性</label>
                        <br><input type="checkbox" name="gender" id="女性" value="女性">
                            <label for="女性">女性</label>
                        <br><input type="checkbox" name="gender" id="性別その他" value="その他">
                            <label for="性別その他">その他</label>
                    </div>
                    <!-- 体型 -->
                    <div class="form-group col-md-4">
                        <label>体型 <span class="required text-danger"> <br> ※必須(1件のみ選択可)</span></label>
                        <br><input type="checkbox" name="shape" id="細身" value="細身">
                            <label for="細身">細身</label>
                        <br><input type="checkbox" name="shape" id="普通" value="普通">
                            <label for="普通">普通</label>
                        <br><input type="checkbox" name="shape" id="太め" value="太め">
                            <label for="太め">太め</label>
                        <br><input type="checkbox" name="shape" id="ガッチリ" value="ガッチリ">
                            <label for="ガッチリ">ガッチリ</label>
                        <br><input type="checkbox" name="shape" id="体型その他" value="その他">
                            <label for="体型その他">その他</label>

                    </div>
                    <!-- 年齢 -->
                    <div class="form-group col-md-4 mb-3">
                        <label>年齢(歳) <span class="required text-danger"> <br> ※必須(1件のみ選択可)</span></label>
                        <br><input type="checkbox" name="age" id="15-19" value="15">
                            <label for="15-19">15-19</label>
                        <br><input type="checkbox" name="age" id="20-24" value="20">
                            <label for="20-24">20-24</label>
                        <br><input type="checkbox" name="age" id="25-29" value="25">
                            <label for="25-29">25-29</label>
                        <br><input type="checkbox" name="age" id="30-34" value="30">
                            <label for="30-34">30-34</label>
                        <br><input type="checkbox" name="age" id="35-39" value="35">
                            <label for="35-39">35-39</label>
                        <br><input type="checkbox" name="age" id="40-44" value="40">
                            <label for="40-44">40-44</label>
                        <br><input type="checkbox" name="age" id="45-49" value="45">
                            <label for="45-49">45-49</label>
                        <br><input type="checkbox" name="age" id="50-54" value="50">
                            <label for="50-54">50-54</label>
                        <br><input type="checkbox" name="age" id="55-59" value="55">
                            <label for="55-59">55-59</label>

                    </div>

                    <!-- 体重 -->
                    <div class="form-group col-md-4 mb-3">
                        <label>体重(kg) <span class="required text-danger"> <br> ※必須(1件のみ選択可)</span></label>
                        <br><input type="checkbox" name="weight" id="40-49" value="40">
                            <label for="40-49">40-49</label>
                        <br><input type="checkbox" name="weight" id="50-59" value="50">
                            <label for="50-59">50-59</label>
                        <br><input type="checkbox" name="weight" id="60-69" value="60">
                            <label for="60-69">60-69</label>
                        <br><input type="checkbox" name="weight" id="70-79" value="70">
                            <label for="70-79">70-79</label>
                        <br><input type="checkbox" name="weight" id="80-89" value="80">
                            <label for="80-89">80-89</label>
                        <br><input type="checkbox" name="weight" id="90-99" value="90">
                            <label for="90-99">90-99</label>
                        <br><input type="checkbox" name="weight" id="100" value="100">
                            <label for="100">100-109</label>
                        <br><input type="checkbox" name="weight" id="110" value="110">
                            <label for="110">110-119</label>
                        <br><input type="checkbox" name="weight" id="120" value="120">
                            <label for="120">120-129</label>

                    </div>
                    <!-- 身長 -->
                    <div class="form-group col-md-4 mb-3">
                        <label>身長(cm) <span class="required text-danger"> <br> ※必須(1件のみ選択可)</span></label>
                        <br><input type="checkbox" name="tall" id="120-129" value="120">
                            <label for="120-129">120-129</label>
                        <br><input type="checkbox" name="tall" id="130-139" value="130">
                            <label for="130-139">130-139</label>
                        <br><input type="checkbox" name="tall" id="140-149" value="140">
                            <label for="140-149">140-149</label>
                        <br><input type="checkbox" name="tall" id="150-159" value="150">
                            <label for="150-159">150-159</label>
                        <br><input type="checkbox" name="tall" id="160-169" value="160">
                            <label for="160-169">160-169</label>
                        <br><input type="checkbox" name="tall" id="170-179" value="170">
                            <label for="170-179">170-179</label>
                        <br><input type="checkbox" name="tall" id="180-189" value="180">
                            <label for="180-189">180-189</label>
                        <br><input type="checkbox" name="tall" id="190-199" value="190">
                            <label for="190-199">190-199</label>
                        <br><input type="checkbox" name="tall" id="200-209" value="200">
                            <label for="200-209">200-209</label>

                    </div>


                    <br><br>
                                        
                    <br><br>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>

                    <div class="col-md">
                        <br><input type="submit" value="検索" name="submit" class="form-control">
                    </div>

                </div>

            </form>
        </div>


    </div>

</div>

@endsection
