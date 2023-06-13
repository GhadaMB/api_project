<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class defaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678'),
                'email_verified_at'=>'2023-06-13 11:15:53',
                'role' => '1',
            ]
        );
    }
}
