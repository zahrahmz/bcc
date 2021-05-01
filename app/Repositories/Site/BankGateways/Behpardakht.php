<?php


namespace App\Repositories\Site\BankGateways;

use App\Jobs\SendSms;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment as PaymentModel;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Request;
use Shetabit\Payment\Facade\Payment;

class Behpardakht
{
    private $paymentLog;
    private $transactionResult;

    private $defaultGateway;

    public function __construct($paymentLog, $transactionResult)
    {
        $this->paymentLog = $paymentLog;
        $this->transactionResult = $transactionResult;
        $this->defaultGateway = getDefaultBankGateway();
    }


    public function verify()
    {
        $result = new \stdClass();
        try {
            $this->savePaymentLog();

            DB::beginTransaction();
            $order = $this->paymentLog->order;

            $receipt = Payment::via($this->defaultGateway)->transactionId($this->transactionResult['RefId'])->amount((int)$this->paymentLog->total_order_price)->verify();

            $this->successfulPayment($order);
            DB::commit();
            dispatch(new SendSms($order->phone, trans('messages.order_submitted_successfully')));

            $result->status = true;
            $result->invoice = $receipt;
            $result->error = null;
            return $result;
        } catch (InvalidPaymentException $e) {
            //settle or verify was failed and money will be back to user until 24 hours
//            DB::rollBack();
            $this->failPayment($order);
            DB::commit();
            dispatch(new SendSms($order->phone, trans('messages.order_submitted_unsuccessfully')));

            $result->status = false;
            $result->invoice = null;
            $result->error = Lang::get('payment.fail_payment');
            return $result;

        } catch (QueryException $e) {
            $this->unknownPayment($order);
            DB::commit();
            $result->status = false;
            $result->invoice = null;
            $result->error = Lang::get('payment.fail_payment');
            return $result;
        }
    }

    /**
     * @param $order
     */
    private function failPayment($order): void
    {
        $order->Payment_status = PaymentModel::FAIL_PAYMENT;
        $order->order_state = Order::ORDER_STATUS_REJECTED;
        $order->save();

        $order->cart->status = Cart::ACTIVE;
        $order->cart->save();
    }

    /**
     * @param $order
     */
    private function successfulPayment($order): void
    {
        $order->Payment_status = PaymentModel::SUCCESSFUL_PAYMENT;
        $order->save();


        $order->cart->status = Cart::PAID;
        $order->cart->save();
    }

    private function unknownPayment($order): void
    {
        $order->Payment_status = PaymentModel::UNKNOWN_PAYMENT;
        $order->save();

        $order->cart->status = Cart::UNKNOWN;
        $order->cart->save();
    }

    /**
     * @param $defaultGateway
     */
    private function savePaymentLog(): void
    {
        $this->paymentLog->res_code = $this->transactionResult['ResCode'];
        $this->paymentLog->res_string = translateBehpardakhtErrorMessage($this->transactionResult['ResCode']);
        $this->paymentLog->sale_order_id = $this->transactionResult['SaleOrderId'];
        $this->paymentLog->sale_reference_id = !empty($this->transactionResult['SaleReferenceId']) ? $this->transactionResult['SaleReferenceId'] : Null;
        $this->paymentLog->card_holder_pan = !empty($this->transactionResult['CardHolderPan']) ? $this->transactionResult['CardHolderPan'] : Null;
        $this->paymentLog->card_holder_info = !empty($this->transactionResult['CardHolderInfo']) ? $this->transactionResult['CardHolderInfo'] : Null;
        $this->paymentLog->bank_name = $this->defaultGateway;
        $this->paymentLog->updated_at = Carbon::now();
        $this->paymentLog->save();
    }
}
