<?php
// อ่านข้อมูล JSON ที่ส่งมาจาก Dialogflow
$request = file_get_contents('php://input');
$input = json_decode($request, true);

// ดึงข้อมูลจากคำขอที่ได้รับ
$queryText = $input['queryResult']['queryText'];

$api_key = "sk-";

$data = array(
    "model" => "gpt-3.5-turbo",
    "messages" => array(
        array("role" => "user", "content" => $queryText)
    ),
    "temperature" => 0,
    "max_tokens" => 1000
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
));

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

//echo $result;
// แปลง JSON string เป็น PHP array
$jsonArray = json_decode($result, true);

// ดึงข้อมูล 'content' จาก 'choices'
$content = $jsonArray['choices'][0]['message']['content'];

// สร้างข้อมูล JSON สำหรับส่งกลับ
$response = [
    "fulfillmentText" => $content
];

// แปลงค่า array เป็น JSON
echo json_encode($response);
?>
