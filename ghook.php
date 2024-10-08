<?php
// อ่านข้อมูล JSON ที่ส่งมาจาก Dialogflow
$request = file_get_contents('php://input');
$input = json_decode($request, true);

// ดึงข้อมูลจากคำขอที่ได้รับ
$queryText = $input['queryResult']['queryText'];

// กำหนดคำตอบ
// $responseText = "คุณได้พูดว่า: " . $queryText;

$q = $queryText;
$apiKey = "";  

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}";
$payload = json_encode(['contents' => [['parts' => [['text' => $q]]]]]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
  'Content-Length: ' . strlen($payload)
]);

$result = curl_exec($ch);
curl_close($ch);

// แปลง JSON string เป็น PHP array
$jsonArray = json_decode($result, true);

// ดึงข้อมูล 'content' จาก 'choices'
$content = $jsonArray['candidates'][0]['content']['parts'][0]['text'];

// สร้างข้อมูล JSON สำหรับส่งกลับ
$response = [
    "fulfillmentText" => $content
];

// แปลงค่า array เป็น JSON
echo json_encode($response);
?>
