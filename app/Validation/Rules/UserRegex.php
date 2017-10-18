<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\Users;

class UserRegex extends AbstractRule
{
	public function validate($input)
	{
		if (!preg_match("/([!@#$&*\"'])/", $input))
		{
			if (!preg_match("/[A-Z]/", $input))
			{
				if (preg_match("/([a-z0-9]|[a-z]|[0-9])/", $input))
				{
					return true;
				}
			}
		}
		
		return false;
	}
}