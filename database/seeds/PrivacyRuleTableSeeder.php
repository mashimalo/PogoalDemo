<?php

use Illuminate\Database\Seeder;
use App\Models\PrivacyRule;

class PrivacyRuleTableSeeder extends Seeder {

	public function run()
	{

		PrivacyRule::create([
			'rule_description' => 'Public',
		]);

		PrivacyRule::create([
			'rule_description' => 'Private',
		]);
	}

}
