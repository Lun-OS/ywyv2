<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>学生进出校园记录-By:Lun.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>学生进出校园记录-By:Lun.</h1>
        <?php
        // 从GET参数中获取id值
        $uid = $_GET['id'] ?? '';

        // 目标URL
        $url = "https://edu.hishizi.com/api/api/student/access/list";

        // POST请求的参数
        $postFields = json_encode([
            "eventTime" => "",
            "pageNum" => 1,
            "pageSize" => 10,
            "studentId" => $uid,
            "version" => 1,
            "timestamp" => 1734446220455,
            "sign" => "387b501283b2eec6737bd2e8bdc09b74"
        ]);

        // 初始化cURL会话
        $ch = curl_init($url);

        // 设置cURL选项
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'isOpenMd5: [object Boolean]',
            'source: app',
            'xweb_xhr: 1',
            'schoolId: 382',
            'x-ajax: json',
            'x-requested-with: XMLHttpRequest',
            'facultyId: ',
            'patriarchId: 51105',
            'Sec-Fetch-Site: cross-site',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Dest: empty',
            'Referer: https://servicewechat.com/wx994917d030b9402a/138/page-frame.html',
            'Accept-Language: zh-CN,zh;q=0.9'
        ]);

        // 执行cURL会话
        $response = curl_exec($ch);

        // 关闭cURL会话
        curl_close($ch);

        // 解析响应
        $responseArray = json_decode($response, true);

        // 检查响应状态码
        if ($responseArray['code'] == 200) {
            echo "<table>
                    <tr>
                        <th>事件ID</th>
                        <th>学生姓名</th>
                        <th>班级名称</th>
                        <th>年级名称</th>
                        <th>事件时间</th>
                        <th>设备区域名称</th>
                        <th>IC卡号</th>
                        <th>验证方式</th>
                        <th>住宿类型(1:住校|2:通校)</th>
                        <th>设备名称</th>
                        <th>图片URL</th>
                        <th>缩略图URL</th>
                        <th>工作标记</th>
                        <th>学校名称</th>
                        <th>设备区域类型</th>
                        <th>事件类型</th>
                    </tr>";

            foreach ($responseArray['data']['rows'] as $event) {
                $pictureUrl = isset($event['pictureUrl']) ? 'https://edu.hishizi.com/api/' . htmlspecialchars($event['pictureUrl']) : '';
                $thumbnailUrl = isset($event['thumbnailUrl']) ? 'https://edu.hishizi.com/api/' . htmlspecialchars($event['thumbnailUrl']) : '';

                echo "<tr>
                        <td>" . htmlspecialchars($event['eventId']) . "</td>
                        <td>" . htmlspecialchars($event['studentName']) . "</td>
                        <td>" . htmlspecialchars($event['className']) . "</td>
                        <td>" . htmlspecialchars($event['gradeName']) . "</td>
                        <td>" . htmlspecialchars($event['eventTime']) . "</td>
                        <td>" . htmlspecialchars($event['deviceAreaName']) . "</td>
                        <td>" . htmlspecialchars($event['icCardNo']) . "</td>
                        <td>" . htmlspecialchars($event['verificationMethod']) . "</td>
                        <td>" . htmlspecialchars($event['accommodationType']) . "</td>
                        <td>" . htmlspecialchars($event['deviceName']) . "</td>
                        <td><a href='" . $pictureUrl . "' target='_blank'>查看图片</a></td>
                        <td><a href='" . $thumbnailUrl . "' target='_blank'>查看缩略图</a></td>
                        <td>" . htmlspecialchars($event['workMark']) . "</td>
                        <td>" . htmlspecialchars($event['schoolName']) . "</td>
                        <td>" . htmlspecialchars($event['deviceAreaType']) . "</td>
                        <td>" . htmlspecialchars($event['eventType']) . "</td>
                     </tr>";
            }

            echo "</table>";
        } else {
            echo "<div>请求失败，错误码：" . $responseArray['code'] . "<br>错误信息：" . htmlspecialchars($responseArray['msg']) . "</div>";
        }
        ?>
    </div>
</body>
</html>