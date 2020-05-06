<?php
include('functions.php');
include('settings.php');
//if(!in_array($chatID, $chats)) exit;
if($msg == '/start') { //messaggio di benvenuto
sendMessage($chatID, "Benvenuto in AmazonReflink!\nIl mio compito è quello di shortare e reffare i link amazon, cosa aspetti? inviamene uno!");
}
if(strpos($msg, 'amazon.it/') !== false) { //avvio lo script solo se la stringa amazon.it/ è presente nel messaggio.
preg_match($link, trim($msg), $match); //cerco link nel messaggio
$pathurl = parse_url($match[0], PHP_URL_PATH);
preg_match($ASIN, $pathurl, $match1); //cerco l'asin del prodotto
if(empty($match1[0])) exit; //se non c'è esco
$text = preg_replace_callback($link, "amazon", $msg); //Faccio il replace di tutti i link amazon
if(!$username) { //invio il messaggio
sendMessage($chatID, "<b>Link Amazon inviato da</b> $mention\n$text");
} else {
sendMessage($chatID, "<b>Link Amazon inviato da</b> @$username\n$text");
  }
deleteMessage($chatID, $messageID);
}

function amazon($matches) { //funzione per referrare e shortare tutti i link amazon
$url = $matches[0];
if(strpos($url, 'amazon.it/') !== false) {
$pathurl = parse_url($url, PHP_URL_PATH);
global $ASIN;
preg_match($ASIN, $pathurl, $match1);
if(empty($match1[0])) exit;
$ref = amazref($match1[0]);
$final = bitly($ref);
if(empty($final->link)) {
global $chatID;
$errore = json_encode($final, JSON_PRETTY_PRINT);
sendMessage($chatID, "Errore bitly: $errore");
exit;
}
return $final->link;
  }
}

if($amzn == true) {
if(strpos($msg, 'amzn.to/') !== false) { //se il link è già corto
preg_match($link, trim($msg), $match);
$longurl = unshort($match[0]); //guardo il vero link
$pathurl = parse_url($longurl, PHP_URL_PATH);
preg_match($ASIN, $pathurl, $match1); //cerco l'asin
if(empty($match1[0])) exit;
$text = preg_replace_callback($link, "amzn", $msg); //Faccio il replace di tutti i link amazon
if(!$username) {
sendMessage($chatID, "<b>Link Amazon inviato da</b> $mention\n$text");
} else {
sendMessage($chatID, "<b>Link Amazon inviato da</b> @$username\n$text");
  }
deleteMessage($chatID, $messageID);
 }
} 
function amzn($matches) {
$url = unshort($matches[0]); //guardo il vero link
if(strpos($url, 'amazon.it/') !== false) {
$pathurl = parse_url($url, PHP_URL_PATH);
global $ASIN;
preg_match($ASIN, $pathurl, $match1);
if(empty($match1[0])) exit;
$ref = amazref($match1[0]);
$final = bitly($ref);
if(empty($final->link)) {
global $chatID;
$errore = json_encode($final, JSON_PRETTY_PRINT);
sendMessage($chatID, "Errore bitly: $errore");
exit;
}
return $final->link;
  }
}
