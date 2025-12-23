<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //

    App\Models\Admin::query()->truncate();

    App\Models\Admin::create([
      'username' => 'admin',
      'password_text' => '1234',
      'password' => Hash::make('1234', ['rounds' => 12]),
      'level' => 1,
    ]);

    App\Models\Admin::create([
      'username' => 'operator',
      'password_text' => '1234',
      'password' => Hash::make('1234', ['rounds' => 12]),
      'level' => 2,
    ]);

    App\Models\AgentWallet::create([
      'admin_id' => 1,
      'balance' => 10000,
    ]);
    App\Models\AgentWallet::create([
      'admin_id' => 2,
      'balance' => 10000,
    ]);


    App\Models\AdminMenu::create([
      'name' => 'Dashboard',
      'code' => 'dashboard',
      'name_code' => 'dashboard',
      'path' => 'dashboard',
      'icon' => 'fas fa-desktop',
      'parent_id' => 0,
    ]);

    // App\Models\AdminMenu::create([
    //   'name' => 'Monitor Game',
    //   'code' => 'monitor',
    //   'name_code' => 'monitor',
    //   'path' => 'monitor',
    //   'icon' => 'fas fa-eye',
    //   'allow_level' => '1',
    //   'parent_id' => 0,
    // ]);

    $operator = App\Models\AdminMenu::create([
      'name' => 'Operator',
      'code' => 'operator',
      'name_code' => 'operator',
      'path' => '',
      'icon' => 'fas fa-user-secret',
      'allow_level' => '1',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'operator.list',
      'name_code' => 'list',
      'path' => 'operator/list',
      'parent_id' => $operator->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'operator.new',
      'name_code' => 'new',
      'path' => 'operator/new',
      'parent_id' => $operator->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Transaction List',
      'code' => 'operator.transaction_list',
      'name_code' => 'transaction_list',
      'path' => 'operator/transaction_list',
      'parent_id' => $operator->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Add Transaction',
      'code' => 'operator.transaction_add',
      'name_code' => 'transaction_add',
      'path' => 'operator/transaction_add',
      'parent_id' => $operator->id,
    ]);

    $users = App\Models\AdminMenu::create([
      'name' => 'Users',
      'code' => 'users',
      'name_code' => 'users',
      'path' => '',
      'icon' => 'fas fa-users',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'users.list',
      'name_code' => 'list',
      'path' => 'users/list',
      'parent_id' => $users->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'users.new',
      'name_code' => 'new',
      'path' => 'users/new',
      'parent_id' => $users->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Transaction List',
      'code' => 'users.transaction_list',
      'name_code' => 'transaction_list',
      'path' => 'users/transaction_list',
      'parent_id' => $users->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Add Transaction',
      'code' => 'users.transaction_add',
      'name_code' => 'transaction_add',
      'path' => 'users/transaction_add',
      'parent_id' => $users->id,
    ]);

    $wallet = App\Models\AdminMenu::create([
      'name' => 'Wallet',
      'code' => 'wallet',
      'name_code' => 'wallet',
      'path' => '',
      'icon' => 'fas fa-wallet',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'wallet.list',
      'name_code' => 'list',
      'path' => 'wallet/list',
      'parent_id' => $wallet->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Add Balance',
      'code' => 'wallet.add_balance',
      'name_code' => 'add_balance',
      'path' => 'wallet/add_balance',
      'parent_id' => $wallet->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Withdrawal',
      'code' => 'wallet.withdrawal',
      'name_code' => 'withdrawal',
      'path' => 'wallet/withdrawal',
      'parent_id' => $wallet->id,
    ]);


    // App\Models\AdminMenu::create([
    //   'name' => 'Withdrawal',
    //   'code' => 'wallet.withdrawal',
    //   'name_code' => 'withdrawal',
    //   'path' => 'wallet/withdrawal',
    //   'parent_id' => $wallet->id,
    // ]);

    // $withdrawal_request = App\Models\AdminMenu::create([
    //   'name' => 'Withdrawal Request',
    //   'code' => 'withdrawal_request',
    //   'name_code' => 'withdrawal_request',
    //   'path' => 'withdrawal_request',
    //   'icon' => 'fas fa-hand-holding-usd',
    //   'allow_level' => '1',
    //   'parent_id' => 0,
    // ]);


    $betList = App\Models\AdminMenu::create([
      'name' => 'Bet List',
      'code' => 'bets',
      'name_code' => 'bet_list',
      'path' => 'bets',
      'icon' => 'fas fa-coins',
      'parent_id' => 0,
    ]);

    $game = App\Models\AdminMenu::create([
      'name' => 'Game',
      'code' => 'game',
      'name_code' => 'game',
      'path' => '',
      'icon' => 'fas fa-gamepad',
      'allow_level' => '1',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Live Game List',
      'code' => 'game.live_game',
      'name_code' => 'live_game',
      'path' => 'game/live_game',
      'parent_id' => $game->id,
    ]);


    App\Models\AdminMenu::create([
      'name' => 'All List',
      'code' => 'game.list',
      'name_code' => 'list',
      'path' => 'game/list',
      'parent_id' => $game->id,
    ]);



    $channel = App\Models\AdminMenu::create([
      'name' => 'Game Channel',
      'code' => 'game_channel',
      'name_code' => 'game_channel',
      'path' => '',
      'allow_level' => '1',
      'icon' => 'fas fa-server',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'game_channel.list',
      'name_code' => 'list',
      'path' => 'game_channel/list',
      'parent_id' => $channel->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'game_channel.new',
      'name_code' => 'new',
      'path' => 'game_channel/new',
      'parent_id' => $channel->id,
    ]);

   

    $announcement = App\Models\AdminMenu::create([
      'name' => 'Announcement',
      'code' => 'announcement',
      'name_code' => 'announcement',
      'path' => '',
      'allow_level' => '1',
      'icon' => 'fas fa-bullhorn',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'announcement.list',
      'name_code' => 'list',
      'path' => 'announcement/list',
      'parent_id' => $announcement->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'announcement.new',
      'name_code' => 'new',
      'path' => 'announcement/new',
      'parent_id' => $announcement->id,
    ]);

    $banner = App\Models\AdminMenu::create([
      'name' => 'Banner',
      'code' => 'banner',
      'name_code' => 'banner',
      'path' => '',
      'allow_level' => '1',
      'icon' => 'fas fa-images',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'banner.list',
      'name_code' => 'list',
      'path' => 'banner/list',
      'parent_id' => $banner->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'banner.new',
      'name_code' => 'new',
      'path' => 'banner/new',
      'parent_id' => $banner->id,
    ]);

    $rank = App\Models\AdminMenu::create([
      'name' => 'Rank',
      'code' => 'rank',
      'name_code' => 'rank',
      'path' => '',
      'allow_level' => '1',
      'icon' => 'fas fa-gem',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'rank.list',
      'name_code' => 'list',
      'path' => 'rank/list',
      'parent_id' => $rank->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'rank.new',
      'name_code' => 'new',
      'path' => 'rank/new',
      'parent_id' => $rank->id,
    ]);

    $investor = App\Models\AdminMenu::create([
      'name' => 'Investor',
      'code' => 'investor',
      'name_code' => 'investor',
      'path' => '',
      'allow_level' => '1',
      'icon' => 'fas fa-hand-holding-usd',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'List',
      'code' => 'investor.list',
      'name_code' => 'list',
      'path' => 'investor/list',
      'parent_id' => $investor->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'New',
      'code' => 'investor.new',
      'name_code' => 'new',
      'path' => 'investor/new',
      'parent_id' => $investor->id,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Report',
      'code' => 'report',
      'name_code' => 'report',
      'path' => 'report',
      'allow_level' => '1',
      'icon' => 'fas fa-chart-line',
      'parent_id' => 0,
    ]);

    App\Models\AdminMenu::create([
      'name' => 'Setting',
      'code' => 'setting',
      'name_code' => 'setting',
      'path' => 'setting',
      'allow_level' => '1',
      'icon' => 'fas fa-cog',
      'parent_id' => 0,
    ]);




  }

}
