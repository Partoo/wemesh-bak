<?php

namespace Stario\Icenter\Commands;

use Illuminate\Console\Command;

class IcenterSetup extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'icenter:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup Icenter';

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

		$tasks = [
			'php artisan key:generate',
			'php artisan vendor:publish --tag=icenter --force',
			'php artisan migrate',
			'php artisan db:seed --class=IcenterSeeder',
			'composer dump-autoload',
			'php artisan passport:install',
			'php artisan storage:link',
		];

		$bar = $this->output->createProgressBar(count($tasks));
		foreach ($tasks as $task) {
			$this->performTask($task);
			$bar->advance();
		}

		$bar->finish();
		$this->comment("\n\n Mission Accomplished!\n");
	}

	/**
	 * Exec sheel with pretty print.
	 *
	 * @param  string $command
	 * @return mixed
	 */
	public function performTask($task) {
		$this->info("\n \n" . $task);
		$output = shell_exec($task);
		$this->info($output);
	}
}
