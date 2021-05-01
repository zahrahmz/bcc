<?php


namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static $cache = [];

//    public static function query()
//    {
//        return parent::query();
//    }
//
//    public function newEloquentBuilder($query)
//    {
//        return new BaseBuilder($query);
//    }
//
    public function newQuery()
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes());
    }

    public function relationMethodDefineInModel(string $name)
    {
        return method_exists($this,$name);
    }
}
