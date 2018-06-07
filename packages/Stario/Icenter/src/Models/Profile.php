<?php
namespace Stario\Icenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Stario\Icenter\Models\Admin;

// use Star\ICenter\Events\ModelUpdated;

class Profile extends Model {
	use Notifiable;

	protected $guarded = ['id'];

	// protected $events = ['updated' => ModelUpdated::class];

	public function admin() {
		return $this->hasOne(Admin::class);
	}
}
