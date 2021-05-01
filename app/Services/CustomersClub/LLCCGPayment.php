<?php


namespace App\Services\CustomersClub;

use GuzzleHttp\Client;
use Guzzper\Guzzper;
use Ramsey\Uuid\Uuid;
use Shetabit\Multipay\Contracts\DriverInterface;
use Shetabit\Multipay\Contracts\ReceiptInterface;
use Shetabit\Multipay\Exceptions\DriverNotFoundException;
use Shetabit\Multipay\Exceptions\InvoiceNotFoundException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Traits\HasPaymentEvents;
use Shetabit\Multipay\Traits\InteractsWithRedirectionForm;
use Spatie\ArrayToXml\ArrayToXml;

class LLCCGPayment
{
    use InteractsWithRedirectionForm;
    use HasPaymentEvents;

    /**
     * Payment Configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Payment Driver Settings.
     *
     * @var array
     */
    protected $settings;

    /**
     * callbackUrl
     *
     * @var string
     */
    protected $callbackUrl;

    /**
     * Payment Driver Name.
     *
     * @var string
     */
    protected $driver;

    /**
     * Payment Driver Instance.
     *
     * @var object
     */
    protected $driverInstance;

    /**
     * @var Invoice
     */
    protected $invoice;

    protected $payload = [];
    /**
     * @var Guzzper
     */
    private $client;


    /**
     * PaymentManager constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->invoice(new Invoice());
        $this->via($this->config['customer_club']);
        $this->guzzper();
    }

    public function loadInitPayload()
    {
        $this->setVendorId();
        $this->setMerchantReference();
        $this->setMd5Hash();
        $this->setCardType();
        $this->setMerchantIP();
        $this->setMerchantDate();
        $this->setMerchantTime();
    }

    /**
     * Set custom configs
     * we can use this method when we want to use dynamic configs
     *
     * @param $key
     * @param $value |null
     *
     * @return $this
     */
    public function config($key, $value = null)
    {
        $configs = [];

        $key = is_array($key) ? $key : [$key => $value];

        foreach ($key as $k => $v) {
            $configs[$k] = $v;
        }

        $this->settings = array_merge($this->settings, $configs);

        return $this;
    }

    /**
     * Set callbackUrl.
     *
     * @param $url |null
     * @return $this
     */
    public function callbackUrl($url = null)
    {
        $this->callbackUrl = $url;

        return $this;
    }

    /**
     * Reset the callbackUrl to its original that exists in configs.
     *
     * @return $this
     */
    public function resetCallbackUrl()
    {
        $this->callbackUrl();

        return $this;
    }

    /**
     * Set payment amount.
     *
     * @param $amount
     * @return $this
     * @throws \Exception
     */
    public function amount($amount)
    {
        $this->invoice->amount($amount);

        return $this;
    }

    /**
     * Set a piece of data to the details.
     *
     * @param $key
     *
     * @param $value |null
     *
     * @return $this
     */
    public function detail($key, $value = null)
    {
        $this->invoice->detail($key, $value);

        return $this;
    }

    /**
     * Set transaction's id
     *
     * @param $id
     *
     * @return $this
     */
    public function transactionId($id)
    {
        $this->invoice->transactionId($id);

        return $this;
    }

    /**
     * Change the driver on the fly.
     *
     * @param $driver
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function via($driver)
    {
        $this->driver = $driver;
        $this->driverInstance = $this->getFreshDriverInstance();
        $this->validateDriver();
        $this->invoice->via($driver);
        $this->settings = $this->config['drivers'][$driver];

        return $this;
    }

    /**
     * Purchase the invoice
     *
     * @param Invoice $invoice |null
     * @param $finalizeCallback |null
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function purchase(Invoice $invoice = null, $finalizeCallback = null)
    {
        if ($invoice) { // create new invoice
            $this->invoice($invoice);
        }

        $this->driverInstance = $this->getFreshDriverInstance();

        //purchase the invoice
        $transactionId = $this->driverInstance->purchase();
        if ($finalizeCallback) {
            call_user_func_array($finalizeCallback, [$this->driverInstance, $transactionId]);
        }

        // dispatch event
        $this->dispatchEvent(
            'purchase',
            $this->driverInstance,
            $this->driverInstance->getInvoice()
        );

        return $this;
    }

    /**
     * Pay the purchased invoice.
     *
     * @param $initializeCallback |null
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function pay($initializeCallback = null)
    {
        $this->driverInstance = $this->getDriverInstance();


        $this->validateInvoice();

        // dispatch event
        $this->dispatchEvent(
            'pay',
            $this->driverInstance,
            $this->driverInstance->getInvoice()
        );

        return $this->driverInstance->pay();
    }

    /**
     * Verifies the payment
     *
     * @param $finalizeCallback |null
     *
     * @return ReceiptInterface
     *
     * @throws InvoiceNotFoundException
     */
    public function verify($finalizeCallback = null): ReceiptInterface
    {
        $this->driverInstance = $this->getDriverInstance();
        $this->validateInvoice();
        $receipt = $this->driverInstance->verify();

        if (!empty($finalizeCallback)) {
            call_user_func($finalizeCallback, $receipt, $this->driverInstance);
        }

        // dispatch event
        $this->dispatchEvent(
            'verify',
            $receipt,
            $this->driverInstance,
            $this->driverInstance->getInvoice()
        );

        return $receipt;
    }

    public function fakeVerify($transactionResult): ReceiptInterface
    {
        $this->driverInstance = $this->getDriverInstance();
        $this->validateInvoice();
        $receipt = $this->driverInstance->fakeVerify($transactionResult);


        // dispatch event
        $this->dispatchEvent(
            'verify',
            $receipt,
            $this->driverInstance,
            $this->driverInstance->getInvoice()
        );

        return $receipt;
    }


    /**
     * Set invoice instance.
     *
     * @param Invoice $invoice
     *
     * @return self
     */
    protected function invoice(Invoice $invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Retrieve current driver instance or generate new one.
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getDriverInstance()
    {
        if (!empty($this->driverInstance)) {
            return $this->driverInstance;
        }

        return $this->getFreshDriverInstance();
    }

    /**
     * Get new driver instance
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getFreshDriverInstance()
    {
        $this->validateDriver();
        $class = $this->config['map'][$this->driver];

        return new $class($this->invoice, $this->settings);
    }

    /**
     * Validate Invoice.
     *
     * @throws InvoiceNotFoundException
     */
    protected function validateInvoice()
    {
        if (empty($this->invoice)) {
            throw new InvoiceNotFoundException('Invoice not selected or does not exist.');
        }
    }

    /**
     * Validate driver.
     *
     * @throws \Exception
     */
    protected function validateDriver()
    {
        if (empty($this->driver)) {
            throw new DriverNotFoundException('Driver not selected or default driver does not exist.');
        }

        if (empty($this->config['drivers'][$this->driver]) || empty($this->config['map'][$this->driver])) {
            throw new DriverNotFoundException('Driver not found in config file. Try updating the package.');
        }

        if (!class_exists($this->config['map'][$this->driver])) {
            throw new DriverNotFoundException('Driver source not found. Please update the package.');
        }

        $reflect = new \ReflectionClass($this->config['map'][$this->driver]);

        if (!$reflect->implementsInterface(DriverInterface::class)) {
            throw new \Exception("Driver must be an instance of Contracts\DriverInterface.");
        }
    }


    public function setCardNumber($cardNumber): void
    {
        $this->payload['Card_number'] = $cardNumber;
    }

    public function getMethod()
    {
        return $this->payload['Merchant_Request'];
    }

    public function setMethod($method): void
    {
        $this->payload['Merchant_Request'] = $method;
    }

    public function setMd5Hash()
    {
        $this->payload['MD5_Hash'] = md5(
            $this->payload['Merchant_Request'] .
            $this->payload['Merchant_Reference'] .
            $this->payload['VendorId'] .
            $this->settings['vendorPass'] .
            $this->settings['userKey']
        );
    }

    public function setMerchantIP()
    {
        $this->payload['MerchantIP'] = $this->settings['merchantIp'];
    }


    public function setVendorId()
    {
        $this->payload['VendorId'] = $this->settings['vendorId'];
    }


    public function setMerchantReference()
    {
        $this->payload['Merchant_Reference'] = Uuid::uuid4()->toString();
    }

    public function setMerchantDate()
    {
        $this->payload['Merchant_date'] = verta()->format('Ymd');
    }


    public function setMerchantTime()
    {
        $this->payload['Merchant_time'] = verta()->format('His');
    }

    public function setCardType()
    {
        $this->payload['card_type'] = $this->settings['cardType'];
    }

    public function setMerchantId()
    {
        $this->payload['Merchant_Id'] = $this->settings['merchantId'];
    }

    public function setTerminalPass()
    {
        $this->payload['Terminal_Pass'] = $this->settings['terminalPass'];
    }
    public function setTerminalId()
    {
        $this->payload['Terminal_Id'] = $this->settings['terminalId'];
    }
    public function setSecurityCode()
    {
        $this->payload['securitycode'] = '58456890';
    }
    public function setSecurityCode2()
    {
        $this->payload['securitycode_2'] = '';
    }
    public function setCardExpireMonth()
    {
        $this->payload['cardexpiremonth'] = '12';
    }
    public function setCardExpireYear()
    {
        $this->payload['cardexpireyear'] = '1399';
    }

    public function setPayloads()
    {
        $this->loadInitPayload();
        $initPayload = $this->payload;
        $this->payload = array_merge($initPayload, $this->driverInstance->setPayloads());
    }

    public function cardBalanceLimitService2()
    {
        $this->driverInstance = $this->getDriverInstance();
        $this->validateInvoice();
        $receipt = $this->driverInstance->verify();

        if (!empty($finalizeCallback)) {
            call_user_func($finalizeCallback, $receipt, $this->driverInstance);
        }

        // dispatch event
        $this->dispatchEvent(
            'verify',
            $receipt,
            $this->driverInstance,
            $this->driverInstance->getInvoice()
        );

        return $receipt;
    }

    public function __call($method, $parameters)
    {
        $this->setMethod($method);
        $this->setCardNumber('7921101111111111');
        $this->setPayloads();
        $this->setMerchantId();
        $this->setTerminalPass();
        $this->setTerminalId();
        $this->setSecurityCode();
        $this->setSecurityCode2();
        $this->setCardExpireMonth();
        $this->setCardExpireYear();
        $this->totalamount();
        $this->purchaseamount();
        $this->taxamount();
        $this->shippingamount();
        $this->dutyamount();
        $this->Currency_Request();
        $this->cardHolderIP();
        $this->setMerchantDate();
        $this->setMerchantTime();
//        dd($this->payload);
        $xmlPayloads = ArrayToXml::convert($this->payload, 'GatewayRequest');
        dump($xmlPayloads);
        $xml_body = $xmlPayloads;
        $request_uri = 'HTTP://www.irccg1.com/appapi/Eaccg_Global_Gateway_test.asp';
        $client = new Client();
        $response = $client->request('POST', $request_uri, [
    'headers' => [
        'Content-Type' => 'text/xml'
    ],
    'body'   => $xml_body
]);
        dd(new \SimpleXMLElement($response->getBody()->getContents()));
        return $response;
    }


    private function guzzper()
    {
        $servicePath = 'HTTP://www.irccg1.com/appapi/Eaccg_Global_Gateway_test.asp';
        $this->client = new Guzzper($servicePath);
    }

    private function totalamount()
    {
        $this->payload['totalamount'] = '10000';
    }
    private function purchaseamount()
    {
        $this->payload['purchaseamount'] = '10000';
    }
    private function taxamount()
    {
        $this->payload['taxamount'] = '0';
    }
    private function shippingamount()
    {
        $this->payload['shippingamount'] = '0';
    }
    private function dutyamount()
    {
        $this->payload['dutyamount'] = '0';
    }
    private function Currency_Request()
    {
        $this->payload['Currency_Request'] = 'IRR';
    }

    private function cardHolderIP()
    {
        $this->payload['cardHolderIP'] = $this->get_ip_address();
    }




    public function get_ip_address()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }
}
