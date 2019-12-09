<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email' => 'matt@tighten.co',
            'password' => bcrypt('password'),
        ]);

        Artisan::call('seedsomedata');
        // $this->call(UsersTableSeeder::class);
    }
}
