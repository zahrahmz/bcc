<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Traits\FlashMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    use FlashMessages;

    /**
     * @var null
     */
    protected $data = null;

    /**
     * @param $title
     * @param $subTitle
     */
    protected function setPageTitle($title, $subTitle = null)
    {
        view()->share(['pageTitle' => $title, 'subTitle' => $subTitle]);
    }

    protected function setSideBar($name)
    {
        view()->share(['sidebarName' => $name]);
    }

    /**
     * @param int $errorCode
     * @param null $message
     * @return \Illuminate\Http\Response
     */
    protected function showErrorPage($errorCode = 404, $message = null)
    {
        $data['message'] = $message;
        return response()->view('errors.' . $errorCode, $data, $errorCode);
    }

    /**
     * @param bool $error
     * @param int $responseCode
     * @param array $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson($error = true, $responseCode = 200, $message = [], $data = null)
    {
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param $route
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }

        return redirect()->route($route);
    }


    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        return redirect()->back();
    }

    public function setCartContent()
    {
        $cartItemCount = 0;

        if (Auth::check()) {
            if (!($cartItemCount = Cache::get('items_count_' . currentUserObj()->id))) {
                $cartItemCount = Cache::rememberForever('items_count_' . currentUserObj()->id, function () {
                    return $this->getUserCartQuantity();
                });
            }
        } else {
            if (cart()->content()->isNotEmpty()) {
                $cartItemCount = cart()->count();
            }
        }

        view()->share(['cartItemCount' => $cartItemCount]);
    }

    /**
     * @return mixed
     */
    private function getUserCartQuantity()
    {
        $cart = Cart::query()->where([
            'user_id' => currentUserObj()->id,
            'status' => Cart::ACTIVE
        ])->first();

        if (empty($cart)) {
            return 0;
        }

        return $cart->cartItems()->sum('quantity');
    }

    public function getClean($phrase)
    {
        return convertArabicCharacters(convertArabicNumbers($phrase));
    }
}
