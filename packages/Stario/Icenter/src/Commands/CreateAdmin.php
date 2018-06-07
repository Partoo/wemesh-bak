<?php

namespace Stario\Icenter\Commands;

use App\Scopes\StatusScope;
use Icenter\Models\Profile;
use Icenter\Models\User;
use Identicon\Identicon;
use Illuminate\Console\Command;
use RuntimeException;
use Validator;

class CreateAdmin extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'icenter:admin
                            {user? : The ID of the user}
                            {--delete : Whether the user should be deleted}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create an admin or delete a user for Icenter.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$userId = $this->argument('user');
		$option = $this->option('delete');

		if ($userId && !$option) {
			$user = User::findOrFail($userId);

			$this->info('username: ' . $user->name . ', mobile: ' . $user->mobile);

			return;
		} else if ($userId && $option) {
			if (User::withoutGlobalScope(StatusScope::class)->find($userId)->delete()) {
				$this->info('Deleted the user success!');
			} else {
				$this->error('Sorry, the system had made a mistake! Please check the system.');
			}
			return;
		}

		$name = $this->ask('What is your name?');
		$mobile = $this->ask('What is your mobile?');
		$password = $this->secret('What is the password?(min: 6 character)');

		$data = [
			'name' => $name,
			'mobile' => $mobile,
			'password' => $password,
		];

		if ($this->register($data)) {
			$this->info('Register a new admin success! You can login in the dashboard by the account.');
		} else {
			$this->error('Something went wrong!');
		}
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function register($data) {
		$validator = Validator::make($data, [
			'name' => 'required|max:255',
			'mobile' => 'required|max:255|unique:users',
			'password' => 'required|min:6',
		]);

		if (!$validator->passes()) {
			throw new RuntimeException($validator->errors()->first());
		}

		return $this->create($data);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create($data) {
		$user = User::create([
			'name' => $data['name'],
			'mobile' => $data['mobile'],
			'password' => bcrypt($data['password']),
		]);
		$profile = Profile::create([
			'avatar' => (new Identicon())->getImageDataUri($data['name'], 64),
		]);
		$user->assignRole('admin');
		return $user->profile()->save($profile);
	}
}
