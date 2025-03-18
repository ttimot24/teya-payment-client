<html xmlns="http://www.w3.org/1999/xhtml" lang="is" xml:lang="is">
  <head>
    <title>Secure Pay Playground</title>
  </head>
  <body>

  <?php 
var_dump($_REQUEST);

?>

    <form id="form1" action="https://test.borgun.is/SecurePay/default.aspx" method="POST">
      Merchantid : <input type="text" name="merchantid" value="9256684" /><br>
      paymentgatewayid : <input type="text" name="paymentgatewayid" value="7" /><br>
      checkhash : <input type="text" size=100 name="checkhash" value="a547079e41646aa54d37953580332e198b6d0d45cfbecb5ffaab2845aa48a172" /><br>
      orderid : <input type="text" name="orderid" value="TEST00000001" /><br>
      currency : <input type="text" name="currency" value="HUF" /><br>
      language : <input type="text" name="language" value="HU" /><br>
      buyername : <input type="text" name="buyername" value="Agnar Agnarsson" /><br>
      buyeremail : <input type="text" name="buyeremail" value="test@borgun.is" /><br>
      returnurlsuccess : <input type="text" size=100 name="returnurlsuccess" value="https://borgun.is/success" /><br>
      returnurlsuccessserver : <input type="text" size=100 name="returnurlsuccessserver" value="https://borgun.is/success_server" /><br>
      returnurlcancel : <input type="text" size=100 name="returnurlcancel" value="http://borgun.is/ReturnPageCancel.aspx" /><br>
      returnurlerror : <input type="text" size=100 name="returnurlerror" value="http://borgun.is/ReturnUrlError.aspx" /><br>
      itemdescription_0 : <input type="text" name="itemdescription_0" value="Dekk" /><br>
      itemcount_0 : <input type="text" name="itemcount_0" value="1" /><br>
      itemunitamount_0 : <input type="text" name="itemunitamount_0" value="800.00" /><br>
      itemamount_0 : <input type="text" name="itemamount_0" value="800.00" /><br>
      amount : <input type="text" name="amount" value="100" /><br>
      pagetype : <input type="text" name=" pagetype " value="0" /><br>
      skipreceiptpage : <input type="text" name="skipreceiptpage " value="0" /><br>
      merchantemail : <input type="text" name="merchantemail" value="test@borgun.is" /><br>
      <input type="submit" name="PostButton" />
    </form>
  </body>
</html>
