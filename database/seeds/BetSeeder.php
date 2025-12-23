<?php

use App\Http\Controllers\WorkerController;
use App\Models\BetType;
use App\Models\Game;
use App\User;
use Illuminate\Database\Seeder;

class BetSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //

    $users = User::all();

    $games = Game::where('status_id', 2)->get();

    $bet_type = BetType::all();
    $bet_type_length = count($bet_type) - 1;

    $worker = new WorkerController();

    if(!$games->isEmpty()) {

      foreach ($users as $u) {

        $betCount = mt_rand(30, 100);
  
        for ($i = 0; $i < $betCount; $i++) {
  
          $amount = mt_rand(1, 10) * 10;
          $game = $games[mt_rand(0, count($games) - 1)];
  
          $worker->placeBet($u->id, $game->id, $amount, $bet_type[rand(0, $bet_type_length)]->id);
        }
      }
    }
  }
}
