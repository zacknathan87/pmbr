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
        //

        Setting::create([
            'key' => 'currency_symbol',
            'value' => 'USD',
        ]); 

        Setting::create([
            'key' => 'result_percentage_dice',
            'value' => '[0.01,0.1,0.1,0.1,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692,3.692]'
        ]);

        Setting::create([
            'key' => 'result_percentage_5_number',
            'value' => '[10,10,10,10,10,10,10,10,10,10]'
        ]);

        Setting::create([
            'key' => 'game_running',
            'value' => '1',
        ]);

        Setting::create([
            'key' => 'game_runtime_start',
            'value' => '15:30',
        ]);

        Setting::create([
            'key' => 'game_runtime_end',
            'value' => '19:00',
        ]);

    }
}
