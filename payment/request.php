<?php
require_once("zarinpal_function.php");

$MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
//In Toman
$Amount = ($_POST["amount"] * 10);
$Description = $_POST["description"];
$Email = $_POST["email"];
$Mobile = $_POST["mobile"];
$Card_No = $_POST["card_No"];
$CallbackURL = "https://example.com/payment/verify.php";

$zp = new Zarinpal();
$result = $zp->request($Amount, $MerchantID, $CallbackURL, $Description, $Email, $Mobile);

if (!empty($result['data'])) {
    if ($result['data']['code'] == 100) {
        header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
    }
} else {
    echo $zp->error_message($result["errors"]["code"]);
}