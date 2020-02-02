<?php
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

// get captcha key
$captcha_key = $_POST['captcha_key'];

// if captcha key is empty
if(empty($captcha_key)) {
    // Page ID
    $pid = ($pid) ? $pid : '';
    $at = apms_page_thema($pid);
    include_once(G5_LIB_PATH.'/apms.thema.lib.php');

    // 스킨 체크
    list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url);

    $g5['title'] = '자동수집방지';

    include_once(G5_PATH.'/head.sub.php');
    if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');

    $no = (int)$no;
    $skin_path = $member_skin_path;
    $skin_url = $member_skin_url;
    $action_url = G5_HTTPS_BBS_URL . "/download.php";
    @include_once($board_skin_path.'/download.captcha.skin.php');

    include_once(G5_PATH.'/tail.sub.php');
    if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');

    exit;
} elseif (!chk_captcha()) {
    alert_close('자동수집방지 숫자가 틀렸습니다.');
} elseif (!$is_member) {
    // get IP address
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    // check download limits    
    $download_limits = (int)$board['bo_9'];
    $tmp_row = sql_fetch("select count(*) as cnt from {$g5['memo_table']} where me_memo = '$ipaddress' and me_recv_mb_id = '@download' and me_send_datetime > (now() - interval 24 hour)");
    $download_currents = $tmp_row['cnt'];
    if($download_currents >= $download_limits) {
        alert_close("비회원 일일(24시간) 내려받기 횟수를 초과하였습니다.");
    }

    // add download history
    $tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
    $me_id = $tmp_row['max_me_id'] + 1;
    $me_memo = $ipaddress;
    $sql = "insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_read_datetime, me_memo ) values ($me_id, '@download', 'admin', '" . G5_TIME_YMDHIS . "', '" . G5_TIME_YMDHIS . "', '$me_memo')";
    sql_query($sql);
}

