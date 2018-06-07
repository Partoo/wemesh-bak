<?php
namespace Stario\Icenter\Models;
use Illuminate\Database\Eloquent\Model;
use Stario\Icenter\Models\Admin;

class Unit extends Model {
	public function admins() {
		return $this->hasMany(Admin::class);
	}
}
