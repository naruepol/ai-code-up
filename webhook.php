<?php
// อ่านข้อมูล JSON ที่ส่งมาจาก Dialogflow
$request = file_get_contents('php://input');
$input = json_decode($request, true);

// ดึงข้อมูลจากคำขอที่ได้รับ
$queryText = $input['queryResult']['queryText'];

// กำหนดคำตอบ
$responseText = "คุณได้พูดว่า: " . $queryText;

// สร้างข้อมูล JSON สำหรับส่งกลับ
$response = [
    "fulfillmentText" => $responseText
];

// แปลงค่า array เป็น JSON
echo json_encode($response);
?>
