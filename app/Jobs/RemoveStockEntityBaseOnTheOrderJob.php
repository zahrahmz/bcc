<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveStockEntityBaseOnTheOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    private $cartData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cartData)
    {
        $this->cartData = $cartData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cart =Cart::query()
            ->where('id', $this->cartData['cartId'])
            ->whereNotIn('status',[Cart::PAID])
            ->first();

        if (!empty($cart->id)){
            $cartItems = $cart->cartItems()->get();

            foreach ($cartItems as $cartItem) {
                ProductAttribute::query()
                    ->where('id', $cartItem->product_attribute_id)
                    ->increment('quantity', $cartItem->quantity);
            }
        }
    }
}
