<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        // $this->call(RolesAndPermissionsSeeder::class);


        $user = User::create([
            'name'          => 'Admin',
            'email'         => 'admin@gmail.com',
            'password'      => bcrypt('12345678'),
            'created_at'    => date("Y-m-d H:i:s"),
        ]);
        $user->assignRole('Super Admin');
    }
}
