<?php 

namespace Ttimot24\TeyaPayment;

use Ttimot24\TeyaPayment\Model\TeyaItem;

class TeyaSecurePayClient extends TeyaClientBase
{

    protected $rules = ['MerchantId', 'PaymentGatewayId', 'SecretKey', 'RedirectSuccess', 'RedirectSuccessServer'];

    protected $defaultConfig = [
        'environment' => 'sandbox',
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]
    ];

    private $data;

    private $items; 

    public function getSignature($data): string {
       
        $hash_content = $this->getConfig('MerchantId')."|".$this->getConfig('RedirectSuccess')."|".$this->getConfig('RedirectSuccessServer')."|".$data['orderid']."|".$data['amount']."|".$data['currency'];

        return hash_hmac('sha256', $hash_content, $this->getConfig('SecretKey'));
    }

    public function validateSignature(array $response): bool { 
        
        $hash_content = $response['orderid']."|".$response['amount']."|".$response['currency'];

        return $response['orderhash'] === hash_hmac('sha256', $hash_content, $this->getConfig('SecretKey'));
    }

    public function addItem(TeyaItem $item){
        $this->items[] = $item;
    }

    public function addItems($items){
        foreach($items as $item){
            $this->addItem($item);
        }
    }

    public function getItems(): TeyaItem {
        return $this->items;
    }

    public function clearItems(){
        $this->items = [];
    }

    private function configure(array $data){
        $data['merchantid'] = $this->getConfig('MerchantId');
        $data['paymentgatewayid'] = $this->getConfig('PaymentGatewayId');
        $data['checkhash'] = $this->getSignature($data);
        $data['returnurlsuccess'] = $this->getConfig('RedirectSuccess');
        $data['returnurlsuccessserver'] = $this->getConfig('RedirectSuccessServer');
        $data['language'] = $this->getConfig('Language', 'EN');
        $data['currency'] = $this->getConfig('Currency', 'ISK');

        foreach($this->items as $key => $item){
            $data['itemdescription_'.$key] = $item->getDescription();
            $data['itemcount_'.$key] = $item->getCount();
            $data['itemunitamount_'.$key] = $item->getPrice();
            $data['itemamount_'.$key] = $item->getTotal();

            $data['amount'] += $item->getTotal();
        }

        return $data;
    }

    public function start(array $data): string {

       $data = $this->configure($data);

       return $this->getEnvironmentUri()."/SecurePay/default.aspx?".urlencode(http_build_query($data));
    }

}