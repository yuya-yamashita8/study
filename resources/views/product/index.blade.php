@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="search mt-5">
    <form action="{{ route('search') }}" method="get" class="row g-3" id="search_form">
    <!-- 検索フォーム -->
    <input type="text" name="keyword" placeholder="キーワードを検索" value="{{ $keyword ?? '' }}">
    <select class="form-select" id="company_id" name="company_id" placeholder="会社名を検索">
        <option value="">メーカー名</option>
        @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
        @endforeach
    </select>
    <div id='form_price'>
    <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
    <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
    <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
    <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
    </div>
    <button id='search_btn' type="submit" style="width: 100px;">検索</button>
</form>

        <a href="{{ route('create') }}" class="btn btn-primary mb-3">新規登録</a>
    </div>
</div>


    <div class="products mt-5" id="products-container">
        <h2>商品情報</h2>
        <div class ="table class" id='table_table'>
        <table class="table table-striped tablesorter">
    <thead>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}">↑</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}">↓</a>
            </th>
            <th>在庫数
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'asc']) }}">↑</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'desc']) }}">↓</a>
            </th>
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
                        <!-- <form method="POST" action="{{ route('destroy', $product->id) }}" class="d-inline" id="delete_btn" onsubmit="event.preventDefault(); confirmDelete(this);">
                            @csrf
                            @method('DELETE')
                            <button id='deleteTarget' type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form> -->
                        <form  class="id">
                        <input id="deleteTarget" data-user_id="{{$product->id}}" type="submit" class="btn btn-danger btn-sm mx-1" value="削除">
                        </form>
                    </td>
                </tr>
        </tr>
    @endforeach
    </tbody>
    </table>
    {{ $products->appends(request()->query())->links() }}
    </div>
    </div>
</div>
@endsection

