<?php
function getFile($url, $save_dir = '', $filename = '', $type = 0) {
	if (trim($url) == '') {
		return false;
	}
	if (trim($save_dir) == '') {
		$save_dir = './';
	}
	if (0 !== strrpos($save_dir, '/')) {
		$save_dir .= '/';
	}
	//创建保存目录
	if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
		return false;
	}
	//获取远程文件所采用的方法
	if ($type) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$content = curl_exec($ch);
		curl_close($ch);
	} else {
		ob_start();
		readfile($url);
		$content = ob_get_contents();
		ob_end_clean();
	}
	//echo $content;
	$size = strlen($content);
	//文件大小
	$fp2 = @fopen($save_dir . $filename, 'a');
	fwrite($fp2, $content);
	fclose($fp2);
	unset($content, $url);
	return array('file_name' => $filename, 'save_path' => $save_dir . $filename, 'file_size' => $size);
}

//$url = "http://www.baidu.com/img/baidu_jgylogo3.gif";
//$url="http://192.168.1.212/aaa.doc";
//$url = "http://192.168.1.111/mp4_player/" . urlencode(iconv("GB2312", "UTF-8", "video.mp4"));
$url="http://120.76.192.13:10007/app/resources/video/app.mp4";
$save_dir = "down/";
//$filename = "baidu_jgylog1o31.gif";
$filename = "1.mp4";
$res = getFile($url, $save_dir, $filename, 1);
//0  1 都是好使的
var_dump($res);
?>