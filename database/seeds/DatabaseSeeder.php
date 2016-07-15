<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Add calls to Seeders here
        $this->call(RoleTableSeeder::class);
        $this->call(PrivacyRuleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
        $this->call(GroupTypesTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(GroupUserRoleTableSeeder::class);
        $this->call(GroupUserTableSeeder::class);
        Model::reguard();
    }
}
