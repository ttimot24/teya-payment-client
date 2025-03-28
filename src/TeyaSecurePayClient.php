<?php

namespace Ttimot24\TeyaPayment;

use Ttimot24\TeyaPayment\Model\TeyaItem;
use GuzzleHttp\RequestOptions;
use \Psr\Http\Message\ResponseInterface;

class TeyaSecurePayClient extends TeyaClientBase
{

    private static $_SERVER_PATH_PREFIX = "/SecurePay";

    protected $rules = ['MerchantId', 'PaymentGatewayId', 'SecretKey'];

    protected $defaultConfig = [
        'environment' => 'sandbox',
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]
    ];

    private $items;

    public function getSignature($data): string
    {

        $hash_content = $this->getConfig('MerchantId') . "|" . $this->getConfig('RedirectSuccess') . "|" . $this->getConfig('RedirectSuccessServer') . "|" . $data['orderid'] . "|" . $data['amount'] . "|" . $data['currency'];

        return hash_hmac('sha256', $hash_content, $this->getConfig('SecretKey'));
    }

    public function validateSignature(array $response): bool
    {

        $hash_content = $response['orderid'] . "|" . $response['amount'] . "|" . $response['currency'];

        return $response['orderhash'] === hash_hmac('sha256', $hash_content, $this->getConfig('SecretKey'));
    }

    public function addItem(TeyaItem $item)
    {
        $this->items[] = $item;
    }

    public function addItems($items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function getItems(): TeyaItem
    {
        return $this->items;
    }

    public function clearItems()
    {
        $this->items = [];
    }

    private function configure(array $data)
    {
        $data['orderid'] = $this->generateOrderId();
        $data['amount'] = 0; // PHP <= 8.2 compability
        $data['merchantid'] = $this->getConfig('MerchantId');
        $data['paymentgatewayid'] = $this->getConfig('PaymentGatewayId');
        $data['returnurlsuccess'] = $this->getConfig('RedirectSuccess', $this->getEnvironmentUri().self::$_SERVER_PATH_PREFIX ."/default.aspx");
        $data['returnurlsuccessserver'] = $this->getConfig('RedirectSuccessServer', $this->getEnvironmentUri().self::$_SERVER_PATH_PREFIX."/default.aspx");
        $data['language'] = $this->getConfig('Language', 'EN');
        $data['currency'] = $this->getConfig('Currency', 'ISK');
        $data['ticketexpirydate'] = $this->getConfig('TicketExpiryDate', date("d.m.Y H:i:s", strtotime("+10 minutes")));

        foreach ($this->items as $key => $item) {
            $data['itemdescription_' . $key] = $item->getDescription();
            $data['itemcount_' . $key] = $item->getCount();
            $data['itemunitamount_' . $key] = $item->getPrice();
            $data['itemamount_' . $key] = $item->getTotal();

            $data['amount'] += $item->getTotal();
        }

        $data['checkhash'] = $this->getSignature($data);
        return $data;
    }

    private function deserialize(ResponseInterface $response)
    {
        parse_str($response->getBody()->__toString(), $response);
        $response['ret'] = $response['ret'] === 'True' ? true : false;
        return $response;
    }

    public function start(array $data): array
    {

        $data = $this->configure($data);

        $this->getConfig('logger')?->debug('Ticket request: ', $data);

        $response = $this->http->post(self::$_SERVER_PATH_PREFIX."/ticket.aspx", [RequestOptions::FORM_PARAMS => $data]);

        $response = $this->deserialize($response);
        $response['orderid'] = $data['orderid'];

        if ($response['ret']) {
            $response['paymentUrl'] = $this->getEnvironmentUri().self::$_SERVER_PATH_PREFIX."/ticket.aspx?ticket=" .$response['ticket'];
        }

        $this->getConfig('logger')?->debug('Ticket response: ', $response);

        return $response;
    }

    public function open(array $data)
    {

        $response = $this->start($data);

        if ($response['ret']) {
            return header('Location: ' . $response['paymentUrl']);
        }

        throw new TeyaClientException($response['message']);
    }
}
