<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Site\User;
use App\Models\Slider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use libphonenumber\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

class GenerateIdeHelpers extends Command
{
    protected $signature = 'ide:helper';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call('ide-helper:generate');
        $this->call('ide-helper:eloquent');
        $this->call('ide-helper:models', ['--no-interaction' => true,'--reset' => true]);
        $this->call('ide-helper:meta');
    }
}
