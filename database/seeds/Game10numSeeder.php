<?php

use App\Models\BetType;
use App\Models\BetTypeGroup;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\GameType;
use Illuminate\Database\Seeder;

class Game10numSeeder extends Seeder
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
      'name' => '10 Numbers Ball',
      'name_code' => 'game_10_number',
      'slug' => 'game_10_number',
      'runtime_start' => (date('H') == '00') ? '00:00' : date('H:00', strtotime('-1 hours')),
      'runtime_end' => '23:00',
      'status' => 1,
      'uuid' => Hashids::encode(rand(1, 9999999)),
      'thumbnail' => 'game_thumb_3.jpg',
    ]);

    // game category
    $gameChannel = GameChannel::create([
      'game_type_id' => $gameType->id,
      'name' => '3_minutes',
      'name_code' => '3_minutes',
      'slug' => '3_minutes',
      'uuid' => Hashids::encode(rand(1, 9999999)),
      'cover_filename' => 'channel_1.jpg',
      'runtime' => 3,
      'gracetime' => 30,
    ]);

    $gameChannel = GameChannel::create([
      'game_type_id' => $gameType->id,
      'name' => '5_minutes',
      'name_code' => '5_minutes',
      'slug' => '5_minutes',
      'uuid' => Hashids::encode(rand(1, 9999999)),
      'cover_filename' => 'channel_2.jpg',
      'runtime' => 5,
      'gracetime' => 30,
    ]);




    $group = [
      'total' => [
        'bet_ref' => 'total',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 22,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 23,
            'range_end' => 45,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 54,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 54,
          ]

        ]
      ],
      'first_ball' => [
        'bet_ref' => 'num_1',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'second_ball' => [
        'bet_ref' => 'num_2',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'third_ball' => [
        'bet_ref' => 'num_3',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'fourth_ball' => [
        'bet_ref' => 'num_4',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'fifth_ball' => [
        'bet_ref' => 'num_5',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'fifth_ball' => [
        'bet_ref' => 'num_5',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'sixth_ball' => [
        'bet_ref' => 'num_6',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'seventh_ball' => [
        'bet_ref' => 'num_7',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'eighth_ball' => [
        'bet_ref' => 'num_8',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'ninth_ball' => [
        'bet_ref' => 'num_9',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],
      'tenth_ball' => [
        'bet_ref' => 'num_10',
        'data' => [
          [
            'name' => 'small',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 0,
            'range_end' => 4,
          ],
          [
            'name' => 'big',
            'odd' => 1.70,
            'type' => 'direct_range',
            'range_start' => 5,
            'range_end' => 9,
          ],
          [
            'name' => 'odd',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'odd',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'name' => 'even',
            'odd' => 1.70,
            'type' => 'range',
            'range_type' => 'even',
            'range_start' => 0,
            'range_end' => 9,
          ],
          [
            'odd' => 9.96,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          ]
        ],
      ],

      '1_of_10' => [
        'bet_ref' => 'unique',
        'data' => [
          [
            'odd' => 2.06,
            'type' => 'number',
            'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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

        if ($g2['type'] == 'direct_range') {
          $range = [];
          for ($i = $g2['range_start']; $i <= $g2['range_end']; $i++) {
            $range[] = $i;
          }
          $rangeStr = implode(",", $range);
          BetType::create([
            'bet_type_group_id' => $betTypeGroup->id,
            'name' => ucfirst(str_replace('_', ' ', $g2['name'])),
            'name_code' => $g2['name'],
            'value' => $rangeStr,
            'odd' => $g2['odd'],
            'type' => 'range',
            'final_no' => $final_no
          ]);
        }

        if ($g2['type'] == 'range') {
          $range = [];

          for ($i = $g2['range_start']; $i <= $g2['range_end']; $i++) {
            if ($g2['range_type'] == 'even') {
              if ($i % 2 == 0) {
                $range[] = $i;
              }
            }
            if ($g2['range_type'] == 'odd') {
              if ($i % 2 != 0) {
                $range[] = $i;
              }
            }
          }
          $rangeStr = implode(",", $range);
          BetType::create([
            'bet_type_group_id' => $betTypeGroup->id,
            'name' => ucfirst(str_replace('_', ' ', $g2['name'])),
            'name_code' => $g2['name'],
            'value' => $rangeStr,
            'odd' => $g2['odd'],
            'type' => 'range',
            'final_no' => $final_no
          ]);
        }

        if ($g2['type'] == 'number') {
          foreach ($g2['numbers'] as $n) {
            BetType::create([
              'bet_type_group_id' => $betTypeGroup->id,
              'name' => $n,
              'name_code' => $n,
              'value' => $n,
              'odd' => $g2['odd'],
              'type' => 'number'
            ]);
          }
        }
      }
    }
  }
}
