@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="search mt-5">
        <form action="{{ route('index') }}" method="get" class="row g-3">
            <!-- 検索フォーム -->
            <input type="text" name="query" placeholder="会社名を検索" value="{{ $query ?? '' }}">
            <input type="text" name="keyword" placeholder="キーワードを検索" value="{{ $keyword ?? '' }}">
            <button type="submit" style="width: 100px;">検索</button>
        </form>

        <!-- 検索結果表示 -->
        <!-- @if ($companies->count() > 0)
            <ul>
                @foreach ($companies as $company)
                    <li>{{ $company->company_name }}</li>
                @endforeach
            </ul>
        @else
            <p>該当する結果はありません。</p>
        @endif -->
    </div>
</div>


    <a href="{{ route('create') }}" class="btn btn-primary mb-3">新規登録</a>

    <div class="products mt-5">
        <h2>商品情報</h2>
        <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td><img src="{{ asset('storage/image/'.$product->img_path) }}" alt="商品画像" width="100"></td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company_name }}</td>

                    <td>
                    <a href="{{ route('show', $product->id) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        <form method="POST" action="{{ route('destroy', $product->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>
                    </td>
                </tr>
        </tr>
    @endforeach
    </tbody>
    </table>
    </div>

</div>



