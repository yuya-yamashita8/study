@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="search mt-5">
    <form action="{{ route('search') }}" method="get" class="row g-3">
    <!-- 検索フォーム -->
    <input type="text" name="keyword" placeholder="キーワードを検索" value="{{ $keyword ?? '' }}">
    <select class="form-select" id="company_id" name="company_id" placeholder="会社名を検索">
        <option value="">メーカー名</option>
        @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
        @endforeach
    </select>
    <button type="submit" style="width: 100px;">検索</button>
</form>

        <a href="{{ route('create') }}" class="btn btn-primary mb-3">新規登録</a>
    </div>
</div>


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
            <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
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
    {{ $products->appends(request()->query())->links() }}
</div>



