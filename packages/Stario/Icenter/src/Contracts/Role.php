<?php

namespace Stario\Icenter\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Role {
	/**
	 * A role may be given various permissions.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions(): BelongsToMany;

	/**
	 * Find a role by its name and guard name.
	 *
	 * @param string $name
	 * @param string|null $guardName
	 *
	 * @return \Icenter\Contracts\Role
	 *
	 * @throws RoleDoesNotExist
	 */
	public static function findByName(string $name, $guardName): Role;

	/**
	 * Determine if the user may perform the given permission.
	 *
	 * @param string|Permission $permission
	 *
	 * @return bool
	 */
	public function hasPermissionTo($permission): bool;
}
