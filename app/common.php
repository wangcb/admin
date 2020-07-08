<?php
// 应用公共文件

define('OK', '操作成功');
define('FAIL', '操作失败或未做任何修改');
/**
 * 订单号生成
 * @return string
 */
function order_no(){
    return date('Ymd').rand(1000,9999).date('His').rand(1000,9999);
}
/**
 * 生成唯一订单号
 */
function build_order_no(){
	return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

function password($password){
    return '#'.md5(md5('ruanwen'.$password));
}
/**
 * 打印函数
 */
function p($var){
	echo '<pre>';
	print_r($var);
	die;
}
//验证是否是整数类型
function is_digit($digit) {
	if(preg_match("/^(0|[1-9][0-9]*|-[1-9][0-9]*)$/", $digit)) {
		return true;
	} else {
		return false;
	}
}

/**
 * 获取图片的Base64编码
 */
function img2Base64($file){
	$img_info = getimagesize($file); // 取得图片的大小，类型等
	$file_content = base64_encode(file_get_contents($file));
	switch ($img_info[2]) {           //判读图片类型
		case 1: $img_type = "gif";
			break;
		case 2: $img_type = "jpg";
			break;
		case 3: $img_type = "png";
			break;
	}
	$img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content;//合成图片的base64编码
	return $img_base64;
}
