<?php


namespace App\Repositories\Site\BankGateways;

use App\Models\Payment;

class BankGateway
{
    public static function getInstance($defaultGateway, $transactionResult)
    {
        switch ($defaultGateway) {
            case 'behpardakht':

                $paymentLog = self::getPaymentLog($transactionResult['RefId']);
                $gatewayInstance = new Behpardakht($paymentLog, $transactionResult);
                break;
            case 'zarinpal':
                $paymentLog = self::getPaymentLog($transactionResult['Authority']);
                $gatewayInstance = new Zarinpal();
                break;
            default:
                $gatewayInstance = new Behpardakht;
                break;
        }

        return $gatewayInstance;
    }


    private static function getPaymentLog($transactionReference)
    {
        return Payment::query()->where('order_reference', $transactionReference)->first();
    }
}
