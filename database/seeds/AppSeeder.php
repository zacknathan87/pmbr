<?php

use App\Models\Banner;
use App\Models\BetType;
use App\Models\Country;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\Rank;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Vinkla\Hashids\Facades\Hashids;

class AppSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
  


    Country::create([
      'name' => 'None',
      'currency' => '$',
    ]);

    Country::create([
      'name' => 'Malaysia',
      'currency' => 'RM',
    ]);

    Country::create([
      'name' => 'Singapore',
      'currency' => 'SGD',
    ]);

    Country::create([
      'name' => 'China',
      'currency' => '¥',
    ]);

    Country::create([
      'name' => 'Australia',
      'currency' => '$',
    ]);

    Country::create([
      'name' => 'Thailand',
      'currency' => 'THB',
    ]);

    Country::create([
      'name' => 'Brunei',
      'currency' => 'BND',
    ]);

    Country::create([
      'name' => 'New Zealand',
      'currency' => '$',
    ]);

    Country::create([
      'name' => 'Cambodia',
      'currency' => '$',
    ]);

    Country::create([
      'name' => 'Philipines',
      'currency' => 'PHP',
    ]);

    Country::create([
      'name' => 'Hong Kong',
      'currency' => '$',
    ]);


    Country::create([
      'name' => 'Macau',
      'currency' => '$',
    ]);


    // transaction type seeder

    App\Models\TransactionType::create([ // 1
      'name' => 'Deposit',
      'name_code' => 'deposit',
      'type' => 'debit',
    ]);

    App\Models\TransactionType::create([ // 2
      'name' => 'Withdrawal',
      'name_code' => 'withdrawal',
      'type' => 'credit',
    ]);

    App\Models\TransactionType::create([ // 3
      'name' => 'Bet',
      'name_code' => 'bet',
      'type' => 'credit',
    ]);

    App\Models\TransactionType::create([ // 4
      'name' => 'Win',
      'name_code' => 'win',
      'type' => 'debit',
    ]);

    App\Models\TransactionType::create([ // 5
      'name' => 'Topup User',
      'name_code' => 'topup_user',
      'type' => 'credit',
    ]);

    App\Models\TransactionType::create([ // 6
      'name' => 'Withdrawal Refund',
      'name_code' => 'withdrawal_refund',
      'type' => 'debit',
    ]);

    App\Models\TransactionType::create([ // 7
      'name' => 'Agent Deposit',
      'name_code' => 'Agent deposit',
      'type' => 'debit',
    ]);

    App\Models\TransactionType::create([ // 8
      'name' => 'Agent Withdrawal',
      'name_code' => 'Agent withdrawal',
      'type' => 'credit',
    ]);

    App\Models\TransactionType::create([ // 9
      'name' => 'Convert To',
      'name_code' => 'convert',
      'type' => 'credit',
    ]);

    App\Models\TransactionType::create([ // 10
      'name' => 'Convert From',
      'name_code' => 'convert',
      'type' => 'debit',
    ]);

    App\Models\TransactionType::create([ // 11
      'name' => 'Debit',
      'name_code' => 'Debit',
      'type' => 'debit',
    ]);

    App\Models\TransactionType::create([ // 12
      'name' => 'Credit',
      'name_code' => 'Credit',
      'type' => 'credit',
    ]);



    Banner::create([
      'lang' => 'en',
      'filename' => 'banner.mp4',
      'type' => 'video'
    ]);

    $vip = [
      [
        'level_name' => 'Bronze',
        'amount' => 0,
        'bonus' => 0,
        'skip_level_bonus' => 0
      ],
      [
        'level_name' => 'Silver 1',
        'amount' => 30000,
        'bonus' => 3888,
        'skip_level_bonus' => 5888
      ],
      [
        'level_name' => 'Silver 2',
        'amount' => 50000,
        'bonus' => 8888,
        'skip_level_bonus' => 18888
      ],
      [
        'level_name' => 'Silver 3',
        'amount' => 100000,
        'bonus' => 28888,
        'skip_level_bonus' => 38888
      ],
      [
        'level_name' => 'Gold 1',
        'amount' => 200000,
        'bonus' => 38888,
        'skip_level_bonus' => 58888
      ],
      [
        'level_name' => 'Gold 2',
        'amount' => 300000,
        'bonus' => 88888,
        'skip_level_bonus' => 108888
      ],
      [
        'level_name' => 'Gold 3',
        'amount' => 500000,
        'bonus' => 188888,
        'skip_level_bonus' => 208888
      ],
      [
        'level_name' => 'Platinum',
        'amount' => 1000000,
        'bonus' => 288888,
        'skip_level_bonus' => 388888
      ],
      [
        'level_name' => 'Diamond',
        'amount' => 5000000,
        'bonus' => 588888,
        'skip_level_bonus' => 1088890
      ],
    ];

    foreach ($vip as $k => $v) {
      Rank::create([
        'name' => 'VIP' . ($k + 1),
        'level_name' => $v['level_name'],
        'amount' => $v['amount'],
        'bonus' => $v['bonus'],
        'skip_level_bonus' => $v['skip_level_bonus']
      ]);
    }
  }
}
