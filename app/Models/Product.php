<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\Request;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    // Productモデルがsalesテーブルとリレーション関係を結ぶためのメソッド
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Productモデルがcompaniesテーブルとリレーション関係を結ぶ為のメソッドです
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function index()
    {
        // productsテーブルからデータを取得
        $products = DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select ('products.*','companies.company_name')
        ->paginate (5);
        return $products;
    }

    public function create() {
        $companies = DB::table('companies')->create();
        return view('product.create', ['companies' => $companies]);
    }

    //新規商品登録画面の保存
    public function store($data,$image_path)
    {
        $this->product_name = $data['product_name'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->company_id = $data['company_id'];
        $this->comment =$data['comment'];

        if($image_path){
        $filename = $data->img_path->getClientOriginalName();
        $filePath = $data->img_path->storeAs('products', $filename, 'public');
        $data->img_path = '/storage/' . $filePath;
        }
        $this->save();
    }


    public function show($id)
    {
        $product = DB::table('products')->create();
        return view('product.show', ['product' => $product]);
    }


    public function edit($id)
    {
        // productsテーブルからデータを取得
        $products = DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select ('products.*','companies.company_name')
        ->paginate (5);
        return $products;
    }

    //データを渡すときはその順番を意識！
    public function updateData($id, $data, $image_path)
    {//インサートは新規登録の処理　whereはどのレコードをupdate（更新）してやるか！　
    DB::table('products')->where('id','=',$id)->update([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $image_path,
        ]);
    }
//素のSQLに近いのがクエリビルダ
//【'id','=',$id 】のように = でやると一致するもの
//=>〇〇はbladeのnameを持ってくる。

    //削除処理
    public function deleteProduct($id)
    {
        return $this->destroy($id);
    }
}