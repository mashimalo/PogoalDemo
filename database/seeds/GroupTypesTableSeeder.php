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
            'group_type_name' => 'Idea Validation',
        ]);

        GroupType::create([
            'group_type_name' => 'MVP Feedback',
        ]);

        GroupType::create([
            'group_type_name' => 'Product Review',
        ]);

        GroupType::create([
            'group_type_name' => 'Geek Corner',
        ]);

        GroupType::create([
            'group_type_name' => 'Burnout Cave',
        ]);

	    GroupType::create([
		    'group_type_name' => 'Other Topics',
	    ]);
    }
}
