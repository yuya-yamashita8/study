
$(document).ready(function() {
    $('#table_table').tablesorter();
});

console.log('読み込み');
$('#search_btn').on('click', function (e) {
    e.preventDefault();
    console.log('検索ボタンが押されたら');
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
    // if (!keyword) {
    //     return false;
    // }

    //assetっていうのはpublicフォルダーを起点に参照にします

    // Ajaxリクエストを発行
    $.ajax({
        type: 'GET',
        url: 'search',
        data: {
            keyword: keyword,
            company_id: company_id,
            min_price: min_price,
            max_price: max_price,
            min_stock: min_stock,
            max_stock: max_stock,
            },
            dataType: 'HTML',
        beforeSend: function () {
            // 通信中の処理をここで記載（例: ローディング表示）
            // $('.loading').removeClass('display-none');
        },
    })
    .done(function (data) {
        // 商品情報を動的に更新

        console.log('確認');
        // updateProductList(data.products.data);
        let table = $(data).find('#table_table');
        $('#table_table').html(table);
        loadSort();
    })
    .fail(function () {
        alert('検索に失敗しました。');
    })
    // .always(function () {
    //     // 通信の成功と失敗に関わらず実行される処理
    //     // 例: ローディング非表示にする処理もここに記載
    //     // $('.loading').addClass('display-none');
    // });
});
