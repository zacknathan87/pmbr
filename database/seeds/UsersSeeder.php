<?php

use App\Models\UserWallet;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
    $faker = Faker::create();


    $user = User::create([
      'name' => 'test',
      'username' => 'test',
      'password' => '$2y$10$9aLx/gqGEs50JrHOwCuc.O3Xj16cHanKpTJjtHVHsWpZjJX6A5DFO',
      'password_text' => '1234',
      'created_by' => 1,
      'created_at' => date("Y-m-d H:i:s"),
    ]);

    UserWallet::create([
      'user_id' => $user->id,
      'wallet_type' => 1,
      'balance' => 10000,
    ]);

    $total_user = 10;

    for ($i = 1; $i <= $total_user; $i++) {
      $user = App\User::create([
        'username' => 'test'.$i,
        'name' => $faker->firstName,
        'contact' => $faker->e164PhoneNumber,
        'password' => '$2y$10$9aLx/gqGEs50JrHOwCuc.O3Xj16cHanKpTJjtHVHsWpZjJX6A5DFO',
        'password_text' => '1234',
        'created_by' => 1,
        'parent_id' => 1
      ]);

      UserWallet::create([
        'user_id' => $user->id,
        'wallet_type' => 1,
        'balance' => 10000,
      ]);

    }
  }
}
