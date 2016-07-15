<?php

use Illuminate\Database\Seeder;
use App\Models\GroupUserRole;

class GroupUserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupUserRole::create([
            'title' => 'Founder',
        ]);

        GroupUserRole::create([
            'title' => 'Coordinator',
        ]);

        GroupUserRole::create([
            'title' => 'Member',
        ]);
    }
}
