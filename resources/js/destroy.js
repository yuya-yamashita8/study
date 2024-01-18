// ここから非同期処理の記述
$(function() {

    //削除ボタンに"btn-danger"クラスを設定しているため、ボタンが押された場合に開始されます
                $('.btn-danger').on('click', function() {
                var deleteConfirm = confirm('削除してよろしいでしょうか？');
   //　メッセージをOKした時（true)の場合、次に進みます
                    if(deleteConfirm == true) {
                        var clickEle = $(this)
   //$(this)は自身（今回は押されたボタンのinputタグ)を参照します
   //　"clickEle"に対して、inputタグの設定が全て代入されます

                        var userID = clickEle.attr('data-user_id');
    //attr()」は、HTML要素の属性を取得したり設定することができるメソッドです
    //今回はinputタグの"data-user_id"という属性の値を取得します
    //"data-user_id"にはレコードの"id"が設定されているので
    // 削除するレコードを指定するためのidの値をここで取得します

    // .ajaxメソッドでルーティングを通じて、コントローラへ非同期通信を行います。
   //見本ではレコードを削除するコントローラへ通信を送るためにはweb.phpを参照すると
   //通信方法は"post"に設定し、URL（送信先）を'/destroy/{id}'にする必要があります

                $.ajax({
                    type: 'POST',
                    url: '/destroy/'+userID, //userID にはレコードのIDが代入されています
                    dataType: 'json',
                    data: {'id':userID},
                            })
   //”削除しても良いですか”のメッセージで”いいえ”を選択すると次に進み処理がキャンセルされます
            } else {
                    (function(e) {
                        e.preventDefault()
                    });
            };
        });
});