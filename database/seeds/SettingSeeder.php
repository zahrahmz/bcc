<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();
        $setting->name = 'درگاه بانک';
        $setting->key = 'BANK_GATEWAY';
        $setting->status = 1;
        $setting->save();

        $setting->settingValues()->insert([
            [
                'value' => 'behpardakht',
                'setting_id' => $setting->id,
                'default' => 1,
            ],
            [
                'value' => 'zarinpal',
                'setting_id' => $setting->id,
                'default' => 0,
            ]
        ]);
    }
}
