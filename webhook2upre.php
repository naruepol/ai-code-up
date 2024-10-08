<?php

class Chatbot {
    private $api_key;
    
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }
    
    public function processRequest() {
        // Read JSON data from Dialogflow
        $request = file_get_contents('php://input');
        $input = json_decode($request, true);
        
        // Get the query text
        $queryText = $input['queryResult']['queryText'];
        
        // Prepare data for OpenAI API
        $data = [
            "model" => "ft:gpt-3.5-turbo-0125:personal::8xe2NuPn",
            "messages" => [
                ["role" => "system", "content" => "You are an intelligent public relation agent expert. Assuming the persona of a woman named Aerith"],  
                ["role" => "user", "content" => $queryText]
            ],
            "temperature" => 0,
            "max_tokens" => 1000
        ];
        
        // Send request to OpenAI API
        $result = $this->sendRequest($data);
        
        // Convert JSON response to PHP array
        $jsonArray = json_decode($result, true);
        
        // Get the content from the response
        $content = $jsonArray['choices'][0]['message']['content'];
        
        // Prepare response data
        $response = [
            "fulfillmentText" => $content
        ];
        
        // Convert array to JSON and send response
        echo json_encode($response);
    }
    
    private function sendRequest($data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->api_key
        ));
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        
        return $result;
    }
}

$api_key = "sk-";

$chatbot = new Chatbot($api_key);
$chatbot->processRequest();

?>
