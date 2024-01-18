<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request) {
        // リクエストから必要なデータを取得する
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Product モデルのインスタンスを作成
        $product = new Product();

        // インスタンスを介して検索メソッドを呼び出し
        $productResult = $product->purchase($productId, $quantity);

        // Sale モデルのインスタンスを作成
        $sale = new Sale();

        // Sale モデルの全てのデータを取得
        $salesResult = $sale->all();

        return response()->json([
            'message' => '購入成功',
            'product' => $productResult,
            'sales' => $salesResult,
        ]);
    }

}

