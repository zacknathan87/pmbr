<?php

use App\Models\BetType;
use App\Models\BetTypeGroup;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\GameType;
use Illuminate\Database\Seeder;

class GameDiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // game type
        $gameType = GameType::create([
            'name' => 'Dice',
            'name_code' => 'game_dice',
            'slug' => 'game_dice',
            'runtime_start' =>  '12:00',
            'runtime_end' => '00:00',
            'status' => 1,
            'uuid' => Hashids::encode(rand(1, 9999999)),
            'thumbnail' => 'game_thumb_1.jpg',
        ]);


        // game category
        $gameChannel = GameChannel::create([
            'game_type_id' => $gameType->id,
            'name' => '5_minutes',
            'name_code' => '5_minutes',
            'slug' => '5_minutes',
            'uuid' => Hashids::encode(rand(1, 9999999)),
            'cover_filename' => 'channel_1.jpg',
            'runtime' => 5,
            'gracetime' => 30,
        ]);

        // Bet type Dice
        $bet_type = [
            'big' => [
                'value' => '14,15,16,17,18,19,20,21,22,23,24,25,26,27',
                'odd' => 1.96,
            ],
            'small' => [
                'value' => '0,1,2,3,4,5,6,7,8,9,10,11,12,13',
                'odd' => 1.96,
            ],
            'odd' => [
                'value' => '1,3,5,7,9,11,13,15,17,19,21,23,25,27',
                'odd' => 1.96,
            ],
            'even' => [
                'value' => '0,2,4,6,8,10,12,14,16,18,20,22,24,26',
                'odd' => 1.96,
            ],
            'big_odd' => [
                'value' => '15,17,19,21,23,25,27',
                'odd' => 1.96,
            ],
            'big_even' => [
                'value' => '14,16,18,20,22,24,26',
                'odd' => 1.96,
            ],
            'small_odd' => [
                'value' => '1,3,5,7,9,11,13',
                'odd' => 1.96,
            ],
            'small_even' => [
                'value' => '0,2,4,6,8,10,12',
                'odd' => 1.96,
            ],
            'xbig' => [
                'value' => '22,23,24,25,26,27',
                'odd' => 1.96,
            ],
            'xsmall' => [
                'value' =>  '0,1,2,3,4,5',
                'odd' => 1.96,
            ]
        ];

        $betTypeGroup = BetTypeGroup::create([
            'game_type_id' => $gameType->id,
            'name' => 'default',
            'name_code' => 'default',
            'bet_ref' => 'total',
        ]);

        foreach ($bet_type as $b => $v) {
            BetType::create([
                'bet_type_group_id' => $betTypeGroup->id,
                'name' => ucfirst(str_replace('_', ' ', $b)),
                'name_code' => $b,
                'value' => $v['value'],
                'odd' => $v['odd'],
                'type' => 'range',
                'final_no' => 1,
            ]);
        }

        for ($i = 0; $i <= 27; $i++) {
            BetType::create([
                'bet_type_group_id' => $betTypeGroup->id,
                'name' => $i,
                'name_code' => $i,
                'value' => $i,
                'odd' => 1.90,
                'type' => 'number',
                'final_no' => 1,
            ]);
        }
    }
}
