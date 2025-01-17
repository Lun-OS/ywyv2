<?php

// 检查是否有 'class' 参数在 URL 中
if (isset($_GET['class'])) {
    $class = $_GET['class'];
    $periodId = $class + 1358; // 计算 periodId 的值
} else {
    // 如果没有 'class' 参数，可以设置一个默认值或者处理错误
    $periodId = 0; // 或者抛出一个错误
}

// 初始化 cURL 会话
$curl = curl_init();

// 设置 cURL 选项
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://edu.hishizi.com/api/api/student/class/getClassTeacherList', // 目标 URL
    CURLOPT_POST => true, // 发送 POST 请求
    CURLOPT_POSTFIELDS => json_encode(array(
        "periodId" => $periodId, // 使用计算后的 periodId 值
        "facultyId" => 7974,
        "teacherName" => "",
        "version" => 1,
        "timestamp" => 1734503786439,
        "sign" => "62af38aba42f9fef9f449828de1d143b"
    )), // POST 数据
    CURLOPT_HTTPHEADER => array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 MicroMessenger/7.0.20.1781(0x6700143B) NetType/WIFI MiniProgramEnv/Windows WindowsWechat/WMPF WindowsWechat(0x63090c11)XWEB/11529',
        'Content-Type: application/json',
        'isOpenMd5: [object Boolean]',
        'source: app',
        'studentId: ',
        'xweb_xhr: 1',
        'schoolId: 382',
        'userId: 6889',
        'x-ajax: json',
        'x-requested-with: XMLHttpRequest',
        'facultyId: 7974',
        'patriarchId: ',
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
    // 解析返回的 JSON 数据
    $data = json_decode($response, true);

    // 检查数据是否包含我们需要的字段
    if (isset($data['data']) && is_array($data['data'])) {
        // 遍历数据，查找 type 为 1 的 periodId
        $type1PeriodIds = array();
        foreach ($data['data'] as $item) {
            if (isset($item['type']) && $item['type'] == 1) {
                $type1PeriodIds[] = $item['facultyId'];
            }
        }

        // 打印 type 为 1 的 periodId 数据
        echo implode(', ', $type1PeriodIds);
    } else {
        echo "404";
    }
}

// 关闭 cURL 会话
curl_close($curl);

?>