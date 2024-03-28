console.log('削除押したら');

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //404エラー　相対パスと絶対パスが違う
    //スラッシュがあるとローカルホストにくっつく
    //404が出たらURL設定を見直したら良い

    //e.preventDefault()-▶︎他のイベントが動くのを止める。
    //function(e)があるからe.preventDefault()使える。

    //405エラー　web.phpが合ってない　ルート設定のエラー　メソッドが合ってないよ

    //500エラー（サーバーエラー）　サーバー側の処理
    //lalavel.logを確認して！！

    //419エラー　X-CSRF-TOKEN　が上手くで来ていない時に出やすい
    //権限エラー

    $('#deleteTarget').on('click', function(e) {
        e.preventDefault();
        var deleteConfirm = confirm('削除してよろしいでしょうか？');

        if (deleteConfirm) {
            var clickEle = $(this);
            // 削除ボタンに埋め込まれたデータ属性を取得
            var userID = clickEle.attr('data-user_id');

            $.ajax({
                url: 'destroy/' + userID, // 正しいURLを生成
                type: 'POST',
                data: {'id': userID, '_method': 'DELETE'}, // DELETE メソッドを指定
            })
            .done(function() {
                // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
                clickEle.parents('tr').remove();
            })
            .fail(function() {
                alert('削除に失敗しました。');
            });
        } else {
            // キャンセルされた場合の処理
        }
    });
});
