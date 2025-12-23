<?php

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(GameDiceSeeder::class);
        $this->call(Game5numSeeder::class);
        $this->call(Game10numSeeder::class);
        $this->call(GameJackpotSeeder::class);
        $this->call(BetSeeder::class);
        $this->call(AnnouncementSeeder::class);
    }
}
