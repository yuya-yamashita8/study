<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    //use HasFactory;

     // Saleモデルがproductテーブルとリレーション関係を結ぶためのメソッド
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
