@extends('layouts.app')
@section('content')
<div class="container">
    <form action="/user/{{$user->id}}" method="POST" enctype="multipart/form-data" class="col-6 mx-auto">
        @method('PUT')
        @csrf
        <div class="form-group row align-items-center mb-5">
            <img class="rounded-sm" src="/storage/sample.jpg" width="75" alt="">
            <label for="iconImage" class="col-6 offset-2 mb-0" for="iconImage">アイコンを変更する</label>
            <input type="file" class="d-none" name="image" id="iconImage">
        </div>
        <div class="form-group row align-items-center mb-5">
            <label class="col-4" for="userName">お名前</label>
            <input type="text" class="border-0 p-2 col-7" name="name" id="userName" placeholder="{{$user->name}}">
        </div>
        <div class="form-group row align-items-center mb-5">
            <label class="col-4" for="userName">ニックネーム</label>
            @if($user->nickname)
            <input type="text" class="border-0 p-2 col-7" name="nickname" id="userName" placeholder="{{$user->nickname}}">
            @else
            <input type="text" class="border-0 p-2 col-7" name="nickname" id="userName" placeholder="ニックネームを設定しましょう！">
            @endif
        </div>
        <div class="form-group row align-items-center mb-5">
            <label class="col-4" for="email">メールアドレス</label>
            <input type="text" class="border-0 p-2 col-7" name="email" id="email" placeholder="{{$user->email}}">
        </div>
        <input type="submit" class="btn btn-primary offset-10" value="送信">
    </form>
</div>
@endsection