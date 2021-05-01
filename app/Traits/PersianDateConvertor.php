<?php


namespace App\Traits;

use Illuminate\Support\Str;

trait PersianDateConvertor
{
    public function formatToJalali($functionName)
    {
        $selectedAttribute = $this->getMutatorMethod($functionName);
        return verta($this->getAttributeFromArray($selectedAttribute))->format('Y-n-j');
    }

    private static function getMutatorMethod($functionName)
    {
        preg_match_all('/(?<=^|;)get([^;]+?)Attribute(;|$)/', implode(';', [$functionName]), $matches);

        return Str::snake($matches[1][0]);
    }
}
