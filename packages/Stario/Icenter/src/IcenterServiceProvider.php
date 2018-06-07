<?php
namespace Stario\Icenter;

use Illuminate\Support\ServiceProvider;
use Stario\Icenter\Commands\CreateAdmin;
use Stario\Icenter\Commands\IcenterSetup;
use Stario\Icenter\Contracts\Permission as PermissionContract;
use Stario\Icenter\Contracts\Role as RoleContract;

class IcenterServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(PermissionRegistrar $permissionLoader) {
		// Publish the migration
		$this->publishes([
			__DIR__ . '/publications/migrations/create_permission_tables.php.stub' => $this->app->databasePath() . '/migrations/1949_07_15_000000_create_permission_tables.php',
		], 'icenter');
		$this->publishes([
			__DIR__ . '/publications/migrations/create_icenter_tables.php.stub' => $this->app->databasePath() . '/migrations/1949_07_15_100000_create_icenter_tables.php',
		], 'icenter');

		$this->publishes([
			__DIR__ . '/publications/seeds/IcenterSeeder.php.stub' => $this->app->databasePath() . '/seeds/IcenterSeeder.php',
		], 'icenter');

		$this->publishes([
			__DIR__ . '/publications/config/permission.php' => $this->app->configPath() . '/permission.php',
		], 'icenter');
		$this->publishes([
			__DIR__ . '/publications/config/permissions_menu.php' => $this->app->configPath() . '/permissions_menu.php',
		], 'icenter');

		$this->registerModelBindings();
		$permissionLoader->registerPermissions();

		if ($this->app->runningInConsole()) {
			$this->commands([
				IcenterSetup::class,
				CreateAdmin::class,
			]);
		}

		$this->loadRoutesFrom(__DIR__ . '/routes.php');
		// $this->loadViewsFrom(__DIR__ . '/publications/views', 'icenter');

		// Passport::routes(function ($router) {
		// 	$router->forAccessTokens();
		// 	$router->forPersonalAccessTokens();
		// 	$router->forTransientTokens();
		// });

		// Passport::tokensExpireIn(Carbon::now()->addMinute(1));
		// Passport::refreshTokensExpireIn(Carbon::now()->addDays(15));
	}

	public function register() {
		$this->mergeConfigFrom(
			__DIR__ . '/publications/config/permission.php', 'permission'
		);
	}

	protected function registerModelBindings() {
		$config = $this->app->config['permission.models'];

		$this->app->bind(PermissionContract::class, $config['permission']);
		$this->app->bind(RoleContract::class, $config['role']);
	}
}
