<html xmlns="http://www.w3.org/1999/xhtml" lang="hu" xml:lang="hu">

<head>
  <title>Secure Pay Playground</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <div class="container">
    <h2 class="my-5">Teya SecurePay Playground</h2>
    <a href="https://helpcenter.teya.com/hc/hu-hu/articles/29300638132369-Teszt-k%C3%B6rnyezet">Teya Test documentation</a><br>
    <p class="p-3 bg-light my-3"><?php var_dump($_REQUEST); ?></p>
    <?php

    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $merchantId = "9256684";
    $gateway="7";
    $secret = "cdedfbb6ecab4a4994ac880144dd92dc";
    $amount = 2000;
    $currency = "HUF";
    $transactionId = "BHTEST001";
    ?>

    <form id="form1" action="https://test.borgun.is/securepay/default.aspx" method="POST">
      Merchantid : <input type="text" name="merchantid" value="<?= $merchantId ?>" /><br>
      paymentgatewayid : <input type="text" name="paymentgatewayid" value="<?= $gateway ?>" /><br>
      checkhash : <input type="text" size=100 name="checkhash" value="<?= hash_hmac('sha256', utf8_encode($merchantId.'|'.$actual_link.'|'.$actual_link.'|'.$transactionId .'|' . $amount . '|'.$currency .''), $secret) ?>" /><br>
      orderid : <input type="text" name="orderid" value="<?= $transactionId ?>" /><br>
      currency : <input type="text" name="currency" value="<?= $currency ?>" /><br>
      language : <input type="text" name="language" value="HU" /><br>
      ticketexpirydata : <input type="text" name="ticketexpirydata" value="<?= date('d.m.y') ?>" /><br>
      buyername : <input type="text" name="buyername" value="Agnar Agnarsson" /><br>
      buyeremail : <input type="text" name="buyeremail" value="test@borgun.is" /><br>
      returnurlsuccess : <input type="text" size=100 name="returnurlsuccess" value="<?= $actual_link ?>" /><br>
      returnurlsuccessserver : <input type="text" size=100 name="returnurlsuccessserver" value="<?= $actual_link ?>" /><br>
      returnurlcancel : <input type="text" size=100 name="returnurlcancel" value="<?= $actual_link ?>" /><br>
      returnurlerror : <input type="text" size=100 name="returnurlerror" value="<?= $actual_link ?>" /><br>
      itemdescription_0 : <input type="text" name="Itemdescription_0" value="Dekk" /><br>
      itemcount_0 : <input type="text" name="Itemcount_0" value="1" /><br>
      itemunitamount_0 : <input type="text" name="Itemunitamount_0" value="<?= $amount ?>" /><br>
      itemamount_0 : <input type="text" name="Itemamount_0" value="<?= $amount ?>"><br>
      amount : <input type="text" name="amount" value="<?= $amount ?>" /><br>
      pagetype : <input type="text" name="pagetype" value="0" /><br>
      skipreceiptpage : <input type="text" name="skipreceiptpage" value="0" /><br>
      merchantemail : <input type="text" name="merchantemail" value="test@borgun.is" /><br>
      <input class="btn btn-primary my-3" type="submit" name="Send" value="Send" />
    </form>
  </div>
</body>

</html>
