<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Shipment;
use App\Models\Site\User;
use App\Models\Slider;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use libphonenumber\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

class Migration extends Command
{
    protected $signature = 'migrate:data';

    protected $description = 'Command description';
    private $mapCategory;
    private $mapBrand;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->output->setVerbosity(256);
        $this->setVerbosity(256);

        try {
            $bccstyleConnection = DB::connection('mysql2');
            $this->call('migrate:refresh', ['--seed' => true,'--force' => true,'--no-interaction' => true]);
            $this->addSlider($bccstyleConnection);
            $this->addUsers($bccstyleConnection);
            $this->addCategories($bccstyleConnection);
            $this->addBrands($bccstyleConnection);
            $this->createAttribute();
            $this->addProducts($bccstyleConnection);
            $this->addMenus($bccstyleConnection);
            $this->addDelivery($bccstyleConnection);


        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }


    private function addUsers($bccstyleConnection)
    {
        $users = $bccstyleConnection->select(
            'select * from users where length(mobile) >9'
        );
        $this->line("<fg=default;bg=black>users import</>");
        $progressBar = $this->output->createProgressBar(count($users));
        $progressBar->start();

        foreach ($users as $user) {
            $userId = $user->id;
            try {
                $progressBar->advance();
                /**
                 * @var User $user
                 */
                $user = User::query()->insertOrIgnore([
                    'id' => $user->id,
                    'name' => $user->fullName,
                    'password' => $user->password,
                    'email' => empty($user->email) ? null : $user->email,
                    'mobile' => PhoneNumber::make($user->mobile, 'IR')->formatForMobileDialingInCountry('IR'),
                ]);
            } catch (\libphonenumber\NumberParseException $e) {
                DB::table('not_valid_users')->insert([
                    'id' => $user->id,
                    'name' => $user->fullName,
                    'password' => $user->password,
                    'email' => $user->email,
                    'mobile' => $user->mobile
                ]);
                continue;
            } catch (Exception $e) {
                dd($e->getMessage());
            }


            $addresses = $bccstyleConnection->select(
                'SELECT  province.name as province,city.name as city,bascket.address as user_address,bascket.name as user_name,bascket.family as user_family,bascket.mobile,bascket.postalCode as postal_code FROM  `bascket` JOIN  cart ON cart.id = bascket.cartID JOIN  province ON province.id = bascket.stateID JOIN  city ON city.id = bascket.cityID where cart.userID=' . $userId
            );

            try {
                foreach ($addresses as $address) {
                    if ($address->user_name && $address->user_family && $address->province && $address->city && $address->mobile) {
                        User::query()->findOrFail($userId)->addresses()->save(new Address([
                            'name_of_receiver' => $address->user_name . ' ' . $address->user_family,
                            'province' => $address->province,
                            'city' => $address->city,
                            'address' => $address->user_address,
                            'postal_code' => empty($address->postal_code) ? 0000000000 : $address->postal_code,
                            'phone' => PhoneNumber::make($address->mobile, 'IR')->formatForMobileDialingInCountry('IR'),
                        ]));
                        break;
                    }
                    continue;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                continue;
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }

        $progressBar->finish();
    }


    private function addCategories($bccstyleConnection)
    {
        $categories = $bccstyleConnection->select(
            'SELECT * FROM `catproduct`'
        );

        $this->line("<fg=default;bg=black>categories import</>");

        foreach ($categories as $category) {
            $createdCategory = Category::query()->create([
                'name' => $category->name,
                'slug' => $category->urltitle,
                'description' => $category->description,
                'order' => $category->sort,
                'status' => Category::ACTIVE,
                'type' => Category::CATEGORY,
            ]);
            $this->mapCategory[$category->id] = $createdCategory->id;
            if (!empty($category->img)) {
                $createdCategory->image()->save(new Image([
                    'path' => $this->cleanImage($category->img)
                ]));
            }
        }
    }


    private function addBrands($bccstyleConnection)
    {
        $brands = $bccstyleConnection->select(
            'SELECT * FROM `plan`'
        );

        $this->line("<fg=default;bg=black>Brand import</>");
        foreach ($brands as $key => $brand) {
            $createBrand = Category::query()->create([
                'name' => $brand->name,
                'slug' => str_to_slug($brand->name, '-'),
                'description' => $brand->description,
                'status' => Category::ACTIVE,
                'order' => $key,
                'type' => Category::BRAND,
            ]);
            $this->mapBrand[$brand->id] = $createBrand->id;
            if ($brand->img) {
                $createBrand->image()->save(new Image([
                    'path' => $this->cleanImage($brand->img)
                ]));
            }
        }
    }


    private function createAttribute()
    {
        DB::beginTransaction();
        try {
            $this->line("<fg=default;bg=black>attribute import</>");
            $attribute = Attribute::query()->create([
                'attribute_name' => 'سایز'
            ]);


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd('ProductAttribute', $e->getMessage());
        }
    }

    private function addProducts($bccstyleConnection)
    {
        //SELECT * FROM `product` join plan as p on p.id = product.planID join catproduct_product on catproduct_product.product_id=product.id join catproduct on catproduct.id =catproduct_product.category_product_id join aboutproduct on aboutproduct.productID = product.id join detailsvalue on detailsvalue.productID = product.id join featurevalue on featurevalue.productID = product.id join subcat_relation on subcat_relation.productID = product.id join subcat on subcat.id = subcat_relation.subcatID join productimg on productimg.productID = product.id
        $products = $bccstyleConnection->select(
            'SELECT * FROM `product`'
        );

        $count = count($products);

        $this->line("<fg=default;bg=black>product and product_attribute_values import</>");
        $progressBar = $this->output->createProgressBar($count);
        $progressBar->start();

        foreach ($products as $sku => $product) {
            $productId = $product->id;

            list($productDSC, $gender) = $this->calculateProductDetails($bccstyleConnection, $productId);

            $createdProduct = $this->addProduct($product, $sku, $gender, $productDSC);

            $this->attachProductImage($bccstyleConnection, $productId, $createdProduct);
            $this->attachBrandAndCategories($bccstyleConnection, $productId, $product, $createdProduct);
            $this->attachAttributeValues($bccstyleConnection, $productId, $createdProduct);
            $progressBar->advance();
        }


        $progressBar->finish();
    }

    private function addSlider($bccstyleConnection): void
    {
        $sliders = $bccstyleConnection->select(
            'select * from slider'
        );

        $this->line("<fg=default;bg=black>slider import</>");
        foreach ($sliders as $slide) {
            $slider = Slider::query()->create([
                'link' => $slide->title,
                'status' => 1,
                'section' => Slider::HOME_TOP
            ]);

            $sliderImage = new Image([
                'path' => $this->cleanImage($slide->img)
            ]);
            $slider->image()->save($sliderImage);
        }
    }

    private function addMenus($bccstyleConnection): void
    {
        $menus = $bccstyleConnection->select(
            'select * from menu2'
        );



        $this->line("<fg=default;bg=black>Menu import</>");

        $parentId = null;

        foreach ($menus as $key => $menu) {
            $catName = Str::after($menu->link,'baby-clothing/');
            $category=Category::query()
                ->where('type',2)
                ->where('slug',$catName)
                ->get()
                ->first();
            $createdMenu = Category::query()->create([
                'name' => $menu->name,
                'order' => $menu->id,
                'parent_id' => $menu->parent === null ? null : $parentId,
                'type' => Category::MENU,
                'slug' => str_to_slug($menu->name, '-'),
                'status' => 1,
                'link' =>  $category === null ? null :'/products?category='.$category->id
            ]);
            if ($menu->parent === null){
                $parentId = $createdMenu->id;
            }

            if($menu->picture != null){
                $sliderImage = new Image([
                    'path' => $menu->picture
                ]);
                $createdMenu->image()->save($sliderImage);
            }
        }
    }
    private function addDelivery($bccstyleConnection): void
    {
        $deliveries = $bccstyleConnection->select(
            'SELECT * FROM `expresssend`'
        );

        $this->line("<fg=default;bg=black>Delivery import</>");

        foreach ($deliveries as $key => $delivery) {

            $createdMenu = Shipment::query()->create([
                'name' => $delivery->send,
                'price' => $delivery->price,
                'status' => 1,

            ]);
        }
    }

    private function attachAttributeValues($bccstyleConnection, $productId, $createdProduct): void
    {
        $attributeValues = $bccstyleConnection->select(
            "SELECT * FROM featurevalue where productID =$productId"
        );
        /**
         * @var $attribute Attribute
         */
        $attribute = Attribute::query()->findOrFail(1);

        foreach ($attributeValues as $attributeValue) {
            if (empty($attributeValue->value)) {
                continue;
            }
            $attribute_value_id = $attribute->values()->firstOrCreate(['value' => $attributeValue->value], ['value' => $attributeValue->value]);
            $productAttribute = new ProductAttribute([
                'price' => $attributeValue->price,
                'quantity' => $attributeValue->count
            ]);
            $createdProductAttribute = $createdProduct->attributes()->save($productAttribute);

            $createdProductAttribute->attributesValues()->sync($attribute_value_id);
        }
    }

    private function attachProductImage($bccstyleConnection, $productId, Product $createdProduct): void
    {
        $images = $bccstyleConnection->select(
            "SELECT * FROM  productimg where productimg.productID=$productId"
        );

        if (!empty($images)) {
            foreach ($images as $image) {
                $createdProduct->images()->save(new Image([
                    'path' => $this->cleanImage($image->img)
                ]));
            }
        }
    }

    private function attachBrandAndCategories($bccstyleConnection, $productId, $product, Product $createdProduct): void
    {
        $categoryAndBrand = [];
        $categories = $bccstyleConnection->select(
            "SELECT *  FROM `catproduct_product` WHERE `product_id` =$productId"
        );

        foreach ($categories as $category) {
            $categoryAndBrand[] = $this->mapCategory[$category->category_product_id];
        }
        $categoryAndBrand[] = $this->mapBrand[$product->planID];
        $createdProduct->categories()->attach($categoryAndBrand);
    }

    private function addProduct($product, int $sku, string $gender, string $productDSC)
    {
        $createdProduct = Product::query()->create([
            'product_name' => $product->name,
            'sku' => $sku,
            'slug' => str_to_slug($product->name, '-'),
            'gender' => $gender,
            'description' => !empty($productDSC) ? $productDSC : null,
            'price' => $product->price,
            'status' => $product->status == 2 ? Product::INACTIVE : Product::ACTIVE,
            'featured' => ((rand(1,10) / 5) == 0) == 0 ? 1 : 0,
        ]);
        return $createdProduct;
    }

    private function calculateProductDetails($bccstyleConnection, $productId): array
    {
        $productDescriptions = $bccstyleConnection->select(
            "SELECT * FROM  aboutproduct where productID =$productId"
        );

        $productDescriptions2 = $bccstyleConnection->select(
            "SELECT * FROM  detailsvalue where productID =$productId"
        );

        $productDSC = [];
        foreach ($productDescriptions2 as $key => $productDescription) {
            $productDSC[] = $productDescription->title . ' : ' . $productDescription->value;
        }

        foreach ($productDescriptions as $key => $productDescription) {
            $productDSC[] = $productDescription->details;
        }
        $productDSC = implode('__', $productDSC);

        $genders = $bccstyleConnection->select(
            "SELECT * FROM `subcat_relation` where productID =$productId"
        );

        $genderTypes = [];
        foreach ($genders as $key => $gender) {
            $genderTypes[] = $gender->subcatID;
        }

        if (array_sum($genderTypes) == 19) {
            $gender = Product::GENDER[2];
        } elseif (array_sum($genderTypes) == 9) {
            $gender = Product::GENDER[1];
        } else {
            $gender = Product::GENDER[0];
        }
        return array($productDSC, $gender);
    }

    private function cleanImage($img): string
    {
        return 'products/' . Str::after($img, 'uploads/');
    }
}
