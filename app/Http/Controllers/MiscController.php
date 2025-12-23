<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Bet;
use App\Models\BetTransaction;
use App\Models\BetType;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\GameType;
use App\Models\Investor;
use App\Models\Rank;
use App\User;
use Symfony\Component\HttpFoundation\Request;

class MiscController extends Controller
{
  public function __construct()
  { }

  public function getRss()
  {


    $contentEn = file_get_contents('https://www.investing.com/rss/news.rss');
    $contentCn = file_get_contents('https://cn.investing.com/rss/news.rss');

    $xEn = new \SimpleXmlElement($contentEn);
    $xCh = new \SimpleXmlElement($contentCn);

    $data = [];
    $newsEn = [];
    $newsCn = [];

    if (isset($xEn->channel)) {

      $channel = (array) $xEn->channel;

      $newsEn = array_slice($channel['item'], 0, 5, true);

      foreach ($newsEn as $i => $n) {
        $newsEn[$i] = (array) $n;
        $newsEn[$i]['image'] = (string) $n->enclosure->attributes()['url'];
      }
    }

    if (isset($xCh->channel)) {

      $channel = (array) $xCh->channel;

      $newsCn = array_slice($channel['item'], 0, 5, true);

      foreach ($newsCn as $i => $n) {
        $newsCn[$i] = (array) $n;
        $newsCn[$i]['image'] = (string) $n->enclosure->attributes()['url'];
      }
    }

    $data['en'] = $newsEn;
    $data['zh'] = $newsCn;


    return response()->json(['status' => 1, 'data' => $data], 200);
  }

  public function referrer($username = '')
  {

    if ($username) {

      $resources = User::where('username', $username)->first();

      if ($resources) {
        return response()->json(['status' => 1, 'data' => $resources], 200);
      } else {
        return response()->json(['status' => 0, 'error' => 'Invalid referrer'], 200);
      }
    } else {
      return response()->json(['status' => 0, 'error' => 'Invalid referrer'], 200);
    }
  }

  public function ranks()
  {
    try {
      $resources = Rank::where('is_active', 1)->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function investors()
  {
    try {
      $resources = Investor::where('is_active', 1)->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function gameType()
  {
    try {
      $resources = GameType::where('is_active', 1)->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }
  public function gameChannel($gameTypeId = null)
  {

    if ($gameTypeId) {
      if (is_numeric($gameTypeId)) {
        $gameType = GameType::where('id', $gameTypeId)->first();
      } else {
        $gameType = GameType::where('uuid', $gameTypeId)->first();
      }

      if ($gameType) {
        try {
          $resources = GameChannel::where('game_type_id', $gameType->id)->with('gameType')->where('is_active', 1)->get();

          return response()->json(['data' => $resources], 200);
        } catch (\Exception $e) {
          return response()->json(['error' => $e->getMessage()]);
        }
      }
    } else {
      $resources = GameChannel::where('is_active', 1)->with('gameType')->get();

      return response()->json(['data' => $resources], 200);
    }

    return response()->json(['error' => 'Invalid Game Type']);
  }


  public function betType($type = 'range')
  {
    try {
      $resources = BetType::where('type', $type)->where('is_active', 1)->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function announcement($locale = 'en')
  {
    try {

      $resources = Announcement::where('lang', $locale)->where('is_active', 1)->orderBy('id', 'desc')->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function news($locale = 'en')
  {
    try {

      $resources = Announcement::where('lang', $locale)->where('is_active', 1)->orderBy('id', 'desc')->limit(1)->first();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function banner($locale = 'en')
  {
    try {

      $resources = Banner::where('lang', $locale)->where('is_active', 1)->orderBy('id', 'desc')->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function latestBet()
  {
    try {

      $resources = BetTransaction::orderBy('id', 'desc')->limit(10)->with('user')->orderBy('id', 'desc')->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function latestWinner()
  {
    try {

      $resources = Bet::where('is_win', 1)->orderBy('id', 'desc')->limit(10)->with('user')->orderBy('id', 'desc')->get();

      return response()->json(['data' => $resources], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]);
    }
  }
}
