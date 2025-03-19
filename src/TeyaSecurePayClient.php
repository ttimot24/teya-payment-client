<?php 

namespace Ttimot24\TeyaPayment;

class TeyaSecurePayClient extends TeyaClientBase
{

    protected $rules = ['MerchantId', 'PaymentGatewayId', 'SecretKey', 'RedirectSuccess', 'RedirectSuccessServer'];

    protected $defaultConfig = [
        'environment' => 'sandbox',
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]
    ];

    public function getSignature($data): string {
       
        $hash_content = $this->getConfig('MerchantId')."|".$this->getConfig('RedirectSuccess')."|".$this->getConfig('RedirectSuccessServer')."|".$data['orderid']."|".$data['amount']."|".$data['currency'];

        return hash_hmac('sha256', $hash_content, $this->getConfig('SecretKey'));
    }

    private function configure(array $data){
        $data['merchantid'] = $this->getConfig('MerchantId');
        $data['paymentgatewayid'] = $this->getConfig('PaymentGatewayId');
        $data['checkhash'] = $this->getSignature($data);
        $data['returnurlsuccess'] = $this->getConfig('RedirectSuccess');
        $data['returnurlsuccessserver'] = $this->getConfig('RedirectSuccessServer');
        $data['language'] = $this->getConfig('Language', 'EN');

        return $data;
    }

    public function start(array $data){

       $data = $this->configure($data);

       return $this->http->post("/SecurePay/default.aspx", $data);
    }

}