<?php
namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\Shipment
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment query()
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment whereName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment wherePrice($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment whereStatus($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Shipment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shipment extends BaseModel
{
    protected $guarded = [];
}
