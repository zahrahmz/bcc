<?php


namespace App\Repositories\Site;

use App\Repositories\BaseRepository;
use \App\Models\Payment as PaymentModel;

class PaymentRepository extends BaseRepository
{
    public function __construct(PaymentModel $payment)
    {
        parent::__construct($payment);
        $this->model = $payment;
    }


    public function saveTransaction($order_reference)
    {
        $this->model->order_reference = $order_reference;
        $this->model->save();
    }

    public function callbackResolver()
    {
    }
}
