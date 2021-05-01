<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\SettingRepository;
use App\Repositories\Site\BankGateways\BankGateway;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function callbackUrl(Request $request)
    {
        $transactionResult = $request->all();

        $defaultGateway = getDefaultBankGateway();
        $result = BankGateway::getInstance($defaultGateway, $transactionResult)->verify();

        if ($result->status){
            $this->setPageTitle('پرداخت موفق');

            $invoice = $result->invoice;
            return view('site.payments.success',compact('invoice'));
        }else{
            $this->setPageTitle('پرداخت ناموفق');
            $error = $result->error;
            return view('site.payments.failed',compact('error'));
        }
    }
}
