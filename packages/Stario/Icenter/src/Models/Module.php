<?php
namespace Stario\Icenter\Models;
use Illuminate\Database\Eloquent\Model;
use Stario\Icenter\Models\Permission;

/**
 * Icenter模块机制
 * 每个模块属于一种权限
 */
class Module extends Model {
	public function permissions() {
		return $this->belongsTo(Permission::class);
	}
}
