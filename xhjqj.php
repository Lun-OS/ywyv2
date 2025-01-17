<?php
$nowtime = date('Y-m-d H:i:s');
$end = $_GET['end'] ?? '';
// 初始化 cURL 会话
$ch = curl_init();

// 设置目标 URL
curl_setopt($ch, CURLOPT_URL, 'https://edu.hishizi.com/api/api/teacher/askLeave/teacherApplyAskLeave');

// 设置请求方法为 POST
curl_setopt($ch, CURLOPT_POST, true);

// 设置请求体
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "name" => "肖",
    "time" => "", // 请根据实际情况填写或删除此字段
    "intro" => "", // 请根据实际情况填写或删除此字段
    "leaveEndTime" => $end,
    "leaveStartTime" => $nowtime,
    "studentId" => "66320",
    "gradeId" => "1304",
    "causeType" => "3",
    "causeTypeText" => "其它",
    "intervalId" => 0,
    "dailyStartTimes" => "07:00",
    "dailyEndTimes" => "07:01",
    "cause" => "NULL;502", // 请根据实际情况填写或删除此字段
    "classId" => "1848",
    "version" => 1,
    "timestamp" => 18216008226,
    "sign" => "0b953a5cd209e36ea79e04414093303e"
)));

// 设置 HTTP 头部
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 MicroMessenger/7.0.20.1781(0x6700143B) NetType/WIFI MiniProgramEnv/Windows WindowsWechat/WMPF WindowsWechat(0x63090c11)XWEB/11529',
    'Content-Type: application/json',
    'isOpenMd5: [object Boolean]', // 请根据实际情况填写或删除此字段
    'source: app',
    'studentId: ', // 请根据实际情况填写或删除此字段
    'xweb_xhr: 1',
    'schoolId: 382',
    'userId: 6889',
    'x-ajax: json',
    'x-requested-with: XMLHttpRequest',
    'facultyId: 7966',
    'patriarchId: ', // 请根据实际情况填写或删除此字段
    'Sec-Fetch-Site: cross-site',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Dest: empty',
    'Referer: https://servicewechat.com/wx994917d030b9402a/138/page-frame.html',
    'Accept-Language: zh-CN,zh;q=0.9'
));

// 设置返回结果为字符串
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 执行 cURL 请求
$response = curl_exec($ch);

// 检查是否有错误发生
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // 输出响应结果
    echo $response;
}

// 关闭 cURL 会话
curl_close($ch);
?>