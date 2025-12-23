<?php

namespace App\Http\Controllers;

use App\Events\BetTransactionAdded;
use App\Events\GameStatusChanged;
use App\Models\Bet;
use App\Models\BetTransaction;
use App\Models\BetType;
use App\Models\BetTypeGroup;
use App\Models\Game;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\GameType;
use App\Services\Game10numService;
use App\Services\Game5numService;
use App\Services\GameDiceService;
use App\Services\GameJackpotService;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

use Auth;
use Exception;

class CronController extends Controller
{

  private $gameDiceService;
  private $game5numService;
  private $game10numService;
  private $gameJackpotService;

  public function __construct()
  {
    $this->gameDiceService = resolve(GameDiceService::class);
    $this->game5numService = resolve(Game5numService::class);
    $this->game10numService = resolve(Game10numService::class);
    $this->gameJackpotService = resolve(GameJackpotService::class);
  }

  public function testGame()
  {

    $game = Game::where('game_type_id', 2)->first();

    $game->load('betTypeGroup');
    $game->load('gameType');
    $game->load('gameChannel');

    dd($game->toArray());
  }

  public function checkGame()
  {


    $startDate = date('Y-m-d H:i:s', strtotime('now -60 minutes'));
    $endDate = date('Y-m-d H:i:s', strtotime('now  +60 minutes'));

    $games = Game::whereIn('status_id', [1, 2, 3])
      ->where('start_at', '>=', $startDate)
      ->orderBy('id', 'asc')->get();

    if (!$games->isEmpty()) {
      echo 'Started: ' . date('H:i:s d-m-Y') . '<br>';
      $worker = new WorkerController;
      $slept = false;

      foreach ($games as $g) {

        $g->load('betTypeGroup');
        $g->load('gameType');
        $g->load('gameChannel');

        if ($g->status_id == 1) {
          if (strtotime($g->start_at) <= strtotime('now')) { // start new game
            $g->status_id = 2;
            $g->save();

            try {
              event(new GameStatusChanged($g));
            } catch (Exception $e) { }
          }
        } else if ($g->status_id == 2) {
          $current_time = new \DateTime('now');
          $end_at = new \DateTime(date('d-m-Y H:i:s', strtotime($g->end_at)));
          $diff = $end_at->getTimestamp() - $current_time->getTimestamp();

          if ($diff <= $g->gameChannel->gracetime) {
            $g->status_id = 3;
            $g->save();
            try {
              event(new GameStatusChanged($g));
            } catch (Exception $e) { }
          } else {
            $ceilDiff = ceil($diff / 60);
            if ($ceilDiff == 1) {
              if (!$slept) {
                sleep(30);
                $slept = true;
              }
              $g->status_id = 3;
              $g->save();
              try {
                event(new GameStatusChanged($g));
              } catch (Exception $e) { }
            }
          }
        } else  if ($g->status_id == 3) {
          if (strtotime($g->end_at) <= strtotime('now')) {

            // set winning number
            if (empty($g->result_no)) {
              if ($g->game_type_id == 1) { // dice game
                $this->gameDiceService->autoSetWinning($g->id);
              }
              if ($g->game_type_id == 2) { // 5 game
                $this->game5numService->autoSetWinning($g->id);
              }
              if ($g->game_type_id == 3) { // 10 game
                $this->game10numService->autoSetWinning($g->id);
              }
              if ($g->game_type_id == 4) { // 10 game
                $this->gameJackpotService->autoSetWinning($g->id);
              }
            }

            // check result
            if ($g->game_type_id == 1) { // dice game
              $this->gameDiceService->checkResult($g->id);
            }
            if ($g->game_type_id == 2) { // 5 game
              $this->game5numService->checkResult($g->id);
            }
            if ($g->game_type_id == 3) { // 10 game
              $this->game10numService->checkResult($g->id);
            }
            if ($g->game_type_id == 4) { // 10 game
              $this->gameJackpotService->checkResult($g->id);
            }

            // change status
            $g->status_id = 4;
            $g->save();
          }
        }
      }
      echo 'Ended: ' . date('H:i:s d-M-Y') . '<br>';
    }
  }

  public function createGame($param = null)
  {
    echo "ok";

    $game_type = GameType::where('status', 1)->where('is_active', 1)->get();

    if ($game_type) {

      if (isset($param)) {
        $date = date('Y-m-d', strtotime($param));
      } else {
        $date = date('Y-m-d');
      }

      foreach ($game_type as $g) {
        $todayGame = Game::where('game_type_id', $g->id)->whereDate('start_at', $date)->get();

        $startTime = strtotime($g->runtime_start);
        if ($g->runtime_end == '00:00') {
          $endTime = strtotime($g->runtime_end . ' + 1 day');
        } else {
          $endTime = strtotime($g->runtime_end);
        }


        if ($todayGame->isEmpty()) { // if empty create game

          $game_channel = GameChannel::where('game_type_id', $g->id)->where('is_active', 1)->get();


          foreach ($game_channel as $gc) {

            $runtimeInSec = $gc->runtime * 60;

            for ($i = $startTime; $i < $endTime; $i += $runtimeInSec) {
              Game::create([
                'game_type_id' => $g->id,
                'game_channel_id' => $gc->id,
                'status_id' => 1,
                'start_at' => date('Y-m-d H:i:0', $i),
                'end_at' => date('Y-m-d H:i:0', strtotime(date('Y-m-d H:i:0', $i) . ' +' . $gc->runtime . ' minutes')),
              ]);
            }
          }
        }
      }
    }
  }

  public function robotBet()
  {
    $games = Game::where('status_id', 2)->get();

    if ($games) {
      $faker = Faker::create();
      $worker = new WorkerController();

      foreach ($games as $g) {

        if (rand(0, 1) == 1) {
          $amount = rand(10, 1000);

          sleep(rand(1, 4));
          $currentGameStatus = Game::where('id', $g->id)->first();
          if ($currentGameStatus->status_id == 2) {

            $betTypeGroup = BetTypeGroup::where('game_type_id', $g->game_type_id)->first();
            $betTypes =  BetType::where('bet_type_group_id', $betTypeGroup->id)->where('is_active', 1)->get()->random(rand(1, 3))->pluck('id')->toArray();

            $betTypesIds = implode(',', (array) $betTypes);
            $bet = $worker->placeFakeBet($faker->userName, $g->id, $amount, $betTypesIds);

            try {
              event(new BetTransactionAdded($bet));
            } catch (Exception $e) { }
          }
        }
      }
    }
  }

  public function deleteRobotBet()
  {
    $bets = Bet::where('is_fake', 1)->get();
    foreach ($bets as $b) {
      $b->delete();
    }

    $betsTranscation = BetTransaction::where('is_fake', 1)->get();
    foreach ($betsTranscation as $b) {
      $b->delete();
    }
  }

  public function seedBet()
  {
    $games = Game::where('status_id', 2)->get();

    if ($games) {
      $worker = new WorkerController();

      foreach ($games as $g) {

        if ($g->game_type_id == 1) {
          $betTypeGroup = BetTypeGroup::where('game_type_id', $g->game_type_id)->first();
          $betTypes =  BetType::where('bet_type_group_id', $betTypeGroup->id)->where('is_active', 1)->get()->random(rand(1, 5))->pluck('id')->toArray();
          $betTypesIds = implode(',', (array) $betTypes);

          $amount = rand(1, 9) * 10;

          $bet = $worker->placeBet(1, $g->id, $amount, $betTypesIds);
        }

        if (in_array($g->game_type_id, [2, 3])) {

          for ($i = 0; $i < rand(3, 10); $i++) {
            $betTypeGroup = BetTypeGroup::where('game_type_id', $g->game_type_id)->get()->random(1)->first();


            $betTypes =  BetType::where('bet_type_group_id', $betTypeGroup->id)->where('is_active', 1)->get()->random(rand(1, 5))->pluck('id')->toArray();

            $betTypesIds = implode(',', (array) $betTypes);

            $amount = rand(1, 100);
            $bet = $worker->placeBet(1, $g->id, $amount, $betTypesIds, $betTypeGroup->bet_ref);
          }
        }
      }
    }
  }
}
