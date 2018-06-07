<?php

namespace Stario\Icenter\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Permission {
	/**
	 * A permission can be applied to roles.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles(): BelongsToMany;

	/**
	 * Find a permission by its name.
	 *
	 * @param string $name
	 * @param string|null $guardName
	 *
	 * @throws \Icenter\Exceptions\PermissionDoesNotExist
	 *
	 * @return Permission
	 */
	public static function findByName(string $name, $guardName): Permission;
}
