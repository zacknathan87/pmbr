<?php

use App\Models\BetType;
use App\Models\BetTypeGroup;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\GameType;
use Illuminate\Database\Seeder;

class GameJackpotSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //

    // game type
    $gameType = GameType::create([
      'name' => 'Jackpot',
      'name_code' => 'game_jackpot',
      'slug' => 'game_jackpot',
      'runtime_start' => (date('H') == '00') ? '00:00' : date('H:00', strtotime('-1 hours')),
      'runtime_end' => '23:00',
      'status' => 1,
      'uuid' => Hashids::encode(rand(1, 9999999)),
      'thumbnail' => 'game_thumb_4.jpg',
    ]);

    // game category
    $gameChannel = GameChannel::create([
      'game_type_id' => $gameType->id,
      'name' => '15_minutes',
      'name_code' => '15_minutes',
      'slug' => '15_minutes',
      'uuid' => Hashids::encode(rand(1, 9999999)),
      'cover_filename' => 'channel_1.jpg',
      'runtime' => 15,
      'gracetime' => 30,
    ]);



    $group = [
      'first_ball' => [
        'bet_ref' => 'num_1',
        'data' => [
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'second_ball' => [
        'bet_ref' => 'num_2',
        'data' => [
         
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'third_ball' => [
        'bet_ref' => 'num_3',
        'data' => [
         
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'fourth_ball' => [
        'bet_ref' => 'num_4',
        'data' => [
         
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'fifth_ball' => [
        'bet_ref' => 'num_5',
        'data' => [
         
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'sixth_ball' => [
        'bet_ref' => 'num_6',
        'data' => [
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'seventh_ball' => [
        'bet_ref' => 'num_7',
        'data' => [
          [
            'odd' => 9.96,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],
      'jackpot' => [
        'bet_ref' => 'total',
        'data' => [
          [
            'odd' => 54,
            'type' => 'number_range',
            'range_start' => 0,
            'range_end' => 54,
          ]
        ],
      ],

    ];

    foreach ($group as $k => $g) {
      $betTypeGroup = BetTypeGroup::create([
        'game_type_id' => $gameType->id,
        'name' => ucfirst(str_replace('_', ' ', $k)),
        'name_code' => $k,
        'bet_ref' => $g['bet_ref'],
      ]);

      foreach ($g['data'] as $g2) {

        $final_no = ($g['bet_ref'] == 'total') ? 1 : 0;
  
        if ($g2['type'] == 'number_range') {
          for ($i = $g2['range_start']; $i <= $g2['range_end']; $i++) {
            BetType::create([
              'bet_type_group_id' => $betTypeGroup->id,
              'name' => $i,
              'name_code' => $i,
              'value' => $i,
              'odd' => $g2['odd'],
              'type' => 'number'
            ]);
          }
        }
      }
    }
  }
}
