<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        //Productモデルのファクトリーを使ってダミーレコードを10件作成
        //Product::factory()->count(10)->create();
    }
}
