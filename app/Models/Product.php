<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Storage;



class Product extends Model
{
    //use HasFactory;

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
    public function store($data, $image_path) {
        $this->product_name = $data['product_name'];
        $this->price = $data['price'];
        $this->comment = $data['comment'];
        $this->stock = $data['stock'];
        $this->company_id = $data['company_id'];

        if ($image_path) {
            $original = $image_path->getClientOriginalName();
            $name = date('YmdHis') . '' . $original;
            // public ディスクの image ディレクトリに保存
            $image_path->storeAs('public/image', $name);
            // モデルの img_path に正しいパスを保存
            $this->img_path = 'storage/image/' . $name;
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
    public function updateData($id, $data, $image)
{
    DB::table('products')->where('id', '=', $id)->update([
        'product_name' => $data['product_name'], // $data を配列としてアクセス
        'company_id' => $data['company_id'],
        'price' => $data['price'],
        'stock' => $data['stock'],
        'comment' => $data['comment'],
    ]);

    // 既存の商品データを取得
    $product = $this->findOrFail($id);

    // 既存の画像を削除
    if ($product->img_path) {
        Storage::delete($product->img_path);
    }

    // 新しい画像を保存
    if ($image) {
        $path = $image->store('public/images');
        $data['img_path'] = str_replace('public/', 'storage/', $path);
    }

    // 商品データを更新
    $product->update($data);
}

    //素のSQLに近いのがクエリビルダ
    //【'id','=',$id 】のように = でやると一致するもの
    //=>〇〇はbladeのnameを持ってくる。

    //削除処理
    // public function deleteProduct($id)
    // {
    //     return $this->destroy($id);
    // }


    public function  detail($id)
    {
         // productsテーブルからデータを取得
        $products = DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select ('products.*','companies.company_name')
        ->where('products.id','=',$id)
        ->first();
        return $products;
        //一件はfirst、２件以上はget。
    }

    public function search($keyword, $searchCompany, $request)
{
    // products テーブルと companies テーブルを join
    $query = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name');

    if ($keyword) {
        $query->where('products.product_name', 'like', "%{$keyword}%");
    }

    if ($searchCompany) {
        $query->where('products.company_id', '=', $searchCompany);
    }

    // 最小価格が指定されている場合、その価格以上の商品をクエリに追加
    if($min_price = $request->min_price){
        $query->where('products.price', '>=', $min_price);
    }

    // 最大価格が指定されている場合、その価格以下の商品をクエリに追加
    if($max_price = $request->max_price){
        $query->where('products.price', '<=', $max_price);
    }

    // 最小在庫数が指定されている場合、その在庫数以上の商品をクエリに追加
    if($min_stock = $request->min_stock){
        $query->where('products.stock', '>=', $min_stock);
    }

    // 最大在庫数が指定されている場合、その在庫数以下の商品をクエリに追加
    if($max_stock = $request->max_stock){
        $query->where('products.stock', '<=', $max_stock);
    }

    // ソートのパラメータが指定されている場合、そのカラムでソートを行う
    if($sort = $request->sort){
        $direction = $request->direction == 'desc' ? 'desc' : 'asc';
    // もし $request->direction の値が 'desc' であれば、'desc' を返す。
    // そうでなければ'asc' を返す
        $query->orderBy($sort, $direction);
    // orderBy('カラム名', '並び順')
    }

    // 検索結果を取得して返す
    return $query->paginate(5);
}

    }