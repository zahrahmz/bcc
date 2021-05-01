<?php


namespace App\Services\Site;

use App\Repositories\Admin\SettingRepository;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentService
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function goToGateway($data)
    {
        $defaultGateway = getDefaultBankGateway();

        $invoice = new Invoice();
        $invoice->transactionId($data['transaction_id']);
        $invoice->amount($data['total_order_price']);
        $invoice->detail(['payerId' => currentUserObj()->id]);

        Payment::via($defaultGateway)->purchase($invoice, function ($driver, $transactionId) {
        });

        return Payment::via($defaultGateway)->purchase($invoice)->pay()->render();
    }
}
