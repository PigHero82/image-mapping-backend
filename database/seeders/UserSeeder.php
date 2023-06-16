<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name'      => $faker->name,
                'email'     => $faker->email,
                'password'  => bcrypt('12345678')
            ]);

            if ($i == 1) {
                $user->assignRole(['admin', 'user']);
            } else {
                $user->assignRole('user');
            }
        };
    }
}
