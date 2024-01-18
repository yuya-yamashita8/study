$('.search-icon').on('click', function () {
    // 現在の商品リストをクリア
    $('#products-container tbody').empty();

    // ユーザーが入力したキーワードを取得
    var keyword = $("#search_form input[name='keyword']").val();
        var company_id = $("#search_form select[name='company_id']").val();
        var min_price = $("#search_form input[name='min_price']").val();
        var max_price = $("#search_form input[name='max_price']").val();
        var min_stock = $("#search_form input[name='min_stock']").val();
        var max_stock = $("#search_form input[name='max_stock']").val();

    // ガード節: キーワードが空の場合は処理を中断
    if (!keyword) {
        return false;
    }

    // Ajaxリクエストを発行
    $.ajax({
        type: 'POST',
        url: searchRoute,
        data: {
            keyword: keyword,
            company_id: company_id,
            min_price: min_price,
            max_price: max_price,
            min_stock: min_stock,
            max_stock: max_stock,
            },
            dataType: 'json',
        beforeSend: function () {
            // 通信中の処理をここで記載（例: ローディング表示）
            // $('.loading').removeClass('display-none');
        },
    })
    .done(function (data) {
        // 商品情報を動的に更新
        updateProductList(data.products.data);
    })
    .fail(function () {
        alert('検索に失敗しました。');
    })
    .always(function () {
        // 通信の成功と失敗に関わらず実行される処理
        // 例: ローディング非表示にする処理もここに記載
        // $('.loading').addClass('display-none');
    });
});

// 商品情報を動的に更新する関数
function updateProductList(products) {
    var productsHtml = "";

    // 商品情報の HTML を生成
    products.forEach(function (product) {
        productsHtml += "<tr>";
        productsHtml += "<td>" + product.id + "</td>";
        // 他のプロパティも同様に追加
        productsHtml += "</tr>";
    });

    // 生成した HTML を #products-container に追加
    $("#products-container tbody").html(productsHtml);
}


// // your_script.js
// $(document).ready(function () {
//     $("#search_form").submit(function (event) {
//         event.preventDefault();

//         var keyword = $("#search_form input[name='keyword']").val();
//         var company_id = $("#search_form select[name='company_id']").val();
//         var min_price = $("#search_form input[name='min_price']").val();
//         var max_price = $("#search_form input[name='max_price']").val();
//         var min_stock = $("#search_form input[name='min_stock']").val();
//         var max_stock = $("#search_form input[name='max_stock']").val();

//         $.ajax({
//             type: "GET",
//             url: searchRoute,
//             data: {
//                 keyword: keyword,
//                 company_id: company_id,
//                 min_price: min_price,
//                 max_price: max_price,
//                 min_stock: min_stock,
//                 max_stock: max_stock,
//             },
//             dataType: 'json',
//         })
//         .done(function (data) {
//             // 商品情報を動的に更新
//             updateProductList(data.products.data);
//         })
//         .fail(function () {
//             alert('検索に失敗しました。');
//         })
//         .always(function () {
//             // 通信の成功と失敗に関わらず実行される処理
//         });
//     });

//     // 商品情報を動的に更新する関数
//     function updateProductList(products) {
//         var productsHtml = "";

//         // 商品情報の HTML を生成
//         products.forEach(function (product) {
//             productsHtml += "<tr>";
//             productsHtml += "<td>" + product.id + "</td>";
//             // 他のプロパティも同様に追加
//             productsHtml += "</tr>";
//         });

//         // 生成した HTML を #products-container に追加
//         $("#products-container tbody").html(productsHtml);
//     }
// });
