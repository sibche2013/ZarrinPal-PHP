<?php

require_once("zarinpal_function.php");

$MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
//Get From Database In Toman
$Amount = (100 * 10);

$zp = new zarinpal();
$result = $zp->verify($MerchantID, $Amount);
if ($_GET['Status'] == 'OK') {
    if ($result["data"]["code"] == 100) {
        echo "تراکنش با موفقیت انجام شد";
        echo "<br> مبلغ پرداختی : " . ($Amount / 10) . "تومان ";
        echo "<br>کارت پرداختی : " . $result["data"]["card_pan"];
        echo "<br>شناسه پرداخت : " . $result["data"]["ref_id"];
        //echo "<br>کارمزد درگاه : " . $result["data"]["fee"];
    }
} elseif ($_GET['Status'] == 'NOK') {
    //Remove A & 000000 From Ref_ID
    $authority = str_replace("A", "", $_GET["Authority"]);
    $authority = ltrim($authority, '0');
    echo $zp->error_message($result["errors"]["code"]);
    echo "<br>شناسه پرداخت : " . $authority;
}