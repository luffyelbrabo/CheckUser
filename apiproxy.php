<?php
if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on'))) || (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] == 443)) {
   $URL_ATUAL= "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //Atribui o valor https
} else {
   $URL_ATUAL= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //Atribui o valor http
}
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_GET["url"]) && !empty($_GET["url"])) {
$url = isset($_GET['url']) ? $_GET['url'] : '';
$urlParts = parse_url($url);
$clientIp = isset($urlParts['host']) ? $urlParts['host'] : '';
$ipsliberado = file_get_contents("ips.txt");
if (strpos($ipsliberado, $clientIp) !== false) {
$headers = getallheaders();
$headers_str = [];
foreach ( $headers as $key => $value){
if($key == 'Host')
continue;
$headers_str[]=$key.":".$value;
}
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_URL, $url);
if( $method !== 'GET') {
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
}
if($method == "PUT" || $method == "PATCH" || ($method == "POST" && empty($_FILES))) {
$data_str = file_get_contents('php://input');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
} elseif($method == "POST") {
$data_str = array();
if(!empty($_FILES)) {
foreach ($_FILES as $key => $value) {
$full_path = realpath( $_FILES[$key]['tmp_name']);
$data_str[$key] = '@'.$full_path;
}
}
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str+$_POST);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers_str );
$result = curl_exec($ch);
curl_close($ch);
echo $result;
} else {
echo ('<script>alert("IP não Autorizado!");</script>');
echo ('<script>window.location.href = "https://t.me/luffyelbrabo";</script>');
exit;
}
} else {
echo ('<script>alert("Método não Autorizado!\nFavor usar dessa forma do exemplo\n' . $URL_ATUAL . '?url=http://ipvps:5000");</script>');
echo ('<script>window.location.href = "https://t.me/luffyelbrabo";</script>');
exit;
}
?>