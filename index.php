<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>درگاه پرداخت</title>
</head>
<body>
<form action="./payment/request.php" method="post">
    <label for="amount">مقدار</label>
    <input type="number" name="amount" id="amount">
    <label for="description">توضیحات</label>
    <input type="text" name="description" id="description">
    <label for="email">ایمیل</label>
    <input type="email" name="email" id="email">
    <label for="mobile">موبایل</label>
    <input type="number" name="mobile" id="mobile">
    <input type="submit" value="پرداخت" class="button submit">
</form>
</body>
</html>