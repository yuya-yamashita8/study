<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;

class ProductController extends Controller
{
    //商品一覧画面
    public function index()
    {
        //インスタンスを生成
        //$products,$companiesにindexでreturnしたものが代入される。
        $product_model = new Product();
        $companies_model = new Company();
        $products = $product_model->index();
        $companies = $companies_model->index();

        return view('product.index', ['products' => $products, 'companies' => $companies]);
    }


    //新規商品登録画面の表示
    public function create()
    {
        //インスタンスを生成
        //$companiesにindexでreturnしたものが代入される。
        $companies_model = new Company();
        $companies = $companies_model->index();

        return view('product.create', ['companies' => $companies]);
    }


    //新規商品登録画面の保存
    public function store(Request $request)
    {
        {
            $data = $request -> all();
            $product = new Product();
            $product->store($data);

            DB::beginTransaction();

        try {
            // 登録処理呼び出し
            $$product_model = new Product();
            $$product_model->store($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        return redirect(route('products.create'));
    }
    }


    //商品詳細画面
    public function show($id)
    {
        $product_model = new Product();
        $product = $product_model->detail($id);//<-なぜshow($id)じゃないの？
        return view('products.show', ['product' => $product]);
    }


    //商品編集画面
    public function edit($id)
    {
        $product_model = new Product();
        $company_model = new Company();
        $product = $product_model->detail($id);//<-なぜedit($id)じゃないの？
        $companies = $company_model->index();

        return view('products.edit', ['product' => $product, 'companies' => $companies]);
    }


    //商品更新
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $image_path = $request->file('image_path');
        DB:: beginTransaction();

        try {
            // 登録処理呼び出し
            $product_model = new Product();
            $product_model->updateData($id, $data, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }


    //商品を削除
    public function destroy($id)
    {
        // トランザクション開始
    DB::beginTransaction();

    try {
        // 登録処理呼び出し
        $product_model = new Product();
        $product_model->deleteProduct($id);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return back();
    }

    // 処理が完了したらdestroyにリダイレクト
    return redirect(route('products'));
}
}
