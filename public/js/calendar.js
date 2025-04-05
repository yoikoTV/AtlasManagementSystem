$(function () {
  $('.js-modal-open').on('click', function () {

    // モーダルの中身をフェードインして表示する
    $('.js-modal').fadeIn();

    // value属性を取得、thisはjs-modal-open、val()はvalueの値を取得するためのメソッド
    var value = $(this).val();

    // ボタンのテキストを取得thisはjs-modal-open、text()は実際入力されている文字を取得するためのメソッド
    var text = $(this).text();

    $('.modal_date').text(value);
    $('.modal_part').text(text);
    $('.delete_date').val(value);
    $('.delete_part').val(text);

  });

  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {

    // モーダルの中身(js-modal)を非表示
    $('.js-modal').fadeOut();
  });
});
