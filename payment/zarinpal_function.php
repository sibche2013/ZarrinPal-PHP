<?php

class Zarinpal
{
    public function error_message($code)
    {
        $error = array(
            "-1" => "اطلاعات ارسال شده ناقص است.",
            "-2" => "IP و يا مرچنت كد پذيرنده صحيح نيست",
            "-3" => "با توجه به محدوديت هاي شاپرك امكان پرداخت با رقم درخواست شده ميسر نمي باشد",
            "-4" => "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
            "-9" => "خطای اعتبار سنجی : یکی از مقادیر وارد نشده است.",
            "-10" => "ای پی و يا مرچنت كد پذيرنده صحيح نيست",
            "-11" => "مرچنت کد فعال نیست لطفا با تیم پشتیبانی ما تماس بگیرید",
            "-12" => "تلاش بیش از حد در یک بازه زمانی کوتاه.",
            "-15" => "ترمینال شما به حالت تعلیق در آمده با تیم پشتیبانی تماس بگیرید",
            "-16" => "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
            "-21" => "هيچ نوع عمليات مالي براي اين تراكنش يافت نشد",
            "-22" => "تراكنش نا موفق ميباشد",
            "-30" => "اجازه دسترسی به تسویه اشتراکی شناور ندارید",
            "-31" => "حساب بانکی تسویه را به پنل اضافه کنید مقادیر وارد شده واسه تسهیم درست نیست",
            "-33" => "درصد های وارد شده درست نیست",
            "-34" => "مبلغ از کل تراکنش بیشتر است",
            "-35" => "تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است",
            "-40" => "اجازه دسترسي به متد مربوطه وجود ندارد.",
            "-41" => "اطلاعات ارسال شده مربوط به AdditionalData غيرمعتبر ميباشد.",
            "-42" => "مدت زمان معتبر طول عمر شناسه پرداخت بايد بين 30 دقيه تا 45 روز مي باشد.",
            "-50" => "مبلغ پرداخت شده با مقدار مبلغ در دیتابیس متفاوت است",
            "-51" => "پرداخت ناموفق",
            "-52" => "خطای غیر منتظره با پشتیبانی تماس بگیرید",
            "-53" => "اتوریتی برای این مرچنت کد نیست",
            "-54" => "اتوریتی نامعتبر است",
            "100" => "تراکنش با موفقیت انجام شد.",
            "101" => "تراکنش قبلا وریفای شده",
        );

        if (array_key_exists("{$code}", $error)) {
            return $error["{$code}"];
        } else {
            return "خطای نامشخص هنگام اتصال به درگاه زرین پال";
        }
    }

    public function request($Amount, $MerchantID, $CallbackURL, $Description = "", $Email = "", $Mobile = "", $card_No = "")
    {
        $data = array("merchant_id" => $MerchantID,
            "amount" => $Amount,
            "callback_url" => $CallbackURL,
            "description" => $Description,
            "metadata" => ["email" => $Email,"card_pan" => $card_No,
                "mobile" => $Mobile],
        );
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api Request');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);


        if ($err) {
            echo "خطای کرل #:" . $err;
        } else {
            return $result;
        }
    }

    public function verify($MerchantID, $Amount)
    {
        $Authority = $_GET['Authority'];
        $data = array("merchant_id" => $MerchantID, "authority" => $Authority, "amount" => $Amount);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api Verify');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            echo "خطای کرل #:" . $err;
        } else {
            return json_decode($result, true);
        }
    }
}