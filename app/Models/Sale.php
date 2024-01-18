<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $dates =  ['created_at', 'updated_at'];
    protected $fillable = ['id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase($productId, $quantity)
    {
    // データベースから対象の商品を検索・取得
    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['message' => '商品が存在しません'], 404);
    }
    if ($product->stock < $quantity) {
        return response()->json(['message' => '商品が在庫不足です'], 400);
    }

    // 在庫を減少させる
    $product->stock -= $quantity;
    $product->save();

    // Salesテーブルに商品IDと購入日時を記録する
    $sale = new Sale(['product_id' => $productId]);
    $sale->save();

    // 検索結果を取得して返す
    $purchase = DB::table('sales')
        ->join('products', 'sales.product_id', '=', 'products.id')
        ->select('sales.*', 'products.stock')
        ->first();

    return $purchase;
}
}

