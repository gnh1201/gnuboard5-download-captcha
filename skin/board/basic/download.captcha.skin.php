<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<form class="form-horizontal" role="form" name="fdownloadcaptcha" action="<?php echo $action_url ?>" onsubmit="return fdownloadcaptcha_submit(this);" method="post" autocomplete="off">
        <div class="hidden">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
            <input type="hidden" name="no" value="<?php echo $no; ?>">
            <input type="hidden" name="state" value="1">
        </div>

        <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fa fa-user fa-lg"></i> 자동수집방지</strong></div>
                <div class="panel-body">
                        <p class="help-block">
                                자동수집방지 코드를 정확하게 입력하여 주세요.
                        </p>
                        <div class="form-group">
                                <div class="col-xs-10">
                                        <?php echo captcha_html(); ?>
                                </div>
                        </div>
                </div>
        </div>

        <div class="text-center" style="margin:15px 0px 0px;">
            <button type="submit" class="btn btn-color btn-sm">확인</button>
            <button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
        </div>
</form>

<script>
function fdownloadcaptcha_submit(f) {
    <?php echo chk_captcha_js();  ?>

    setTimeout(function() {
        if(confirm("다운로드가 정상적으로 되었습니까?")) {
            window.opener.close_download_captcha();
        } else {
            alert("다시 시도하여주세요");
            window.close();
        }
    }, 3000);

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});

</script>
