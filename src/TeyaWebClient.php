<?php 

namespace Ttimot24\TeyaPayment;

class TeyaWebClient extends TeyaClientBase
{

    protected $rules = ['MerchantId', 'PaymentGatewayId', 'SecretKey'];

    protected $defaultConfig = [
        'environment' => 'sandbox',
        ['headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            ]
        ]
    ];

    public function getSignature($data): string {
       
        $hash_content = $this->getConfig('MerchantId')."|https://borgun.is/success|https://borgun.is/success_server|".$data['orderid']."|".$data['amount']."|".$data['currency'];

        return hash_hmac('sha256', $hash_content, $this->getConfig('SecretKey'));
    }

    public function start($data){

       $data['merchantid'] = $this->getConfig('MerchantId');
       $data['paymentgatewayid'] = $this->getConfig('PaymentGatewayId');
       $data['checkhash'] = $this->getSignature($data);

       return $this->http->post("SecurePay/default.aspx", $data);
    }

}