<?php

namespace Suyabay\Http\Repository;

use Suyabay\Http\Repository\Repository;


class UserRepository extends Repository
{
	public function a()
	{
		return $u = User::all();
	}
}