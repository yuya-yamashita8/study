@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報詳細</h1>

    <a href="{{ route('index') }}" class="btn btn-primary mt-3">戻る</a>

    <dl class="row mt-3" >
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9">{{ $product->id }}</dd>

        <dt class="col-sm-3">商品名</dt>
        <dd class="col-sm-9">{{ $product->product_name }}</dd>

        <dt class="col-sm-3">メーカー</dt>
        <dd class="col-sm-9">{{ $product->company_name }}</dd>

        <dt class="col-sm-3">価格</dt>
        <dd class="col-sm-9">{{ $product->price }}</dd>

        <dt class="col-sm-3">在庫数</dt>
        <dd class="col-sm-9">{{ $product->stock }}</dd>

        <dt class="col-sm-3">コメント</dt>
        <dd class="col-sm-9">{{ $product->comment }}</dd>

        <dt class="col-sm-3">商品画像</dt>
        <dd class="col-sm-9"><img src="{{ $product->img_path }}" width="300"></dd>
    </dl>
    <a href="{{ route('edit', $product->id) }}" class="btn btn-primary btn-sm mx-1">編集</a>

</div>
@endsection