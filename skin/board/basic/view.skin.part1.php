var win_download_captcha;

function open_download_captcha(href) {
        win_download_captcha = window.open(href, "win_download_captcha", "left=50, top=50, width=617, height=330, scrollbars=1");
}

function close_download_captcha() {
        win_download_captcha.close();
}

$(function() {
        $(".view-content a").each(function () {
                // 타켓이 없으면 새창 타켓 주기
                if ($(this).attr("target") == "") {
                        $(this).attr("target", "_blank");
                }
    }); 
        $("a.view_image").click(function() {
                window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
                return false;
        });

        $("a.view_file_download").click(function() {
                //if(!g5_is_member) {
                //      alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
                //      return false;
                //}

                <?php if ($board['bo_download_point'] < 0) { ?>
                var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";
                var confirmed = confirm(msg);
                <?php } else { ?>
                var confirmed = true;
                <?php } ?>

                if(confirmed) {
                        var href = $(this).attr("href")+"&js=on";
                        $(this).attr("href", href);
                        open_download_captcha(href);
                }

                return false;
        });
});
