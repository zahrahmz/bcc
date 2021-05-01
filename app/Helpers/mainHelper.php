<?php

use App\Models\Cart as CartModel;
use App\Models\Site\User;
use App\Repositories\Admin\SettingRepository;
use Aws\Laravel\AwsFacade;
use Aws\S3\S3Client;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (!function_exists('cart')) {
    function cart()
    {
        /**
         * @var $cart Cart
         */
        $cart = \Cart::instance('cart');
        return $cart;
    }
}

/**
 * if user has saved cart in database that is not converted to order we return it as currentCart
 */
if (!function_exists('getUserCurrentCart')) {
    function getUserCurrentCart() : CartModel
    {
        //if user has unfinished cart we return it,and do not create new cart for him
        $cart = CartModel::query()->where(['user_id'=> currentUserObj()->id,'status' => CartModel::ACTIVE])->latest()->first();

        if (!$cart) {
            $cart = new CartModel();
            $cart->user_id = currentUserObj()->id;
            $cart->save();
        }

        return $cart;
    }
}


if (!function_exists('currentUserObj')) {
    /**
     * @return User|null
     */
    function currentUserObj()
    {
        return Auth::guard('site')->user();
    }
}

if (!function_exists('getDefaultBankGateway')) {
    function getDefaultBankGateway()
    {
        return Cache::rememberForever('default_bank_gateway', function () {
            return app()->make(SettingRepository::class)->getDefaultBankGateway();
        });
    }
}

if (!function_exists('translateBehpardakhtErrorMessage')) {
    function translateBehpardakhtErrorMessage($code)
    {
        $translations = [
            0=> 'تراکنش با موفقیت انجام شد',
            11 => 'شماره کارت نامعتبر است',
            12 => 'موجودی کافی نیست',
            13 => 'رمز نادرست است',
            14 => 'تعداد دفعات وارد کردن رمز بیش از حد مجاز است',
            15 => 'کارت نامعتبر است',
            16 => 'دفعات برداشت وجه بیش از حد مجاز است',
            17 => 'کاربر از انجام تراکنش منصرف شده است',
            18 => 'تاریخ انقضای کارت گذشته است',
            19 => 'مبلغ برداشت وجه بیش از حد مجاز است',
            111 => 'صادر کننده کارت نامعتبر است',
            112 => 'خطای سوییچ صادر کننده کارت',
            113 => 'پاسخی از صادر کننده کارت دریافت نشد',
            114 => 'دارنده کارت مجاز به انجام این تراکنش نیست',
            21 => 'پذیرنده نامعتبر است',
            23 => 'خطای امنیتی رخ داده است',
            24 => 'اطلاعات کاربری پذیرنده نامعتبر است',
            25 => 'مبلغ نامعتبر است',
            31 => 'پاسخ نامعتبر است',
            32 => 'فرمت اطلاعات وارد شده صحیح نمی‌باشد',
            33 => 'حساب نامعتبر است',
            34 => 'خطای سیستمی',
            35 => 'تاریخ نامعتبر است',
            41 => 'شماره درخواست تکراری است',
            42 => 'تراکنش Sale یافت نشد',
            43 => 'قبلا درخواست Verify داده شده است',
            44 => 'درخواست Verify یافت نشد',
            45 => 'تراکنش Settle شده است',
            46 => 'تراکنش Settle نشده است',
            47 => 'تراکنش Settle یافت نشد',
            48 => 'تراکنش Reverse شده است',
            412 => 'شناسه قبض نادرست است',
            413 => 'شناسه پرداخت نادرست است',
            414 => 'سازمان صادر کننده قبض نامعتبر است',
            415 => 'زمان جلسه کاری به پایان رسیده است',
            416 => 'خطا در ثبت اطلاعات',
            417 => 'شناسه پرداخت کننده نامعتبر است',
            418 => 'اشکال در تعریف اطلاعات مشتری',
            419 => 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است',
            421 => 'IP نامعتبر است',
            51 => 'تراکنش تکراری است',
            54 => 'تراکنش مرجع موجود نیست',
            55 => 'تراکنش نامعتبر است',
            61 => 'خطا در واریز',
            62 => 'مسیر بازگشت به سایت در دامنه ثبت شده برای پذیرنده قرار ندارد',
            98 => 'سقف استفاده از رمز ایستا به پایان رسیده است'
        ];

        return $translations[$code];
    }
}


if (!function_exists('convertArabicCharacters')) {
    function convertArabicCharacters($phrase)
    {
        $arabic_characters = ['أ','إ','ك','ؤ','ة','ۀ','ي','٠',';','?',','];
        $persian_characters = ['ا','ا','ک','و','ه','ه','ی','۰','؛','؟','،'];

        return str_replace($arabic_characters, $persian_characters, $phrase);
    }
}


if (!function_exists('convertArabicNumbers')) {
    function convertArabicNumbers($phrase)
    {
        $persianDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $persianDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $allPersianDigits = array_merge($persianDigits1, $persianDigits2);
        $replaces = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 8, 7, 6, 5, 4, 3, 2, 1];
        return str_replace($allPersianDigits, $replaces, $phrase);
    }
}

if (!function_exists('format_number_to_currency')) {
    function format_number_to_currency($price)
    {
        if (empty($price)) {
            return 0;
        }

        return number_format($price, 0, 0, ',');
    }
}

if (!function_exists('convertToGregorian')) {
    function convertToGregorian(array $date)
    {
        list($year, $month, $day) = $date;
        return Carbon::parse(verta()->setDate($year, $month, $day)->formatGregorian('Y-m-d'));
    }
}

if (!function_exists('convertToJalali')) {
    function convertToJalali(array $date)
    {
        list($year, $month, $day) = $date;
        return Carbon::parse(verta()->setDate($year, $month, $day)->formatJalaliDate())->format('Y-m-d');
    }
}
if (!function_exists('s3')) {
    /**
    * @return S3Client
     */
    function s3()
    {
        /**
         * @var S3Client  $s3
         */
        $s3 =  AwsFacade::createClient('s3');
        return $s3;
    }
}
if (!function_exists('redirect_now')) {
    function redirect_now($url, $code = 302)
    {
        try {
            \Illuminate\Support\Facades\App::abort($code, '', ['Location' => $url]);
        } catch (\Exception $exception) {

            $previousErrorHandler = set_exception_handler(function () {
            });
            restore_error_handler();
            call_user_func($previousErrorHandler, $exception);
            die;
        }
    }
}


if (!function_exists('yii2PasswordChecker')) {
    function yii2PasswordChecker($username, $password)
    {
        $user = User::query()
            ->where('mobile', $username)
            ->orWhere('email', $username)
            ->first();

        if (!$user) {
            return false;
        }

        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $user->password, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            return $user;
        }
    }
}
