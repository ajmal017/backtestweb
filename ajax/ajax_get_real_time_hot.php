<?php
/**
 * 获取首页实时热度
 */

require_once(dirname(__FILE__) . "/../common/Request.class.php");
require_once(dirname(__FILE__) . "/../common/iwookongConfig.class.php");
require_once(dirname(__FILE__) . "/../common/CheckUserLogin.class.php");
if (CheckLogin::check() == -1) {
    print_r(json_encode(array("status" => -1, "result" => "未知登录状态")));
    return;
}
$hour_data = isset($_POST['hour_data']) ? $_POST['hour_data'] : "";
$minute_data = isset($_POST['minute_data']) ? $_POST['minute_data'] : "";
$arrData = array(
    "user_id" => $_SESSION['user_id'],
    "token" => $_SESSION["token"]
);
if (!empty($hour_data)) {
    $arrData["hour_data"] = $hour_data;
}
if (!empty($minute_data)) {
    $arrData["minute_data"] = $minute_data;
}
//获取实时热度
$real_timehot_result = RequestUtil::get(iwookongConfig::$requireUrl . "stock/1/real_time_hot.fcgi", $arrData);
$json_rtr = json_decode($real_timehot_result, true);
if ($json_rtr['status'] != "0") {
    print_r($real_timehot_result);
    return;
} else {
    if ($jsonresult['flag'] == -1302 || $jsonresult['flag'] == -1301) {
        print_r(json_encode(array("status" => -100, "result" => $jsonresult['msg'])));
        return;
    }
}