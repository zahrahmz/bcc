<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use App\Models\Site\User;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property string $name_of_receiver
 * @property string $province
 * @property string $city
 * @property string $address
 * @property string $postal_code
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $full_address
 * @property-read User $user
 * @method static \App\Models\Eloquent\BaseBuilder|Address newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Address newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Address query()
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereAddress($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereCity($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereNameOfReceiver($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address wherePhone($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address wherePostalCode($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereProvince($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereUpdatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Address whereUserId($value)
 * @mixin \Eloquent
 */
class Address extends BaseModel
{
    protected $fillable = [
        'name_of_receiver',
        'province',
        'city',
        'address',
        'postal_code',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return $this->province .',' . $this->city . ',' . $this->address;
    }
}
