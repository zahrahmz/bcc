<?php


namespace App\Services\CustomersClub;

use Carbon\Carbon;
use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\Contracts\ReceiptInterface;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Receipt;
use Shetabit\Multipay\RedirectionForm;
use Shetabit\Multipay\Request;

class LLCCGPaymentDriver extends Driver
{
    /**
     * Invoice
     *
     * @var Invoice
     */
    protected $invoice;

    /**
     * Driver settings
     *
     * @var object
     */
    protected $settings;


    protected $payloads = [];
    /**
     * Behpardakht constructor.
     * Construct the class with the relevant settings.
     *
     * @param Invoice $invoice
     * @param $settings
     */
    public function __construct(Invoice $invoice, $settings)
    {
        $this->invoice($invoice);
        $this->settings = (object) $settings;
    }

    public function setPayloads()
    {
        return $this->payloads;
    }
    /**
     * Purchase Invoice.
     *
     * @return string
     *
     * @throws PurchaseFailedException
     * @throws \SoapFault
     */

    public function purchase()
    {
        $soap = new \SoapClient($this->settings->apiPurchaseUrl);
        $response = $soap->bpPayRequest($this->preparePurchaseData());

        // fault has happened in bank gateway
        if ($response->return == 21) {
            throw new PurchaseFailedException('پذیرنده معتبر نیست.', 21);
        }

        $data = explode(',', $response->return);

        // purchase was not successful
        if ($data[0] != "0") {
            throw new PurchaseFailedException($this->translateStatus($data[0]), (int) $data[0]);
        }

        $this->invoice->transactionId($data[1]);

        // return the transaction's id
        return $this->invoice->getTransactionId();
    }

    /**
     * Pay the Invoice
     *
     * @return RedirectionForm
     */
    public function pay() : RedirectionForm
    {
        $payUrl = $this->settings->apiPaymentUrl;

        return $this->redirectWithForm(
            $payUrl,
            [
                'RefId' => $this->invoice->getTransactionId(),
            ],
            'POST'
        );
    }


    public function fakeVerify($sample): ReceiptInterface
    {
        $resCode = $sample['ResCode'];
        if ($resCode != '0') {
            throw new InvalidPaymentException($this->translateStatus($resCode), $resCode);
        }

        $orderId = $sample['SaleOrderId'];
        $verifySaleOrderId = $sample['SaleOrderId'];
        $verifySaleReferenceId = $sample['SaleReferenceId'];

        $data = array(
            'terminalId'        => $this->settings->terminalId,
            'userName'          => $this->settings->username,
            'userPassword'      => $this->settings->password,
            'orderId'           => $orderId,
            'saleOrderId'       => $verifySaleOrderId,
            'saleReferenceId'   => $verifySaleReferenceId
        );

        $soap = new \SoapClient($this->settings->apiVerificationUrl);

        // step1: verify request
        $verifyResponse = 0;
        if ($verifyResponse != 0) {
            // rollback money and throw exception
            // avoid rollback if request was already verified
            if ($verifyResponse != 43) {
                $soap->bpReversalRequest($data);
            }
            throw new InvalidPaymentException($this->translateStatus($verifyResponse), $verifyResponse);
        }

        // step2: settle request
        $settleResponse = 0;
        if ($settleResponse != 0) {
            // rollback money and throw exception
            // avoid rollback if request was already settled/reversed
            if ($settleResponse != 45 && $settleResponse != 48) {
                $soap->bpReversalRequest($data);
            }
            throw new InvalidPaymentException($this->translateStatus($settleResponse), $settleResponse);
        }

        return $this->createReceipt($data['saleReferenceId']);
    }

    /**
     * Verify payment
     *
     * @return mixed|Receipt
     *
     * @throws InvalidPaymentException
     * @throws \SoapFault
     */
    public function verify() : ReceiptInterface
    {
        $resCode = Request::input('ResCode');
        if ($resCode != '0') {
            throw new InvalidPaymentException($this->translateStatus($resCode), $resCode);
        }

        $data = $this->prepareVerificationData();
        $soap = new \SoapClient($this->settings->apiVerificationUrl);

        // step1: verify request
        $verifyResponse = (int)$soap->bpVerifyRequest($data)->return;
        if ($verifyResponse != 0) {
            // rollback money and throw exception
            // avoid rollback if request was already verified
            if ($verifyResponse != 43) {
                $soap->bpReversalRequest($data);
            }
            throw new InvalidPaymentException($this->translateStatus($verifyResponse), $verifyResponse);
        }

        // step2: settle request
        $settleResponse = $soap->bpSettleRequest($data)->return;
        if ($settleResponse != 0) {
            // rollback money and throw exception
            // avoid rollback if request was already settled/reversed
            if ($settleResponse != 45 && $settleResponse != 48) {
                $soap->bpReversalRequest($data);
            }
            throw new InvalidPaymentException($this->translateStatus($settleResponse), $settleResponse);
        }

        return $this->createReceipt($data['saleReferenceId']);
    }

    /**
     * Generate the payment's receipt
     *
     * @param $referenceId
     *
     * @return Receipt
     */
    protected function createReceipt($referenceId)
    {
        return new Receipt('behpardakht', $referenceId);
    }

    /**
     * Prepare data for payment verification
     *
     * @return array
     */
    protected function prepareVerificationData()
    {
        $orderId = Request::input('SaleOrderId');
        $verifySaleOrderId = Request::input('SaleOrderId');
        $verifySaleReferenceId = Request::input('SaleReferenceId');

        return array(
            'terminalId'        => $this->settings->terminalId,
            'userName'          => $this->settings->username,
            'userPassword'      => $this->settings->password,
            'orderId'           => $orderId,
            'saleOrderId'       => $verifySaleOrderId,
            'saleReferenceId'   => $verifySaleReferenceId
        );
    }

    /**
     * Prepare data for purchasing invoice
     *
     * @return array
     */
    protected function preparePurchaseData()
    {
        if (!empty($this->invoice->getDetails()['description'])) {
            $description = $this->invoice->getDetails()['description'];
        } else {
            $description = $this->settings->description;
        }

        $payerId = $this->invoice->getDetails()['payerId'] ?? 0;

        return array(
            'terminalId'        => $this->settings->terminalId,
            'userName'          => $this->settings->username,
            'userPassword'      => $this->settings->password,
            'callBackUrl'       => $this->settings->callbackUrl,
            'amount'            => $this->invoice->getAmount() * 10, // convert to rial
            'localDate'         => Carbon::now()->format('Ymd'),
            'localTime'         => Carbon::now()->format('Gis'),
            'orderId'           => crc32($this->invoice->getUuid()),
            'additionalData'    => $description,
            'payerId'           => $payerId
        );
    }

    /**
     * Convert status to a readable message.
     *
     * @param $status
     *
     * @return mixed|string
     */
    private function translateStatus($status)
    {
        $translations = [
            '0' => 'تراکنش با موفقیت انجام شد',
            '11' => 'شماره کارت نامعتبر است',
            '12' => 'موجودی کافی نیست',
            '13' => 'رمز نادرست است',
            '14' => 'تعداد دفعات وارد کردن رمز بیش از حد مجاز است',
            '15' => 'کارت نامعتبر است',
            '16' => 'دفعات برداشت وجه بیش از حد مجاز است',
            '17' => 'کاربر از انجام تراکنش منصرف شده است',
            '18' => 'تاریخ انقضای کارت گذشته است',
            '19' => 'مبلغ برداشت وجه بیش از حد مجاز است',
            '111' => 'صادر کننده کارت نامعتبر است',
            '112' => 'خطای سوییچ صادر کننده کارت',
            '113' => 'پاسخی از صادر کننده کارت دریافت نشد',
            '114' => 'دارنده کارت مجاز به انجام این تراکنش نیست',
            '21' => 'پذیرنده نامعتبر است',
            '23' => 'خطای امنیتی رخ داده است',
            '24' => 'اطلاعات کاربری پذیرنده نامعتبر است',
            '25' => 'مبلغ نامعتبر است',
            '31' => 'پاسخ نامعتبر است',
            '32' => 'فرمت اطلاعات وارد شده صحیح نمی‌باشد',
            '33' => 'حساب نامعتبر است',
            '34' => 'خطای سیستمی',
            '35' => 'تاریخ نامعتبر است',
            '41' => 'شماره درخواست تکراری است',
            '42' => 'تراکنش Sale یافت نشد',
            '43' => 'قبلا درخواست Verify داده شده است',
            '44' => 'درخواست Verify یافت نشد',
            '45' => 'تراکنش Settle شده است',
            '46' => 'تراکنش Settle نشده است',
            '47' => 'تراکنش Settle یافت نشد',
            '48' => 'تراکنش Reverse شده است',
            '412' => 'شناسه قبض نادرست است',
            '413' => 'شناسه پرداخت نادرست است',
            '414' => 'سازمان صادر کننده قبض نامعتبر است',
            '415' => 'زمان جلسه کاری به پایان رسیده است',
            '416' => 'خطا در ثبت اطلاعات',
            '417' => 'شناسه پرداخت کننده نامعتبر است',
            '418' => 'اشکال در تعریف اطلاعات مشتری',
            '419' => 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است',
            '421' => 'IP نامعتبر است',
            '51' => 'تراکنش تکراری است',
            '54' => 'تراکنش مرجع موجود نیست',
            '55' => 'تراکنش نامعتبر است',
            '61' => 'خطا در واریز',
            '62' => 'مسیر بازگشت به سایت در دامنه ثبت شده برای پذیرنده قرار ندارد',
            '98' => 'سقف استفاده از رمز ایستا به پایان رسیده است'
        ];

        $unknownError = 'خطای ناشناخته رخ داده است.';

        return array_key_exists($status, $translations) ? $translations[$status] : $unknownError;
    }
}
