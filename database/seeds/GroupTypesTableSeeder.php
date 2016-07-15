<?php

use Illuminate\Database\Seeder;
use App\Models\GroupType;

class GroupTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupType::create([
            'group_type_name' => 'Sport',
        ]);

        GroupType::create([
            'group_type_name' => 'Music',
        ]);

        GroupType::create([
            'group_type_name' => 'Close Friends',
        ]);

        GroupType::create([
            'group_type_name' => 'Project',
        ]);

        GroupType::create([
            'group_type_name' => 'Event',
        ]);

	    GroupType::create([
		    'group_type_name' => 'Startup',
	    ]);

	    GroupType::create([
		    'group_type_name' => 'Education',
	    ]);

        GroupType::create([
            'group_type_name' => 'Pet',
        ]);

        GroupType::create([
            'group_type_name' => 'Creative',
        ]);

        GroupType::create([
            'group_type_name' => 'Agency',
        ]);

        GroupType::create([
            'group_type_name' => 'Service',
        ]);

        GroupType::create([
            'group_type_name' => 'Service',
        ]);

        GroupType::create([
            'group_type_name' => 'Travel',
        ]);

        GroupType::create([
            'group_type_name' => 'Organization',
        ]);

        GroupType::create([
            'group_type_name' => 'Company',
        ]);

        GroupType::create([
            'group_type_name' => 'Neighbors',
        ]);

        GroupType::create([
            'group_type_name' => 'Support',
        ]);

        GroupType::create([
            'group_type_name' => 'Family',
        ]);

        GroupType::create([
            'group_type_name' => 'Team',
        ]);

        GroupType::create([
            'group_type_name' => 'Club',
        ]);

        GroupType::create([
            'group_type_name' => 'Other',
        ]);

    }
}
