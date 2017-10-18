<?php

namespace App\Validation\Exceptions;


use Respect\Validation\Exceptions\ValidationException;


class UserRegexException extends ValidationException

{
	public static $defaultTemplates = 
	[
		self::MODE_DEFAULT => [
			self::STANDARD => 'String username = 0-9 || a-z .'
		]
	];
}