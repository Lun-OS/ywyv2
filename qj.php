<?php
// 假设GET参数已经通过URL传递
$facultyId = $_GET['bzrid'] ?? '';
$leaveEndTime = $_GET['jst'] ?? '';
$leaveStartTime = $_GET['kst'] ?? '';
$studentId = $_GET['xsid'] ?? '';
$gradeId = $_GET['njid'] ?? '';
$classId = $_GET['bjid'] ?? '';

// 构建请求体
$data = array(
    "name" => "测试",
    "time" => "",
    "intro" => "",
    "leaveEndTime" => $leaveEndTime,
    "leaveStartTime" => $leaveStartTime,
    "studentId" => $studentId,
    "gradeId" => $gradeId,
    "causeType" => "3",
    "causeTypeText" => "其它",
    "intervalId" => 0,
    "dailyStartTimes" => "07:00",
    "dailyEndTimes" => "07:01",
    "cause" => "NULL;502",
    "classId" => $classId,
    "version" => 1,
    "timestamp" => 1734501158435,
    "sign" => "0b953a5cd209e36ea79e04414093303e"
);

// 将请求体转换为JSON
$json_data = json_encode($data);

// 初始化cURL会话
$ch = curl_init('https://edu.hishizi.com/api/api/teacher/askLeave/teacherApplyAskLeave');

// 设置cURL选项
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 MicroMessenger/7.0.20.1781(0x6700143B) NetType/WIFI MiniProgramEnv/Windows WindowsWechat/WMPF WindowsWechat(0x63090c11)XWEB/11529',
    'Content-Type: application/json',
    'isOpenMd5: [object Boolean]',
    'source: app',
    'studentId: ' . $studentId,
    'xweb_xhr: 1',
    'schoolId: 382',
    'userId: 6889',
    'x-ajax: json',
    'x-requested-with: XMLHttpRequest',
    'facultyId: ' . $facultyId,
    'patriarchId: ',
    'Sec-Fetch-Site: cross-site',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Dest: empty',
    'Referer: https://servicewechat.com/wx994917d030b9402a/138/page-frame.html',
    'Accept-Language: zh-CN,zh;q=0.9'
));

// 执行cURL请求
$response = curl_exec($ch);

// 关闭cURL会话
curl_close($ch);

// 输出响应
echo $response;
?>