<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomerSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Customer Support',
            'email' => 'CustomerSupport@email.com',
            'phone' => '+6011-11111112',
            'password' => bcrypt('87654321')
        ]);

        $user->assignRole('CustomerSupport');
    }
}
