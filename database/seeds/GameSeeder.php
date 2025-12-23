<?php

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // $time = (round(strtotime('now') / 300)) * 300;
        // $date = date('Y-m-d H:i:00', $time);

        // for ($i = 0; $i < 12; $i++) {
        //     Game::create([
        //         'game_channel_id' => 1,
        //         'status_id' => 2,
        //         'start_at' => $date,
        //         'end_at' => date('Y-m-d H:i:00', strtotime($date . ' +5 minutes')),
        //     ]);
        // }
    }
}


