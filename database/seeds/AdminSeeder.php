<?php

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::query()->create([
            'name' => 'admin',
            'mobile' => '09123456789',
            'password' => bcrypt('123123'),
            'mobile_verified_at' => Carbon::now(),
        ]);
    }
}
