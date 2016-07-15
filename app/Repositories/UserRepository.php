<?php

namespace App\Repositories;

use App\Models\User, App\Models\Role, App\Models\Profile, App\Models\Gender;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{

	/**
	 * The Role instance.
	 *
	 * @var \App\Models\Role
	 */
	protected $role;

	/**
	 * Create a new UserRepository instance, this repository include the profile,
	 * since when user register, the profile will be crated at the same time
	 *
   	 * @param  \App\Models\User $user
	 * @param  \App\Models\Role $role
	 * @param  \App\Models\Profile $profile
	 * @param  \App\Models\Gender $gender
	 * @return void
	 */

	public function __construct(
		User $user, 
		Role $role,
		Profile $profile,
		Gender $gender)
	{
		$this->model = $user;
		$this->role = $role;
		$this->profile = $profile;
		$this->gender = $gender;
	}

	/**
	 * Save the User.
 	*
 	* @param  App\Models\User $user
 	* @param  Array  $inputs
 	* @return void
	* using db transaction, if transaction fail roll back everything.
 	*/
	private function save($user, $inputs)
	{
		DB::beginTransaction();
		$user->email = $inputs['email'];

		if(isset($inputs['role'])) {
			$user->role_id = $inputs['role'];
		} else {
			$role_user = $this->role->where('slug', 'user')->first();
			$user->role_id = $role_user->id;
		}

		$user->save();
		$profile = new Profile;
		$profile->nickname = $inputs['nickname'];

		try{
			$user->profile()->save($profile);
		}
		catch(\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
		DB::commit();


	}

	/**
	 * Get users collection paginate.
	 *
	 * @param  int  $n
	 * @param  string  $role
	 * @return Illuminate\Support\Collection
	 */
	public function index($n, $role)
	{
		if($role != 'total')
		{
			return $this->model
			->with('role')
			->whereHas('role', function($q) use($role) {
				$q->whereSlug($role);
			})
			->latest()
			->paginate($n);			
		}

		return $this->model
		->with('role')
		->latest()
		->paginate($n);
	}

	/**
	 * Count the users.
	 *
	 * @param  string  $role
	 * @return int
	 */
	public function count($role = null)
	{
		if($role)
		{
			return $this->model
			->whereHas('role', function($q) use($role) {
				$q->whereSlug($role);
			})->count();			
		}

		return $this->model->count();
	}

	/**
	 * Count the users.
	 *
	 * @param  string  $role
	 * @return int
	 */
	public function counts()
	{
		$counts = [
			'admin' => $this->count('admin'),
			'user' => $this->count('user')
		];

		$counts['total'] = array_sum($counts);

		return $counts;
	}

	/**
	 * Create a user.
	 *
	 * @param  array  $inputs
	 * @param  int    $confirmation_code
	 * @return App\Models\User 
	 */
	public function store($inputs, $confirmation_code = null)
	{
		$user = new $this->model;
//		$user = new User();

		$user->password = bcrypt($inputs['password']);

		if($confirmation_code) {
			$user->confirmation_code = $confirmation_code;
		} else {
			$user->confirmed = true;
		}
		$this->save($user, $inputs);

		return $user;
	}

	/**
	 * Update a user.
	 *
	 * @param  array  $inputs
	 * @param  App\Models\User $user
	 * @return void
	 */
	public function update($inputs, $user)
	{		
		$user->confirmed = isset($inputs['confirmed']);

		$this->save($user, $inputs);
	}

	/**
	 * Get role of authenticated user.
	 *
	 * @return string
	 */
	public function getrole()
	{
		return session('role');
	}

	/**
	 * Valid user.
	 *
     * @param  bool  $valid
     * @param  int   $id
	 * @return void
	 */
	public function valid($valid, $id)
	{
		$user = $this->getById($id);

		$user->valid = $valid == 'true';

		$user->save();
	}

	/**
	 * Destroy a user.
	 *
	 * @param  App\Models\User $user
	 * @return void
	 */
	public function destroyUser(User $user)
	{
		$user->comments()->delete();
		
		$user->delete();
	}

	/**
	 * Confirm a user.
	 *
	 * @param  string  $confirmation_code
	 * @return App\Models\User
	 */
	public function confirm($confirmation_code)
	{
		$user = $this->model->whereConfirmationCode($confirmation_code)->firstOrFail();

		$user->confirmed = true;
		$user->confirmation_code = null;
		$user->save();
	}

}
