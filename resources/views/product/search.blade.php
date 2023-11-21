<div class="search mt-5">

    <!-- 検索のタイトル -->

    <!-- 検索フォーム。GETメソッドで、商品一覧のルートにデータを送信 -->
    <form action="{{ route('products.index') }}" method="GET" class="row g-3">

        <!-- 商品名検索用の入力欄 -->
        <div class="col-sm-12 col-md-3">
            <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
        </div>
    </form>

</div>