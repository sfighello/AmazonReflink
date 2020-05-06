<?php
//VARIABILI
$update = json_decode(file_get_contents("php://input"), true);
if(isset($update['edited_message'])) $update['message'] = $update['edited_message'];
if(isset($update['message']['text'])) $msg = $update['message']['text'];
if(isset($update['message']['caption'])) $msg = $update['message']['caption'];
$messageID = $update['message']['message_id'];
$chatID = $update['message']['chat']['id'];
$firstname = htmlspecialchars($update['message']['from']['first_name']);
$lastname = $update['message']['from']['last_name'];
$username = $update['message']['from']['username'];
$userID = $update['message']['from']['id'];
$mention = '<a href="tg://user?id='.$userID.'">'.$firstname.' '.$lastname.'</a>';
$link = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#'; //regex per trovare link
$ASIN = '/(?:[\dp\]|$)([A-Z0-9]{10})/'; //regex per trovare l'asin di un prodotto amazon
//FUNCTIONS
function unshort($url) { //funzione per trovare il vero link
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
$html = curl_exec($ch); 
$redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); 
curl_close($ch); 
return $redirectedUrl;
}
function sendMessage($chatID, $msg) {
$args = ['chat_id' => $chatID, 'parse_mode' => 'HTML', 'text' => $msg, 'disable_web_page_preview' => true];
return cURL ('/sendMessage',$args);
}
function deleteMessage($chatID, $messageID) {
    $args = ['chat_id' => $chatID, 'message_id' => $messageID];
    return cURL ('/deleteMessage',$args);
}
function amazref($asin) { //costruzione del link amazon da shortare
global $ref;
$reflink = 'https://amazon.it/dp/'.$asin.'?tag='.$ref;
return $reflink;
}
function bitly($long_url) { //url shortener
global $bitlytoken;
$apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
$genericAccessToken = $bitlytoken;

$data = array(
    'long_url' => $long_url
);
$payload = json_encode($data);

$header = array(
    'Authorization: Bearer ' . $genericAccessToken,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
);

$ch = curl_init($apiv4);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
$resultToJson = json_decode($result);
return $resultToJson;
}
function cURL($method,$args) {
        global $api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$api.$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, TRUE);
    }
