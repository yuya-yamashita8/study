<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log;

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

    //新規商品登録
    public function store(ProductRequest $request) {
        $data = $request->all();
        $image_path = $request->file('img_path');

        $product_model = new Product();
        $product_model->store($data, $image_path);
        return redirect()->route('index');}


    //商品詳細画面
    public function show($id)
    {
        $product_model = new Product();
        $product = $product_model->detail($id);
        return view('product.show', ['product' => $product]);
    }


    //商品編集画面
    public function edit($id)
    {
        $product_model = new Product();
        $company_model = new Company();
        $product = $product_model->detail($id);
        $companies = $company_model->index();

        return view('product.edit', ['product' => $product, 'companies' => $companies]);
    }


    //商品更新
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $image_path = $request->file('img_path');
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

        return redirect()->route('index')
            ->with('success', 'Product updated successfully');
    }


    //商品を削除
    public function destroy(Request $request, Product $product) {
        $product = Product::findOrFail($request->id);
        $product->delete();
        // // 処理が完了したらdestroyにリダイレクト
        // return redirect(route('index'));
    }
//     public function destroy($id)
//     {
//         // トランザクション開始
//     DB::beginTransaction();

//     try {
//         // 登録処理呼び出し
//         $product_model = new Product();
//         $product_model->deleteProduct($id);
//         DB::commit();
//     } catch (\Exception $e) {
//         DB::rollback();
//         return back();
//     }

//     // 処理が完了したらdestroyにリダイレクト
//     return redirect(route('index'));
// }


public function search(Request $request)
{Log::info('処理開始');
    // キーワードと検索対象のメーカーIDを取得
    $keyword = $request->input('keyword');
    $searchCompany = $request->input('company_id');
    Log::info($searchCompany);
    // Product モデルのインスタンスを作成
    $products = new Product();
    $companies = new Company();

    // インスタンスを介して検索メソッドを呼び出し
    $products = (new Product())->search($keyword, $searchCompany, $request);
    $companies = Company::all();

    // if ($request->ajax()) {
    //     // Ajaxリクエストの場合、商品情報のみを返す
    //     return response()->json(['products' => $products, 'keyword' => $keyword, 'searchCompany' => $searchCompany, 'companies' => $companies]);
    // } else {
    //     // 通常のHTTPリクエストの場合、JSONレスポンスを返す
    //     return view('product.index', ['products' => $products])->render();
    // }
    return view('product.index', ['products' => $products , 'companies' => $companies ,'keyword' => $keyword, 'searchCompany' => $searchCompany])->render();
    // // レスポンスをJSONで返す
    // return response()->json([
    //     'products' => $products,
    //     'keyword' => $keyword,
    //     'searchCompany' => $searchCompany,
    //     'companies' => $companies,
    // ]);

    // ビューに検索結果を渡す
    // return view('product.index', ['products' => $products, 'keyword' => $keyword, 'searchCompany' => $searchCompany, 'companies' => $companies]);
}

}