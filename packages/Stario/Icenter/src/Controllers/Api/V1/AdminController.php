<?php

namespace Stario\Icenter\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Stario\Icenter\Models\Admin;
use Stario\Icenter\Resources\Admin as AdminResource;

class AdminController extends Controller {

	protected $admin;

	public function __construct(Admin $admin) {
		$this->admin = $admin;
	}

	public function index() {
		return AdminResource::collection($this->admin->paginate(10));
	}
	public function show($id) {
		return new AdminResource(Admin::find($id));
	}
	public function store(Request $request) {
		dd($request->all());
	}
}