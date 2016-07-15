<?php

namespace App\Http\Utilities;

Class GroupCategory {

	protected static $GroupCategories = [
		'Sport'         => '1',
		'Music'         => '2',
		'Close Friends' => '3',
		'Project'       => '4',
		'Event'         => '5',
		'Startup'       => '6',
		'Education'     => '7',
		'Pet'           => '8',
		'Creative'      => '9',
		'Agency'        => '10',
		'Service'       => '11',
		'Gourmet'       => '12',
		'Travel'        => '13',
		'Organization'  => '14',
		'Company'       => '15',
		'Neighbors'     => '16',
		'Support'       => '17',
		'Family'        => '18',
		'Team'          => '19',
		'Club'          => '20',
		'Custom'        => '21'
	];

	public static function all() {
		return static::$GroupCategories;
	}

}